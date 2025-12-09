<?php

namespace App\Http\Controllers;

use App\Models\Apar;
use App\Models\PemeriksaanApar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MonitoringAparExport;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use App\Exports\InspeksiExport;
use App\Models\AreaApar;
use App\Models\PositionsApar;

class InspeksiAparController extends Controller
{
    /**
     * halaman inspeksi apar
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $apars = Apar::all();
        $halaman = 'Inspeksi APAR';
        $title = 'Inspeksi APAR';
        $active = 'inspeksi-apar';
        return view('apar.inspeksi-apar', compact('apars', 'halaman', 'title', 'active'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'kode_apar' => 'required|string',
        ]);

        $apar = Apar::where('kode_apar', $request->kode_apar)->first();

        if (!$apar) {
            return response()->json([
                'success' => false,
                'message' => 'Kode APAR tidak ditemukan.'
            ]);
        }

        $html = view('apar.partials.form-input-tabel', compact('apar'))->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    public function verify_mobile(Request $request)
    {
        $request->validate([
            'kode_apar' => 'required|string',
        ]);

        $apar = Apar::where('kode_apar', $request->kode_apar)->first();

        // 🔹 Jika tidak ditemukan
        if (!$apar) {
            return response()->json([
                'success' => false,
                'message' => 'Kode APAR tidak valid atau tidak ditemukan.',
            ], 404);
        }

        // 🔹 Jika ditemukan dan diminta lewat API / Flutter
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kode APAR ditemukan.',
                'data' => [
                    'id' => $apar->id,
                    'kode_apar' => $apar->kode_apar,
                    'lokasi_apar' => $apar->lokasi_apar ?? '',
                    'jenis' => $apar->jenis ?? '',
                ],
            ], 200);
        }

        // 🔹 Fallback jika bukan JSON (misal diakses dari browser biasa)
        return redirect()->back()->with('error', 'Endpoint ini hanya untuk API.');
    }

    public function storeCheck(Request $request, Apar $apar)
    {
        $user = auth()->user();
        $role = $user->getRoleNames()->first();
        Log::info('Attempting to store APAR check', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_role' => $role ?? 'None',
            'apar_id' => $apar->id,
            'apar_code' => $apar->kode_apar,
        ]);

        if (!$user->hasRole(['Admin', 'EHS', 'PIC'])) {
            Log::warning('User lacks permission to check APAR', [
                'user_id' => $user->id,
                'user_role' => $role ?? 'None',
            ]);
            return redirect()->route('inspeksi-apar.index')
                ->with('error', 'Anda tidak memiliki izin untuk memeriksa APAR.');
        }

        $commonRules = [
            'segitiga_dua_arah' => 'required|in:OK,NG',
            'segitiga_apar' => 'required|in:OK,NG',
            'nomor_apar' => 'required|in:OK,NG',
            'pin_pengaman' => 'required|in:OK,NG',
            'segel' => 'required|in:OK,NG',
            'selang' => 'required|in:OK,NG',
            'nozzle' => 'required|in:OK,NG',
            'badan_tabung' => 'required|in:OK,NG',
            'handle' => 'required|in:OK,NG',
            'label_apar' => 'required|in:OK,NG',
            'expired_date' => 'required|date',
            'akses_apar' => 'required|in:OK,NG',
            'layout' => 'required|in:OK,NG',
            'dikocok' => 'nullable|in:OK,NG',
            'manufacturing_date' => 'required|date',
            'catatan_lainnya' => 'nullable|string',
            'tanggal_pemeriksaan' => 'required|date',
        ];

        $rules = $apar->jenis === 'CO2' ? array_merge($commonRules, [
            'berat_gross' => 'required|numeric|min:0',
            'berat_saat_cek' => 'required|numeric|min:0',
        ]) : array_merge($commonRules, [
            'preassure' => 'required|in:OK,NG',
            'dikocok' => 'required|in:OK,NG',
        ]);

        try {
            $validated = $request->validate($rules);
            Log::info('Validated input', $validated);

            $data = [
                'apar_id' => $apar->id,
                'jenis' => $apar->jenis,
                'checker' => $user->name,
                'segitiga_dua_arah' => $validated['segitiga_dua_arah'],
                'segitiga_apar' => $validated['segitiga_apar'],
                'nomor_apar' => $validated['nomor_apar'],
                'pin_pengaman' => $validated['pin_pengaman'],
                'segel' => $validated['segel'],
                'selang' => $validated['selang'],
                'nozzle' => $validated['nozzle'],
                'badan_tabung' => $validated['badan_tabung'],
                'handle' => $validated['handle'],
                'label_apar' => $validated['label_apar'],
                'expired_date' => $validated['expired_date'],
                'akses_apar' => $validated['akses_apar'],
                'layout' => $validated['layout'],
                'dikocok' => $apar->jenis !== 'CO2' ? $validated['dikocok'] : null,
                'manufacturing_date' => $validated['manufacturing_date'],
                'catatan_lainnya' => $validated['catatan_lainnya'],
                'tanggal_pemeriksaan' => $validated['tanggal_pemeriksaan'],
                'created_at' => Carbon::now(),
            ];

            if ($apar->jenis === 'CO2') {
                $data['berat_gross'] = $validated['berat_gross'];
                $data['berat_saat_cek'] = $validated['berat_saat_cek'];
                $data['selisih_berat'] = $validated['berat_gross'] - $validated['berat_saat_cek'];
            } else {
                $data['preassure'] = $validated['preassure'];
            }

            $pemeriksaan = PemeriksaanApar::create($data);
            Log::info('Data saved to pemeriksaan_apars', ['id' => $pemeriksaan->id]);

            $apar->update([
                'is_checked' => true,
                'last_checked' => Carbon::now(),
                'user_id' => $user->id,
            ]);
            $apar->load('latestCheck');

            return redirect()->route('inspeksi-apar.index')
                ->with('success', 'Data pengecekan APAR berhasil disimpan!');
        } catch (ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Failed to save APAR check', ['error' => $e->getMessage()]);
            return redirect()->route('inspeksi-apar.index')
                ->with('error', 'Gagal menyimpan data pengecekan APAR: ' . $e->getMessage());
        }
    }

    public function storeCheckApi(Request $request, Apar $apar)
    {
        try {
            $user = auth()->user();
            $role = $user?->getRoleNames()->first();

            if (!$user || !$user->hasRole(['Admin', 'EHS', 'PIC'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki izin untuk memeriksa APAR.',
                ], 403);
            }

            $commonRules = [
                'segitiga_dua_arah' => 'required|in:OK,NG',
                'segitiga_apar' => 'required|in:OK,NG',
                'nomor_apar' => 'required|in:OK,NG',
                'pin_pengaman' => 'required|in:OK,NG',
                'segel' => 'required|in:OK,NG',
                'selang' => 'required|in:OK,NG',
                'nozzle' => 'required|in:OK,NG',
                'badan_tabung' => 'required|in:OK,NG',
                'handle' => 'required|in:OK,NG',
                'label_apar' => 'required|in:OK,NG',
                'expired_date' => 'required|date',
                'akses_apar' => 'required|in:OK,NG',
                'layout' => 'required|in:OK,NG',
                'dikocok' => 'nullable|in:OK,NG',
                'manufacturing_date' => 'required|date',
                'catatan_lainnya' => 'nullable|string',
                'tanggal_pemeriksaan' => 'required|date',
            ];

            $rules = $apar->jenis === 'CO2' ? array_merge($commonRules, [
                'berat_gross' => 'required|numeric|min:0',
                'berat_saat_cek' => 'required|numeric|min:0',
            ]) : array_merge($commonRules, [
                'preassure' => 'required|in:OK,NG',
                'dikocok' => 'required|in:OK,NG',
            ]);

            $validated = $request->validate($rules);

            $data = [
                'apar_id' => $apar->id,
                'jenis' => $apar->jenis,
                'checker' => $user->name,
                'segitiga_dua_arah' => $validated['segitiga_dua_arah'],
                'segitiga_apar' => $validated['segitiga_apar'],
                'nomor_apar' => $validated['nomor_apar'],
                'pin_pengaman' => $validated['pin_pengaman'],
                'segel' => $validated['segel'],
                'selang' => $validated['selang'],
                'nozzle' => $validated['nozzle'],
                'badan_tabung' => $validated['badan_tabung'],
                'handle' => $validated['handle'],
                'label_apar' => $validated['label_apar'],
                'expired_date' => $validated['expired_date'],
                'akses_apar' => $validated['akses_apar'],
                'layout' => $validated['layout'],
                'dikocok' => $apar->jenis !== 'CO2' ? $validated['dikocok'] : null,
                'manufacturing_date' => $validated['manufacturing_date'],
                'catatan_lainnya' => $validated['catatan_lainnya'] ?? null,
                'tanggal_pemeriksaan' => $validated['tanggal_pemeriksaan'],
                'created_at' => now(),
            ];

            if ($apar->jenis === 'CO2') {
                $data['berat_gross'] = $validated['berat_gross'];
                $data['berat_saat_cek'] = $validated['berat_saat_cek'];
                $data['selisih_berat'] = $validated['berat_gross'] - $validated['berat_saat_cek'];
            } else {
                $data['preassure'] = $validated['preassure'];
            }

            $pemeriksaan = PemeriksaanApar::create($data);

            $apar->update([
                'is_checked' => true,
                'last_checked' => now(),
                'user_id' => $user->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data pengecekan APAR berhasil disimpan!',
                'data' => [
                    'apar' => $apar,
                    'pemeriksaan' => $pemeriksaan,
                ]
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data pengecekan APAR: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Monitoring Dashboard - UPDATED dengan status APAR
     */
    public function monitoring()
    {
        $today = Carbon::today();

        // Ambil semua APAR
        $allApars = Apar::with('latestCheck')->get()->map(function ($apar) {
            $apar->load('latestCheck');
            return $apar;
        });

        $inspected = 0;
        $needAttention = 0;
        $needInspection = 0;

        foreach ($allApars as $apar) {
            $check = $apar->latestCheck;

            if (!$check) {
                $needInspection++;
                continue;
            }

            $ngFields = ['segitiga_dua_arah','segitiga_apar','nomor_apar','pin_pengaman','segel','selang','nozzle','badan_tabung','handle','label_apar','akses_apar','layout'];
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

            if ($hasNG) {
                $needAttention++;
            } else {
                $inspected++;
            }
        }

        // TAMBAHKAN INI: $apars UNTUK PETA AREA 1
        $apars = Apar::where('area_id', 1)
            ->with(['latestCheck' => function ($q) {
                $q->orderByDesc('tanggal_pemeriksaan')->orderByDesc('id');
            }])
            ->get()
            ->map(function ($apar) {
                $apar->load('latestCheck');
                $statusData = $this->determineStatus($apar);

                $apar->computed_status = $statusData['status'];
                $apar->status_label    = $statusData['label'];
                $apar->status_color    = $statusData['color'];
                $apar->show_dot        = $statusData['dot'];

                return $apar;
            });

        $halaman = 'Monitoring APAR';
        $active = 'monitoring-apar';
        $title = 'Monitoring APAR';

        return view('APAR.monitoring-apar', compact(
            'inspected', 'needAttention', 'needInspection', 'apars',
            'halaman', 'active', 'title'
        ));
    }

