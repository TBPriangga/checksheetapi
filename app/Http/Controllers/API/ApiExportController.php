<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Exports\ExportLaporan;
use App\Exports\MonitoringAparExport;
use App\Exports\TemplateLaporanExport;
use App\Models\laporan;
use App\Models\PemeriksaanApar;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ApiExportController extends Controller
{
    /**
     * Export Laporan Patrol - Direct Download
     */
    public function exportLaporan(Request $request)
    {
        try {
            // Validasi
            $validator = Validator::make($request->all(), [
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'area_id' => 'nullable|exists:areas,id',
                'status' => 'nullable|in:open,progress,done,verified',
                'limit' => 'nullable|integer|min:1|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Check permission
            $user = auth()->user();
            if (!$user->hasAnyRole(['Admin', 'EHS', 'PIC', 'Departement Head PIC', 'Departement Head EHS'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk export laporan'
                ], 403);
            }

            // Build query
            $query = laporan::with(['area', 'auditor', 'PIC']);

            if ($request->filled('start_date')) {
                $query->whereDate('tanggal', '>=', $request->start_date);
            }

            if ($request->filled('end_date')) {
                $query->whereDate('tanggal', '<=', $request->end_date);
            }

            if ($request->filled('area_id')) {
                $query->where('area_id', $request->area_id);
            }

            if ($request->filled('status')) {
                $query->where('progress', $request->status);
            }

            $limit = $request->input('limit', 500);
            $data = $query->limit($limit)->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data untuk di export'
                ], 404);
            }

            // Generate filename
            $timestamp = Carbon::now()->format('Ymd_His');
            $fileName = "Laporan_EHS_Patrol_{$timestamp}.xlsx";

            // Direct download - Tidak save ke server
            return Excel::download(new ExportLaporan($data), $fileName);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Export gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export Monitoring APAR - Direct Download
     */
    public function exportMonitoringApar(Request $request)
    {
        try {
            // Validasi
            $validator = Validator::make($request->all(), [
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'area_id' => 'nullable|exists:areas,id',
                'status' => 'nullable|in:ok,ng,expired',
                'jenis' => 'nullable|in:Powder,CO2',
                'limit' => 'nullable|integer|min:1|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Check permission
            $user = auth()->user();
            if (!$user->hasAnyRole(['Admin', 'EHS', 'Departement Head EHS'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk export monitoring APAR'
                ], 403);
            }

            // Build query
            $query = PemeriksaanApar::with(['apar']);

            if ($request->filled('start_date')) {
                $query->whereDate('tanggal_pemeriksaan', '>=', $request->start_date);
            }

            if ($request->filled('end_date')) {
                $query->whereDate('tanggal_pemeriksaan', '<=', $request->end_date);
            }

            if ($request->filled('jenis')) {
                $query->where('jenis', $request->jenis);
            }

            if ($request->filled('area_id')) {
                $query->whereHas('apar', function($q) use ($request) {
                    $q->where('area_id', $request->area_id);
                });
            }

            $limit = $request->input('limit', 500);
            $data = $query->orderBy('tanggal_pemeriksaan', 'desc')
                         ->limit($limit)
                         ->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data untuk di export'
                ], 404);
            }

            // Filter by status jika diminta
            if ($request->filled('status')) {
                $data = $data->filter(function($item) use ($request) {
                    return $item->status === $request->status;
                });
            }

            // Generate filename
            $timestamp = Carbon::now()->format('Ymd_His');
            $fileName = "Monitoring_APAR_{$timestamp}.xlsx";

            // Direct download
            return Excel::download(new MonitoringAparExport($data), $fileName);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Export gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export by Patrol ID - Direct Download
     */
    public function exportByPatrolId(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'patrol_id' => 'required|exists:ehs_patrols,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = auth()->user();
            $patrolId = $request->input('patrol_id');

            // Get data
            $data = laporan::with(['area', 'auditor', 'PIC'])
                          ->where('patrol_id', $patrolId)
                          ->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada laporan untuk patrol ini'
                ], 404);
            }

            // Generate filename
            $laporan = $data->first()->laporan_patrol;
            $tanggal = Carbon::parse($laporan->tanggal_patrol)->format('d-m-Y');
            $fileName = "Laporan_EHS_patrol_{$laporan->area_patrol->name}_{$tanggal}.xlsx";

            // Direct download
            return Excel::download(new ExportLaporan($data), $fileName);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Export gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download Template Import - Direct Download
     */
    public function downloadTemplate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'area_id' => 'nullable|exists:areas,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $areaId = $request->input('area_id');

            // Generate filename
            $timestamp = Carbon::now()->format('Ymd_His');
            $fileName = "Template_Import_Laporan_{$timestamp}.xlsx";

            // Direct download
            return Excel::download(new TemplateLaporanExport($areaId), $fileName);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Download template gagal: ' . $e->getMessage()
            ], 500);
        }
    }
}