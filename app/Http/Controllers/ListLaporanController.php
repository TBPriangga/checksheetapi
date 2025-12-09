<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ListLaporanController extends Controller
{
    public function index(Request $request)
    {
        \Log::info('List Laporan Index Request', [
            'method' => $request->method(),
            'input' => $request->all(),
            'is_ajax' => $request->ajax()
        ]);

        // Ambil filter dari request
        $area_id = $request->input('area');
        $npk = $request->input('npk');

        // Query dasar dengan filter NPK not null
        $query = Laporan::with(['area'])->select('laporan.*')->whereNotNull('npk');

        // Terapkan filter tambahan
        if ($area_id) {
            $query->where('area_id', $area_id);
            \Log::info('Applying area filter', ['area_id' => $area_id]);
        }
        if ($npk) {
            $query->where('npk', 'like', '%' . $npk . '%');
            \Log::info('Applying npk filter', ['npk' => $npk]);
        }

        // Jika request adalah AJAX dari DataTables
        if ($request->ajax()) {
            \Log::info('AJAX Request Received', ['params' => $request->all()]);

            // DataTables server-side parameters
            $draw = $request->input('draw', 1);
            $start = (int) $request->input('start', 0);
            $length = (int) $request->input('length', 10);
            $search = $request->input('search.value');
            $order = $request->input('order.0');
            $orderColumnIndex = $order['column'] ?? 1;
            $orderDir = $order['dir'] ?? 'asc';

            // Map DataTables column index to database column
            $columnMap = [
                1 => 'created_at',
                2 => 'nama_penemu',
                3 => 'npk',
                4 => 'area.name',
                5 => 'temuan',
                6 => 'potensi_bahaya'
            ];
            $orderColumn = $columnMap[$orderColumnIndex] ?? 'created_at';

            // Apply global search
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_penemu', 'like', '%' . $search . '%')
                      ->orWhere('npk', 'like', '%' . $search . '%')
                      ->orWhere('temuan', 'like', '%' . $search . '%')
                      ->orWhere('potensi_bahaya', 'like', '%' . $search . '%')
                      ->orWhereHas('area', function ($q) use ($search) {
                          $q->where('name', 'like', '%' . $search . '%');
                      });
                });
                \Log::info('Applying global search', ['search' => $search]);
            }

            // Get total records before filtering
            $totalRecords = Laporan::whereNotNull('npk')->count();
            \Log::info('Total records', ['totalRecords' => $totalRecords]);

            // Get filtered records count
            $totalFiltered = $query->count();
            \Log::info('Total filtered records', ['totalFiltered' => $totalFiltered]);

            // Apply sorting
            if ($orderColumn === 'area.name') {
                $query->join('areas', 'laporan.area_id', '=', 'areas.id')
                      ->orderBy('areas.name', $orderDir);
            } else {
                $query->orderBy($orderColumn, $orderDir);
            }
            \Log::info('Sorting applied', ['column' => $orderColumn, 'direction' => $orderDir]);

            // Apply pagination
            $laporans = $query->skip($start)->take($length)->get();
            \Log::info('Laporan data fetched', ['count' => $laporans->count(), 'data' => $laporans->toArray()]);

            // Format data for DataTables
            $data = $laporans->map(function ($laporan, $index) use ($start) {
                return [
                    'DT_RowIndex' => $start + $index + 1,
                    'created_at' => $laporan->created_at ? $laporan->created_at->format('d-m-Y') : 'null',
                    'nama_penemu' => $laporan->nama_penemu ?? 'null',
                    'npk' => $laporan->npk ?? 'null',
                    'area_name' => $laporan->area ? $laporan->area->name : 'null',
                    'temuan' => $laporan->temuan ?? 'null',
                    'potensi_bahaya' => $laporan->potensi_bahaya ?? 'null'
                ];
            })->toArray();

            // Hitung total laporan dan total poin untuk AJAX response
            $totalLaporan = $totalFiltered;
            $totalPoin = $totalFiltered; // 1 temuan = 1 poin

            return response()->json([
                'draw' => (int) $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalFiltered,
                'data' => $data,
                'totalLaporan' => $totalLaporan,
                'totalPoin' => $totalPoin
            ]);
        }

        // Non-AJAX request (initial page load)
        $totalLaporan = $query->count();
        $totalPoin = $totalLaporan; // 1 temuan = 1 poin

        // Ambil semua area untuk filter dropdown
        $areas = Area::all();
        \Log::info('Areas Loaded', ['areas' => $areas->toArray()]);

        return view('EHS.ListLaporan', [
            'halaman' => 'Hyarihatto Activity',
            'active' => 'list-laporan',
            'title' => 'List Laporan',
            'areas' => $areas,
            'area_id' => $area_id,
            'npk' => $npk,
            'totalLaporan' => $totalLaporan,
            'totalPoin' => $totalPoin
        ]);
    }

    public function exportPdf(Request $request)
    {
        \Log::info('Export PDF Laporan Request', [
            'query_params' => $request->query(),
            'all_params' => $request->all()
        ]);

        // AMBIL FILTER LANGSUNG DARI REQUEST (area & npk)
        $area_id = $request->input('area');  // Bisa dari GET atau POST
        $npk = $request->input('npk');

        \Log::info('Filters applied for PDF', [
            'area_id' => $area_id ?: 'Semua Area',
            'npk' => $npk ?: 'Semua NPK'
        ]);

        // QUERY DATABASE LANGSUNG - SAMA PERSIS SEPERTI DATATABLES FILTER
        $query = Laporan::with(['area'])
            ->select('laporan.*')
            ->whereNotNull('npk'); // Tambahkan filter NPK not null

        // TERAPKAN FILTER JIKA ADA
        if ($area_id) {
            $query->where('area_id', $area_id);
            \Log::info('Applied area filter:', ['area_id' => $area_id]);
        }
        if ($npk) {
            $query->where('npk', 'like', '%' . $npk . '%');
            \Log::info('Applied NPK filter:', ['npk' => $npk]);
        }

        // AMBIL SEMUA DATA SESUAI FILTER (ORDER BY TANGGAL DESC)
        $laporans = $query->orderBy('created_at', 'desc')->get();
        
        \Log::info('PDF Data Fetched', [
            'total_records' => $laporans->count(),
            'sample_data' => $laporans->take(3)->toArray()
        ]);

        // HITUNG TOTAL
        $totalLaporan = $laporans->count();
        $totalPoin = $totalLaporan;

        // NAMA FILTER UNTUK HEADER PDF
        $areaName = $area_id ? Area::find($area_id)?->name ?? 'Area Tidak Ditemukan' : 'Semua Area';
        $npkFilter = $npk ?: 'Semua NPK';

        // GENERATE PDF
        $pdf = Pdf::loadView('PDF.laporan', [
            'laporans' => $laporans,
            'totalLaporan' => $totalLaporan,
            'totalPoin' => $totalPoin,
            'areaName' => $areaName,
            'npkFilter' => $npkFilter,
            'tanggalCetak' => now()->format('d-m-Y H:i')
        ]);

        $pdf->setPaper('A4', 'landscape');

        // NAMA FILE DINAMIS BERDASARKAN FILTER
        $filename = 'Laporan_Temuan_';
        if ($area_id) $filename .= 'Area_' . str_replace(' ', '_', $areaName) . '_';
        if ($npk) $filename .= 'NPK_' . $npk . '_';
        $filename .= now()->format('Ymd_His') . '.pdf';

        return $pdf->download($filename);
    }
}