    private function determineStatus($apar)
    {
        $check = $apar->latestCheck;

        if (!$check) {
            return [
                'status' => 'need_inspection',
                'label'  => 'BELUM DICEK',
                'color'  => 'bg-danger text-white',
                'dot'    => false
            ];
        }

        $ngFields = ['segitiga_dua_arah','segitiga_apar','nomor_apar','pin_pengaman','segel','selang','nozzle','badan_tabung','handle','label_apar','akses_apar','layout'];
        $hasNG = false;
        foreach ($ngFields as $field) {
            if ($check->$field === 'NG') { $hasNG = true; break; }
        }
        if (!$hasNG && $apar->jenis !== 'CO2') {
            if ($check->preassure === 'NG' || $check->dikocok === 'NG') { $hasNG = true; }
        }

        $nearExpired = false;
        if ($check->expired_date) {
            $expired = \Carbon\Carbon::parse($check->expired_date)->startOfDay();
            $warning = $expired->copy()->subMonths(2);
            $nearExpired = now()->startOfDay()->gte($warning);
        }

        if ($hasNG) {
            return [
                'status' => 'need_attention',
                'label'  => 'NG',
                'color'  => 'bg-warning text-dark',
                'dot'    => $nearExpired
            ];
        }

        return [
            'status' => 'inspected',
            'label'  => 'OK',
            'color'  => 'bg-success text-white',
            'dot'    => $nearExpired
        ];
    }

