<?php

namespace App\Http\Controllers;

use App\Exports\TemplateLaporanExport;
use App\Imports\LaporanImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ehs_patrol;
use App\Models\laporan;
use App\Models\area;
use App\Models\User;
use App\Models\user_has_area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportLaporanController extends Controller
{
    public function index(Request $request)
    {
        $previewData = session()->get('patrol_preview', collect());
        try {
            $patrols = ehs_patrol::with('laporan_patrol')->latest()->paginate(10);
            Log::info('Loaded patrols with laporan_patrol relationship', ['count' => $patrols->count()]);
        } catch (\Exception $e) {
            Log::error('Failed to load patrols: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('importLaporan.index')->with('error', 'Gagal memuat daftar patrol: ' . $e->getMessage());
        }

        return view('EHS.import-laporan', [
            'title' => 'Import Patrol & Temuan Excel',
            'active' => 'import-laporan',
            'halaman' => 'Patrol EHS',
            'previewData' => $previewData,
            'patrols' => $patrols,
        ]);
    }

    public function downloadTemplate(Request $request)
    {
        $area_id = $request->query('area_id');
        if (!$area_id || !area::find($area_id)) {
            Log::warning('Download template gagal: Area ID tidak valid', ['area_id' => $area_id]);
            return redirect()->route('importLaporan.index')->with('error', 'Pilih area terlebih dahulu.');
        }

        return Excel::download(new TemplateLaporanExport($area_id), 'template_patrol_temuan_area_' . $area_id . '.xlsx');
    }

    public function storeExcel(Request $request)
    {
        try {
            $request->validate([
                'excel_file' => 'required|file|mimes:xlsx,xls|max:2048',
            ]);

            $file = $request->file('excel_file');
            $previewData = Excel::toCollection(new LaporanImport, $file)
                              ->first()
                              ->skip(1)
                              ->map(function ($row, $index) {
                                  // Convert Excel date serial to DD-MM-YYYY if numeric
                                  $tanggal = $row['tanggal'];
                                  if (is_numeric($tanggal)) {
                                      try {
                                          $tanggal = Date::excelToDateTimeObject($tanggal)->format('d-m-Y');
                                      } catch (\Exception $e) {
                                          Log::warning('Gagal konversi tanggal Excel', ['row' => $index + 2, 'tanggal' => $tanggal, 'error' => $e->getMessage()]);
                                          $tanggal = null;
                                      }
                                  }

                                  Log::info('Memproses baris Excel', ['row' => $index + 2, 'data' => $row]);
                                  return [
                                      'tanggal' => $tanggal,
                                      'area' => $row['area'] ?? null,
                                      'nama_penemu' => $row['nama_penemu'] ?? null,
                                      'npk' => $row['npk'] ?? null,
                                      'temuan' => $row['temuan'] ?? null,
                                      'potensi_bahaya' => $row['potensi_bahaya'] ?? null,
                                      'kategori' => $row['kategori'] ?? null,
                                      'rank' => $row['rank'] ?? null,
                                      'saran_perbaikan' => $row['saran_perbaikan'] ?? null,
                                  ];
                              })
                              ->filter(function ($row) {
                                  return !empty(array_filter($row));
                              });

            if ($previewData->isEmpty()) {
                Log::warning('File Excel kosong atau format tidak sesuai.');
                return redirect()->route('importLaporan.index')->with('error', 'File Excel kosong atau format tidak sesuai.');
            }

            session()->put('patrol_preview', $previewData);
            session()->put('patrol_excel_file', $file->store('temp'));

            Log::info('Preview data berhasil disimpan di session.', ['count' => $previewData->count()]);

            return redirect()->route('importLaporan.index')->with('success', 'Preview data siap.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            Log::error('Validasi Excel gagal: ' . implode('; ', $errorMessages));
            return redirect()->route('importLaporan.index')->with('error', 'Gagal memproses file: ' . implode('; ', $errorMessages));
        } catch (\Exception $e) {
            Log::error('Gagal memproses Excel: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('importLaporan.index')->with('error', 'Gagal memproses file: ' . $e->getMessage());
        }
    }

    public function approve(Request $request, $index)
    {
        try {
            $previewData = session()->get('patrol_preview', collect());
            if ($previewData->isEmpty() || !isset($previewData[$index])) {
                Log::warning('Data preview tidak ditemukan untuk index: ' . $index);
                return redirect()->route('importLaporan.index')->with('error', 'Data tidak ditemukan');
            }

            $data = $previewData[$index];
            Log::info('Mencoba approve data: ', ['index' => $index, 'data' => $data]);

            // Validasi data
            if (empty($data['area']) || empty($data['npk']) || empty($data['temuan']) || empty($data['kategori']) || empty($data['rank'])) {
                Log::warning('Data tidak lengkap untuk index: ' . $index, ['data' => $data]);
                return redirect()->route('importLaporan.index')->with('error', 'Data tidak lengkap. Pastikan semua kolom wajib diisi.');
            }

            $area = area::where('name', $data['area'])->first();
            $auditor = User::where('npk', $data['npk'])->first();

            if (!$area) {
                Log::warning("Area {$data['area']} tidak ditemukan di database.");
                return redirect()->route('importLaporan.index')->with('error', "Area {$data['area']} tidak ditemukan di database.");
            }
            if (!$auditor) {
                Log::warning("Auditor dengan NPK {$data['npk']} tidak ditemukan.");
                return redirect()->route('importLaporan.index')->with('error', "Auditor dengan NPK {$data['npk']} tidak ditemukan.");
            }

            // Gunakan created_at sebagai tanggal default
            $tanggal_patrol = now()->format('d-m-Y');

            // Cek atau buat patrol
            $patrol = ehs_patrol::where('area_id', $area->id)
                                ->where('tanggal_patrol', $tanggal_patrol)
                                ->first();

            if (!$patrol) {
                $patrol = ehs_patrol::create([
                    'area_id' => $area->id,
                    'tanggal_patrol' => $tanggal_patrol,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                Log::info('Patrol baru dibuat: ', ['patrol_id' => $patrol->id]);
            }

            // Cari PIC berdasarkan area_id
            $pic = user_has_areas::where('area_id', $area->id)->whereHas('user', function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->where('name', 'PIC');
                });
            })->first();

            // Gunakan auditor_id sebagai default jika PIC tidak ditemukan
            $pic_id = $pic ? $pic->user_id : $auditor->id;
            Log::info('PIC_id yang digunakan: ', ['pic_id' => $pic_id]);

            // Simpan ke tabel laporan
            $laporan = laporan::create([
                'patrol_id' => $patrol->id,
                'area_id' => $area->id,
                'auditor_id' => $auditor->id,
                'PIC_id' => $pic_id, // Gunakan pic_id yang sudah ditentukan
                'tanggal' => now()->format('Y-m-d'),
                'nama_penemu' => $data['nama_penemu'] ?? $auditor->name,
                'npk' => $data['npk'],
                'temuan' => $data['temuan'],
                'potensi_bahaya' => $data['potensi_bahaya'] ?? null,
                'kategori' => $data['kategori'],
                'rank' => $data['rank'],
                'progress' => 0,
                'deadline_date' => now()->addDays(7)->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::info('Laporan tersimpan: ', ['laporan_id' => $laporan->id]);

            $previewData->forget($index);
            session()->put('patrol_preview', $previewData);

            if ($previewData->isEmpty()) {
                $filePath = session()->get('patrol_excel_file');
                session()->forget(['patrol_preview', 'patrol_excel_file']);
                Storage::delete($filePath);
                Log::info('Session dan file sementara dihapus.');
            }

            return redirect()->route('importLaporan.index')->with('success', 'Patrol dan Temuan berhasil di-approve');
        } catch (\Exception $e) {
            Log::error('Gagal approve: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('importLaporan.index')->with('error', 'Gagal approve: ' . $e->getMessage());
        }
    }


    public function cancel(Request $request, $index)
    {
        try {
            $previewData = session()->get('patrol_preview', collect());
            if ($previewData->isEmpty() || !isset($previewData[$index])) {
                Log::warning('Data preview tidak ditemukan untuk index: ' . $index);
                return redirect()->route('importLaporan.index')->with('error', 'Data tidak ditemukan');
            }

            $previewData->forget($index);
            session()->put('patrol_preview', $previewData);

            if ($previewData->isEmpty()) {
                $filePath = session()->get('patrol_excel_file');
                session()->forget(['patrol_preview', 'patrol_excel_file']);
                Storage::delete($filePath);
                Log::info('Session dan file sementara dihapus.');
            }

            return redirect()->route('importLaporan.index')->with('success', 'Data berhasil dibatalkan');
        } catch (\Exception $e) {
            Log::error('Gagal cancel: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('importLaporan.index')->with('error', 'Gagal cancel: ' . $e->getMessage());
        }
    }

    public function saveExcel(Request $request)
    {
        try {
            $previewData = session()->get('patrol_preview', collect());
            if ($previewData->isEmpty()) {
                Log::warning('Tidak ada data preview untuk disimpan.');
                return redirect()->route('importLaporan.index')->with('error', 'Tidak ada data untuk disimpan');
            }

            Log::info('Memulai penyimpanan data preview: ', ['count' => $previewData->count()]);
            $savedRecords = 0;

            $groupedData = $previewData->groupBy(['area']);
            foreach ($groupedData as $area_name => $items) {
                $area = area::where('name', $area_name)->first();
                if (!$area) {
                    Log::warning("Area {$area_name} tidak ditemukan untuk data: ", $items->toArray());
                    continue;
                }

                // Gunakan created_at sebagai tanggal default
                $tanggal_patrol = now()->format('d-m-Y');

                // Cek atau buat patrol
                $patrol = ehs_patrol::where('area_id', $area->id)
                                    ->where('tanggal_patrol', $tanggal_patrol)
                                    ->first();

                if (!$patrol) {
                    $patrol = ehs_patrol::create([
                        'area_id' => $area->id,
                        'tanggal_patrol' => $tanggal_patrol,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    Log::info('Patrol baru dibuat: ', ['patrol_id' => $patrol->id]);
                }

                // Cari PIC berdasarkan area_id
                $pic = user_has_areas::where('area_id', $area->id)->whereHas('user', function ($query) {
                    $query->whereHas('roles', function ($q) {
                        $q->where('name', 'PIC');
                    });
                })->first();

                foreach ($items as $index => $data) {
                    // Validasi data
                    if (empty($data['area']) || empty($data['npk']) || empty($data['temuan']) || empty($data['kategori']) || empty($data['rank'])) {
                        Log::warning('Data tidak lengkap untuk index: ' . $index, ['data' => $data]);
                        continue;
                    }

                    $auditor = User::where('npk', $data['npk'])->first();
                    if (!$auditor) {
                        Log::warning("Auditor NPK {$data['npk']} tidak ditemukan untuk data: ", $data);
                        continue;
                    }

                    // Gunakan auditor_id sebagai default jika PIC tidak ditemukan
                    $pic_id = $pic ? $pic->user_id : $auditor->id;
                    Log::info('PIC_id yang digunakan: ', ['pic_id' => $pic_id]);

                    $laporan = laporan::create([
                        'patrol_id' => $patrol->id,
                        'area_id' => $area->id,
                        'auditor_id' => $auditor->id,
                        'PIC_id' => $pic_id, // Gunakan pic_id yang sudah ditentukan
                        'tanggal' => now()->format('Y-m-d'),
                        'nama_penemu' => $data['nama_penemu'] ?? $auditor->name,
                        'npk' => $data['npk'],
                        'temuan' => $data['temuan'],
                        'potensi_bahaya' => $data['potensi_bahaya'] ?? null,
                        'kategori' => $data['kategori'],
                        'rank' => $data['rank'],
                        'progress' => 0,
                        'deadline_date' => now()->addDays(7)->format('Y-m-d'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    Log::info('Laporan tersimpan: ', ['laporan_id' => $laporan->id]);
                    $savedRecords++;
                }
            }

            $filePath = session()->get('patrol_excel_file');
            session()->forget(['patrol_preview', 'patrol_excel_file']);
            Storage::delete($filePath ?? null);
            Log::info('Session dan file sementara dihapus.', ['saved_records' => $savedRecords]);

            return redirect()->route('importLaporan.index')->with('success', "Semua data berhasil disimpan ($savedRecords temuan).");
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan Excel: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('importLaporan.index')->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
    
}