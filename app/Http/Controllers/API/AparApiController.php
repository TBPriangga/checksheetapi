<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Apar;
use App\Models\PemeriksaanApar;
use App\Http\Resources\AparResource;
use App\Http\Resources\PemeriksaanAparResource;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class AparApiController extends Controller
{
    /**
     * Get All APAR (with filtering & pagination)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Apar::with('latestCheck');

        // Filter by area
        if ($request->has('area_id')) {
            $query->where('area_id', $request->area_id);
        }

        // Filter by jenis
        if ($request->has('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter by status
        if ($request->has('status')) {
            $status = $request->status;
            $query->whereHas('latestCheck', function(Builder $q) use ($status) {
                if ($status === 'inspected') {
                    // Hanya yang OK dan tidak expired
                    $ngFields = ['segitiga_dua_arah', 'segitiga_apar', 'nomor_apar', 'pin_pengaman', 'segel', 'selang', 'nozzle', 'badan_tabung', 'handle', 'label_apar', 'akses_apar', 'layout'];
                    foreach ($ngFields as $field) {
                        $q->where($field, 'OK');
                    }
                } elseif ($status === 'need_attention') {
                    // Ada NG
                    $q->where(function(Builder $query) {
                        $ngFields = ['segitiga_dua_arah', 'segitiga_apar', 'nomor_apar', 'pin_pengaman', 'segel', 'selang', 'nozzle', 'badan_tabung', 'handle', 'label_apar', 'akses_apar', 'layout'];
                        foreach ($ngFields as $field) {
                            $query->orWhere($field, 'NG');
                        }
                    });
                }
            });
            
            if ($status === 'need_inspection') {
                $query->whereDoesntHave('latestCheck');
            }
        }

        // Search by kode_apar or lokasi
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function(Builder $q) use ($search) {
                $q->where('kode_apar', 'LIKE', "%{$search}%")
                  ->orWhere('lokasi_apar', 'LIKE', "%{$search}%");
            });
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $apars = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => AparResource::collection($apars),
            'meta' => [
                'current_page' => $apars->currentPage(),
                'last_page' => $apars->lastPage(),
                'per_page' => $apars->perPage(),
                'total' => $apars->total(),
            ]
        ], 200);
    }

    /**
     * Get APAR by ID
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $apar = Apar::with('latestCheck')->find($id);

        if (!$apar) {
            return response()->json([
                'success' => false,
                'message' => 'APAR tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new AparResource($apar)
        ], 200);
    }

    /**
     * Verify APAR Code (for scanning)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_apar' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $apar = Apar::where('kode_apar', $request->kode_apar)
                    ->with('latestCheck')
                    ->first();

        if (!$apar) {
            return response()->json([
                'success' => false,
                'message' => 'Kode APAR tidak valid atau tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Kode APAR ditemukan.',
            'data' => new AparResource($apar)
        ], 200);
    }

    /**
     * Get APAR Inspection History
     * 
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function history($id, Request $request)
    {
        $apar = Apar::find($id);

        if (!$apar) {
            return response()->json([
                'success' => false,
                'message' => 'APAR tidak ditemukan'
            ], 404);
        }

        $query = $apar->pemeriksaanApars()->orderByDesc('tanggal_pemeriksaan');

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_pemeriksaan', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $perPage = $request->get('per_page', 15);
        $history = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => PemeriksaanAparResource::collection($history),
            'meta' => [
                'current_page' => $history->currentPage(),
                'last_page' => $history->lastPage(),
                'per_page' => $history->perPage(),
                'total' => $history->total(),
            ]
        ], 200);
    }

    /**
     * Get My Inspections
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function myInspections(Request $request)
    {
        $user = $request->user();
        
        $query = PemeriksaanApar::where('checker', $user->name)
                                ->with('apar')
                                ->orderByDesc('tanggal_pemeriksaan');

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_pemeriksaan', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $perPage = $request->get('per_page', 15);
        $inspections = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => PemeriksaanAparResource::collection($inspections),
            'meta' => [
                'current_page' => $inspections->currentPage(),
                'last_page' => $inspections->lastPage(),
                'per_page' => $inspections->perPage(),
                'total' => $inspections->total(),
            ]
        ], 200);
    }

    /**
     * Get Dashboard Statistics
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function dashboard(Request $request)
    {
        $today = Carbon::today();
        
        // Get all APAR
        $allApars = Apar::with('latestCheck')->get();
        
        $inspected = 0;
        $needAttention = 0;
        $needInspection = 0;
        $expiredSoon = 0;

        foreach ($allApars as $apar) {
            $check = $apar->latestCheck;

            // Belum pernah dicek
            if (!$check) {
                $needInspection++;
                continue;
            }

            // Cek NG
            $ngFields = ['segitiga_dua_arah', 'segitiga_apar', 'nomor_apar', 'pin_pengaman', 'segel', 'selang', 'nozzle', 'badan_tabung', 'handle', 'label_apar', 'akses_apar', 'layout'];
            $hasNG = false;

            foreach ($ngFields as $field) {
                if ($check->$field === 'NG') {
                    $hasNG = true;
                    break;
                }
            }

            if ($apar->jenis !== 'CO2') {
                if ($check->preassure === 'NG' || $check->dikocok === 'NG') {
                    $hasNG = true;
                }
            }

            // Cek expired (2 bulan sebelum)
            if ($check->expired_date) {
                $expired = Carbon::parse($check->expired_date)->startOfDay();
                $warningDate = $expired->copy()->subMonths(2)->startOfDay();
                
                if ($today->gte($warningDate)) {
                    $expiredSoon++;
                }
            }

            if ($hasNG) {
                $needAttention++;
            } else {
                $inspected++;
            }
        }

        // Get recent inspections
        $recentInspections = PemeriksaanApar::with('apar')
                                            ->orderByDesc('tanggal_pemeriksaan')
                                            ->limit(5)
                                            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'statistics' => [
                    'total_apar' => $allApars->count(),
                    'inspected' => $inspected,
                    'need_attention' => $needAttention,
                    'need_inspection' => $needInspection,
                    'expired_soon' => $expiredSoon,
                ],
                'recent_inspections' => PemeriksaanAparResource::collection($recentInspections),
            ]
        ], 200);
    }

    /**
     * Get APAR by Status
     * 
     * @param string $status
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function byStatus($status, Request $request)
    {
        $query = Apar::with('latestCheck');

        switch ($status) {
            case 'need-inspection':
                $query->whereDoesntHave('latestCheck');
                break;
                
            case 'need-attention':
                $query->whereHas('latestCheck', function(Builder $q) {
                    $ngFields = ['segitiga_dua_arah', 'segitiga_apar', 'nomor_apar', 'pin_pengaman', 'segel', 'selang', 'nozzle', 'badan_tabung', 'handle', 'label_apar', 'akses_apar', 'layout'];
                    $q->where(function(Builder $query) use ($ngFields) {
                        foreach ($ngFields as $field) {
                            $query->orWhere($field, 'NG');
                        }
                    });
                });
                break;
                
            case 'expired-soon':
                $query->whereHas('latestCheck', function(Builder $q) {
                    $today = Carbon::today();
                    $q->whereRaw('DATE(expired_date) <= DATE_ADD(?, INTERVAL 2 MONTH)', [$today]);
                });
                break;
                
            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Status tidak valid. Gunakan: need-inspection, need-attention, atau expired-soon'
                ], 400);
        }

        $perPage = $request->get('per_page', 15);
        $apars = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => AparResource::collection($apars),
            'meta' => [
                'current_page' => $apars->currentPage(),
                'last_page' => $apars->lastPage(),
                'per_page' => $apars->perPage(),
                'total' => $apars->total(),
            ]
        ], 200);
    }

    /**
     * Get All Areas
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function areas()
    {
        $areas = \App\Models\area::select('id', 'name')->get();

        return response()->json([
            'success' => true,
            'data' => $areas
        ], 200);
    }

    /**
     * Get APAR by Area
     * 
     * @param int $areaId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function byArea($areaId, Request $request)
    {
        $query = Apar::where('area_id', $areaId)->with('latestCheck');

        $perPage = $request->get('per_page', 15);
        $apars = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => AparResource::collection($apars),
            'meta' => [
                'current_page' => $apars->currentPage(),
                'last_page' => $apars->lastPage(),
                'per_page' => $apars->perPage(),
                'total' => $apars->total(),
            ]
        ], 200);
    }
}