    public function partial($area)
    {
        $valid = [1, 2, 3, 4];
        if (!in_array($area, $valid)) abort(404);

        $apars = Apar::where('area_id', $area)
            ->with(['latestCheck' => function ($q) {
                $q->orderByDesc('tanggal_pemeriksaan')->orderByDesc('id');
            }])
            ->get()
            ->map(function ($apar) {
                $apar->load('latestCheck');
                $statusData = $this->determineStatus($apar);

                $apar->computed_status = $statusData['status'];
                $apar->status_label    = $statusData['label'];
                $apar->status_color    = $statusData['color'];
                $apar->show_dot        = $statusData['dot'];

                // DEBUG: LIHAT APA YANG MASUK
                \Log::info('APAR DEBUG', [
                    'id'           => $apar->id,
                    'kode'         => $apar->kode_apar,
                    'latestCheck'  => $apar->latestCheck ? [
                        'id' => $apar->latestCheck->id,
                        'tanggal' => $apar->latestCheck->tanggal_pemeriksaan,
                        'expired' => $apar->latestCheck->expired_date,
                    ] : null,
                    'computed_status' => $apar->computed_status,
                    'status_color'    => $apar->status_color,
                    'show_dot'        => $apar->show_dot,
                ]);

                return $apar;
            });

        return view("APAR.partials.area{$area}", compact('apars'));
    }
    
