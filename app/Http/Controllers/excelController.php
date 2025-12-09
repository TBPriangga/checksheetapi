<?php

namespace App\Http\Controllers;
use App\exports\UsersExport;
use App\exports\genbaExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Models\laporan;
use App\Models\ehs_patrol;
use Carbon\Carbon;

class excelController extends Controller
{
    // private $excel;

    // public function __construct(Excel $excel) {
    //     $this->excel = $excel;
    // }

    public function export(Request $request)
    {
        if($request->tipe_tabel == "laporan_patrol") {
            $laporan = ehs_patrol::where('id', $request->patrol_id)->first();
            $tanggal = Carbon::createFromFormat('Y-m-d', $laporan->tanggal_patrol)->format('d-m-Y');
            $nama_laporan = "Laporan EHS patrol ".$laporan->area_patrol->name . " tanggal ". $tanggal. ".xlsx";
        } else {
            $nama_laporan = "Laporan EHS patrol.xlsx";
        }
        
        return (new UsersExport)->setParameter($request->all())->download($nama_laporan);
        
    }

    public function genba_export(Request $request)
    {
        return (new genbaExport)->setParameter($request->all())->download('invoices.xlsx');
    }
    
}
