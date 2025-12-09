<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HyarihattoPointController extends Controller
{
    public function index()
    {
        $timeStart = Carbon::now()->startOfMonth()->format('Y-m-d');
        $timeEnd = Carbon::now()->format('Y-m-d');

        $query = Laporan::whereBetween('created_at', [$timeStart . ' 00:00:00', $timeEnd . ' 23:59:59'])
            ->whereNotNull('nama_penemu') // Hanya data dengan nama_penemu
            ->whereNotNull('npk')         // Hanya data dengan npk
            ->where('deleted_at', null);

        // Filter berdasarkan role pengguna
        if (Auth::check()) {
            if (Auth::user()->hasRole('Departement Head EHS') || Auth::user()->hasRole('Departement Head PIC')) {
                $query->whereNotNull('area_id');
            } elseif (Auth::user()->hasRole('PIC')) {
                $query->where('PIC_id', Auth::user()->id);
            } else {
                $query->whereNotNull('area_id');
            }
        }

        // Data statis untuk diagram sederhana
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']; // Label sumbu x
        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0]; // Hanya Oktober (index 9) bernilai 10
        $openData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0]; // Open untuk Oktober
        $closedData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]; // Closed untuk Oktober
        $totalData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0]; // Total untuk Oktober

        // Hitung total keseluruhan untuk ditampilkan di view
        $totalOpen = array_sum($openData);
        $totalClosed = array_sum($closedData);
        $totalFindings = $totalOpen + $totalClosed;

        // Hitung total reports (semua temuan dalam rentang waktu)
        $totalReports = $query->count();

        // Ambil 5 top reporters berdasarkan jumlah temuan
        $temuanPerOrang = $query->groupBy('nama_penemu', 'npk')
            ->selectRaw('nama_penemu, npk, COUNT(*) as jumlah_temuan')
            ->orderBy('jumlah_temuan', 'desc')
            ->get()
            ->toArray();
        $topReporters = array_slice($temuanPerOrang, 0, 5);

        // Tambahkan variabel $title, $halaman, dan $active
        $title = 'Hyarihatto Dashboard';
        $halaman = 'Hyarihatto Activity';
        $active = 'hyarihatto';

        return view('EHS.hyarihatto', compact('labels', 'data', 'openData', 'closedData', 'totalData', 'totalOpen', 'totalClosed', 'totalFindings', 'totalReports', 'topReporters', 'timeStart', 'timeEnd', 'title', 'halaman', 'active'));
    }
}