    public function exportMonitoring(Request $request)
    {
        // Validasi wajib ada date-start dan date-end
        $request->validate([
            'date-start' => 'required',
            'date-end'   => 'required',
        ]);

        // Parse tanggal dari format dd/mm/yyyy
        try {
            $start = Carbon::createFromFormat('d/m/Y', $request->input('date-start'))->startOfDay();
            $end   = Carbon::createFromFormat('d/m/Y', $request->input('date-end'))->endOfDay();
        } catch (\Exception $e) {
            return back()->with('error', 'Format tanggal tidak valid. Gunakan format: dd/mm/yyyy');
        }

        // Validasi logika tanggal
        if ($end->lt($start)) {
            return back()->with('error', 'Tanggal TO tidak boleh lebih kecil dari tanggal FROM.');
        }

        // Query berdasarkan range tanggal
        $data = PemeriksaanApar::with('apar')
            ->whereBetween('tanggal_pemeriksaan', [$start, $end])
            ->orderByDesc('tanggal_pemeriksaan')
            ->get();

        // Nama file dengan range tanggal
        $filename = 'Laporan_Monitoring_APAR_'
            . $start->format('Ymd') . '_sd_'
            . $end->format('Ymd') . '.xlsx';

        return Excel::download(new MonitoringAparExport($data), $filename);
    }

    public function detail(Apar $apar, Request $request)
    {
        $query = $apar->pemeriksaanApars()->orderByDesc('tanggal_pemeriksaan');

        // === FILTER PERIODE (BULAN / TAHUN) ===
        if ($request->filled('periode')) {
            $p = $request->input('periode');
            if ($p == '1') { // BULAN INI
                $query->whereMonth('tanggal_pemeriksaan', now()->month)
                    ->whereYear('tanggal_pemeriksaan', now()->year);
            } elseif ($p == '2') { // TAHUN INI
                $query->whereYear('tanggal_pemeriksaan', now()->year);
            }
        }

        // === FILTER TANGGAL DARI - SAMPAI ===
        if ($request->filled('date-start') && $request->filled('date-end')) {
            try {
                $start = Carbon::createFromFormat('d/m/Y', $request->input('date-start'))->startOfDay();
                $end   = Carbon::createFromFormat('d/m/Y', $request->input('date-end'))->endOfDay();
                $query->whereBetween('tanggal_pemeriksaan', [$start, $end]);
            } catch (\Exception $e) {
                // Format salah → abaikan
            }
        }

        $history = $query->paginate(10);

        // === HITUNG STATUS + DOT MERAH (HANYA JIKA < 2 BULAN) ===
        $statusData = $this->determineStatus($apar);

        $statusLabel = $statusData['label'];
        $statusColor = $statusData['color'];
        $showDot     = $statusData['dot']; // true hanya jika < 2 bulan dari expired

        // === HALAMAN ===
        $halaman = 'Detail APAR';
        $title   = 'Detail APAR - ' . $apar->kode_apar;
        $active  = 'monitoring-apar';

        return view('APAR.detail-apar', compact(
            'apar',
            'history',
            'statusLabel',
            'statusColor',
            'showDot',        // <--- BARU: kirim ke view
            'halaman',
            'title',
            'active'
        ));
    }

    public function historyData(Apar $apar)
    {
        $query = PemeriksaanApar::where('apar_id', $apar->id)
            ->select([
                'id', 'tanggal_pemeriksaan', 'checker', 'segitiga_dua_arah', 'segitiga_apar',
                'nomor_apar', 'pin_pengaman', 'segel', 'selang', 'nozzle', 'badan_tabung',
                'handle', 'label_apar', 'expired_date', 'akses_apar', 'layout', 'manufacturing_date',
                'catatan_lainnya', 'berat_gross', 'berat_saat_cek', 'selisih_berat',
                'preassure', 'dikocok'
            ]);

        // Filter periode
        if (request('periode') == '2') {
            $query->whereYear('tanggal_pemeriksaan', '>=', now()->subYear()->year);
        } else {
            $query->where('tanggal_pemeriksaan', '>=', now()->subMonth());
        }

        // Filter tanggal
        if (request('date-start')) {
            $query->whereDate('tanggal_pemeriksaan', '>=', request('date-start'));
        }
        if (request('date-end')) {
            $query->whereDate('tanggal_pemeriksaan', '<=', request('date-end'));
        }

        return DataTables::of($query)
            ->addColumn('status', fn($row) => $row->status)
            ->addColumn('main_status_label', fn($row) => $row->main_status_label)
            ->addColumn('main_status_color', fn($row) => $row->main_status_color)
            ->addColumn('is_near_expired', fn($row) => $row->is_near_expired)
            ->make(true);
    }

    /**
     * Export Detail APAR
     */
    public function exportDetail(Apar $apar, Request $request)
    {
        $request->validate([
            'date-start' => 'nullable|date_format:Y-m-d',
            'date-end'   => 'nullable|date_format:Y-m-d|after_or_equal:date-start',
        ]);

        $query = PemeriksaanApar::where('apar_id', $apar->id);

        if ($request->filled('date-start') && $request->filled('date-end')) {
            $query->whereBetween('tanggal_pemeriksaan', [
                $request->input('date-start'),
                $request->input('date-end')
            ]);
        }

        $data = $query->orderByDesc('tanggal_pemeriksaan')->get();

        if ($data->isEmpty()) {
            return back()->with('warning', 'Tidak ada data untuk diekspor pada rentang tanggal tersebut.');
        }

        $filename = 'Riwayat_APAR_' . $apar->kode_apar . '_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new InspeksiExport($data), $filename);
    }
}