<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\area;
use App\Models\User;
use App\Models\activity_log;
use App\Models\user_notification_count;
use App\Models\laporan;
use App\Models\ehs_patrol;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Mail\urgentMail;
use App\Mail\penanggulanganMail;
use App\Mail\approvePIC;
use App\Mail\approveHeadEHS;
use App\Mail\tolakTemuan;
use App\Mail\verifyEHSMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class patrolEHSController extends Controller
{
    public function index(Request $request)
    {
        $areas = area::all();
        \Log::info('patrolEHSController::index called', ['user_id' => auth()->user()->id]);

        if ($request->ajax()) {
            $columns = [
                0 => 'id',
                1 => 'area',
                2 => 'tanggal',
                3 => 'action',
            ];

            $limit = $request->input('length', 10);
            $start = $request->input('start', 0);
            $orderColumnIndex = $request->input('order.0.column', 0);
            $orderColumnName = $columns[$orderColumnIndex] ?? 'tanggal_patrol';
            $dir = $request->input('order.0.dir', 'desc') === 'asc' ? 'desc' : 'asc';

            if ($orderColumnName === 'id') {
                $orderColumnName = 'tanggal_patrol';
            }

            try {
                $timeStart = Carbon::createFromFormat('d/m/Y', $request->input('timeStart', '01/01/2020'))->format('Y-m-d');
                $timeEnd = Carbon::createFromFormat('d/m/Y', $request->input('timeEnd', now()->format('d/m/Y')))->format('Y-m-d');
            } catch (\Exception $e) {
                \Log::error('Invalid date format in patrolEHSController::index', ['timeStart' => $request->input('timeStart'), 'timeEnd' => $request->input('timeEnd'), 'error' => $e->getMessage()]);
                return response()->json(['error' => 'Invalid date format'], 400);
            }

            $query = ehs_patrol::with(['area', 'laporan_patrol'])
                ->whereBetween('tanggal_patrol', [$timeStart, $timeEnd])
                ->whereNull('deleted_at');

            if (auth()->user()->hasRole(['Departement Head EHS', 'EHS'])) {
                // EHS dan Dept Head EHS melihat semua patrol
            } else {
                $query->whereHas('area', function ($q) {
                    $q->whereIn('id', auth()->user()->area->pluck('area_id'));
                });
            }

            $totalData = ehs_patrol::count();
            $totalFiltered = $query->count();

            $patrols = $query->orderBy($orderColumnName, $dir)
                ->skip($start)
                ->take($limit)
                ->get();

            $data = [];
            foreach ($patrols as $index => $patrol) {
                $nestedData = [];
                $nestedData['id'] = $start + $index + 1;
                $nestedData['area'] = $patrol->area->name ?? 'N/A';
                $nestedData['tanggal'] = $patrol->tanggal_patrol->format('d/m/Y');
                $nestedData['action'] = '<a href="' . route('patrolEhsDetail', ['id' => $patrol->id]) . '" class="btn btn-info btn-sm">Detail</a>';
                if (auth()->user()->hasRole('EHS')) {
                    $nestedData['action'] .= ' <a href="' . route('patrolEhsEdit', ['id' => $patrol->id]) . '" class="btn btn-warning btn-sm">Edit</a>';
                    $nestedData['action'] .= ' <a href="' . route('patrolEhsDelete', ['id' => $patrol->id]) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus patrol?\')">Hapus</a>';
                }
                $data[] = $nestedData;
            }

            \Log::info('patrolEHSController::index data fetched', ['total' => $totalFiltered, 'data_count' => count($data)]);

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalFiltered,
                'data' => $data
            ]);
        }

        return view('patrolEHS', [
            'title' => 'EHS Patrol',
            'active' => 'patrolEhs',
            'halaman' => 'EHS Patrol',
            'areas' => $areas
        ]);
    }

    public function show($id)
    {
        $laporan = ehs_patrol::with(['area', 'laporan_patrol' => function ($query) {
            $query->whereNull('deleted_at')->with(['auditor', 'PIC', 'area']);
        }])->findOrFail($id);

        \Log::info('patrolEHSController::show called', ['patrol_id' => $id, 'temuan_count' => $laporan->laporan_patrol->count()]);

        $exportVisible = auth()->user()->hasRole(['EHS', 'Departement Head EHS']);
        $EHSApproveVisible = auth()->user()->hasRole('EHS') && $laporan->laporan_patrol()->where('progress', 11)->whereNotNull('ACC_Dept_Head_PIC_At')->exists();
        $DeptEHSApproveVisible = auth()->user()->hasRole('Departement Head EHS') && $laporan->laporan_patrol()->where('progress', 12)->whereNotNull('ACC_EHS_At')->exists();
        $verifikasiVisible = auth()->user()->hasRole('Departement Head EHS') && auth()->user()->area()->where('area_id', $laporan->area_id)->exists();

        return view('detailPatrol', [
            'title' => 'Detail Patrol',
            'active' => 'patrolEhs',
            'halaman' => 'EHS Patrol',
            'laporan' => $laporan,
            'exportVisible' => $exportVisible,
            'EHSApproveVisible' => $EHSApproveVisible,
            'DeptEHSApproveVisible' => $DeptEHSApproveVisible,
            'verifikasiVisible' => $verifikasiVisible
        ]);
    }

    public function create() {
        
        if ( auth()->user()->getRoleNames()->first() !=='EHS'){
            return redirect('/patrolEHS')->with('error', 'Pembuatan Laporan hanya bisa dilakukan oleh EHS');
        }

        $area = area::all();

        return view('EHS.patrol.createPatrol', 
        ['title' => 'Pembuatan Laporan Patrol',
        'active' => 'Laporan Patrol',
         'halaman' => "Laporan",
         'areas' => $area]);
    }

    public function store(Request $request) {

        // Memeriksa apakah pengguna memiliki peran EHS
        if ( auth()->user()->getRoleNames()->first() !=='EHS'){
            return redirect('/patrolEHS')->with('error', 'Pembuatan Laporan hanya bisa dilakukan oleh EHS');
        }

        // Melakukan validasi data yang diterima dari request
        $validateData = $request->validate([
            'area_id' => 'required',
            'tanggal_patrol' => 'required',
        ]);

        // Mengubah format tanggal dari input menjadi format yang sesuai
        $validateData['tanggal_patrol'] = Carbon::createFromFormat('d/m/Y', $validateData['tanggal_patrol'])->format('Y-m-d');

        // Membuat laporan patrol baru dengan data yang divalidasi
        $ehs_patrol = ehs_patrol::create($validateData);

        return redirect("/patrolEHS/$ehs_patrol->id")->with('success', 'Data Berhasil ditambahkan');
    }

    public function detail($id) {

        // Mengambil data laporan patrol berdasarkan ID
        $laporan_patrol = ehs_patrol::where('id', $id)->first();
        if($laporan_patrol == null) {
            return redirect('/patrolEHS')->with('error', 'Data laporan patrol tidak ditemukan');
        }
        if(auth()->user()->hasRole(['Departement Head PIC', 'PIC'])){

            foreach($laporan_patrol->area_patrol->area as $user){
                if($user->user_id == auth()->user()->id){
                    $picarea = true;
                    break;
                }
                else {
                    $picarea = false;
                }
            }
            if(!$picarea){
                if(!auth()->user()->hasRole(['Departement Head EHS'])){
                    return redirect('/patrolEHS')->with('error', 'Halaman tidak bisa diakses');
                }
            }
        }
        
        

        // Inisialisasi variabel untuk menentukan visibilitas tombol-tombol aksi
        $PICApproveVisible = false; // Visibilitas tombol 'Minta Approval' untuk PIC
        $EHSApproveVisible = false; // Visibilitas tombol 'Minta Approval' untuk EHS
        $verifikasiVisible = false; // Visibilitas tombol 'Minta Verifikasi' untuk Dept Head PIC
        $DeptEHSApproveVisible = false; // Visibilitas tombol 'Kirim Notifikasi' untuk Dept Head EHS

        // Memeriksa peran pengguna untuk menentukan visibilitas tombol-tombol aksi
        
        if(auth()->user()->hasRole(['EHS'])) {
            // Jika temuan sudah diapprove oleh Dept Head PIC tetapi belum disetujui oleh Departement Head EHS
            foreach($laporan_patrol->temuan as $temuan) {
                if($temuan->verify_submit_at != null && $temuan->ACC_Dept_Head_EHS_At == null && $temuan->deleted_at == null) {
                    $EHSApproveVisible = true;
                    break;
                } else {
                    $EHSApproveVisible = false;
                }
            }
        } 

        if (auth()->user()->hasRole(['PIC'])){
            // Jika temuan sudah diselesaikan oleh PIC tetapi belum disetujui oleh Departement Head PIC
            foreach($laporan_patrol->temuan as $temuan) {
                if($temuan->progress == 10 && $temuan->ACC_Dept_Head_PIC == null  && $temuan->deleted_at == null) {
                    $PICApproveVisible = true;
                    break;
                } else {
                    $PICApproveVisible = false;
                }
            }
        }
        
        if (auth()->user()->hasRole(['Departement Head PIC'])){
            // Jika semua temuan sudah di approve oleh Dept Head PIC tetapi belum diverifikasi oleh EHS
            foreach($laporan_patrol->temuan as $temuan) {
                if($temuan->progress == 11 && $temuan->verify_submit_at == null  && $temuan->deleted_at == null) {
                    foreach(auth()->user()->area as $area_pic) {
                        if( $temuan->area->id == $area_pic->area_id){
                            $verifikasiVisible = true;
                            break;
                        }
                    }
                    if($verifikasiVisible){
                        break;
                    }
                } else {
                    $verifikasiVisible = false;
                }
            }
        }

        if (auth()->user()->hasRole(['Departement Head EHS'])){
            // Jika semua temuan sudah diselesaikan, diverifikasi oleh EHS, dan disetujui oleh Departement Head EHS
            foreach($laporan_patrol->temuan as $temuan) {
                if($temuan->progress == 13 && $temuan->verify_submit_at != null && $temuan->ACC_Dept_Head_EHS_At != null  && $temuan->deleted_at == null) {
                    $DeptEHSApproveVisible = true;
                    break;
                } else {
                    $DeptEHSApproveVisible = false;
                }
            }
        }

        // Memeriksa apakah terdapat temuan untuk menentukan visibilitas tombol 'Export'
        if (auth()->user()->hasRole(['EHS'])){

            $temuan = laporan::where('patrol_id', $laporan_patrol->id)->orderBy('progress','asc')->orderBy('rank', 'asc')->orderBy('created_at','desc')->get();
        }else{
            $temuan = laporan::where('patrol_id', $laporan_patrol->id)->orderBy('progress','asc')->whereNull('deleted_at')->orderBy('rank', 'asc')->orderBy('created_at','desc')->get();
        }
        if($temuan->isEmpty()){
            $exportVisible = false;
        } else {
            $exportVisible = true;
        }

        return view('EHS.patrol.detailPatrol', 
        ['title' => 'Pembuatan Laporan Patrol',
        'active' => 'Laporan Patrol',
         'halaman' => "Laporan",
         'temuans' => $temuan,
         'laporan' => $laporan_patrol,
         'exportVisible' => $exportVisible,
         'EHSApproveVisible' => $EHSApproveVisible,
         'PICApproveVisible' => $PICApproveVisible,
         'verifikasiVisible' => $verifikasiVisible,
         'DeptEHSApproveVisible' => $DeptEHSApproveVisible,
        ]);
    }

    public function edit($id) {

        if ( auth()->user()->getRoleNames()->first() !=='EHS'){
            return redirect('/patrolEHS')->with('error', 'Edit Laporan patrol hanya bisa dilakukan oleh EHS');
        }
        $laporan_patrol = ehs_patrol::where('id', $id)->first();

        if($laporan_patrol == null) {
            return redirect('/patrolEHS')->with('error', 'Data laporan patrol tidak ditemukan');
        }
        
        if($laporan_patrol->deleted_at != null) {
            return redirect('/patrolEHS')->with('error', 'tidak bisa melakukan akses halaman ini, laporan tidak valid');
        }
        $area = area::all();

        return view('EHS.patrol.editPatrol', 
        ['title' => 'Pembuatan Laporan Patrol',
        'active' => 'Laporan Patrol',
         'halaman' => "Laporan",
         'laporan' => $laporan_patrol,
         'areas' => $area]);
    }

    public function update(Request $request) {

        if ( auth()->user()->getRoleNames()->first() !=='EHS'){
            return redirect('/patrolEHS')->with('error', 'Pembuatan Laporan hanya bisa dilakukan oleh EHS');
        }

        $validateData = $request->validate([
            'area_id' => 'required',
            'tanggal_patrol' => 'required',
        ]);

        $validateData['tanggal_patrol'] = Carbon::createFromFormat('d/m/Y', $validateData['tanggal_patrol'])->format('Y-m-d');

        $laporan =  ehs_patrol::where('id' ,$request->id)->first();
        $laporan->update($validateData);

        return redirect('/patrolEHS')->with('success', 'Data Berhasil di ubah');
    }

    public function destroy($id) {

        if ( auth()->user()->getRoleNames()->first() !=='EHS'){
            return redirect('/patrolEHS')->with('error', 'Edit Laporan patrol hanya bisa dilakukan oleh EHS');
        }
        $laporans = laporan::where('patrol_id', $id)->get();
        
        foreach($laporans as $laporan){
            $laporan->update(['deleted_at' => now()]);
        }
        
        ehs_patrol::where('id', $id)->update(['deleted_at' => now()]);

        return redirect('/patrolEHS')->with('success', 'Data Berhasil di hapus');
    }

    public function needApproveTemuanPIC(Request $request) {
        $laporan = laporan::where('id', $request->id)->first();

        $count = null;
            foreach($laporan->area->area as $Dept_Head_PIC){
                if($Dept_Head_PIC->user->hasRole(['Departement Head PIC'])){
                    // Mail::to('mahsunmuh0@gmail.com')->send(new penanggulanganMail($laporan,$count));
                    Mail::to($Dept_Head_PIC->user->email)->send(new penanggulanganMail($laporan,$count));
                }
            }

    session()->flash('success', 'Pesan email permintaan approval telah dikirim');

    // Redirect back
    return back();
        
    }

    public function needApproveTemuanPICALL(Request $request) {
        $count = laporan::where('patrol_id', $request->patrol_id)
                            ->where('progress', 10)
                            ->where('ACC_Dept_Head_PIC_At', null)
                            ->where('deleted_at', null)->count();
        if ($count == 0) {
            session()->flash('error', 'Tidak ada laporan yang membutuhkan approval');

            // Redirect back
            return back();
        }
        $laporan = ehs_patrol::where('id', $request->patrol_id)->first();
        
            foreach($laporan->area_patrol->area as $Dept_Head_PIC){
                if($Dept_Head_PIC->user->hasRole(['Departement Head PIC'])) {
                    // Mail::to('mahsunmuh0@gmail.com')->send(new penanggulanganMail($laporan,$count));
                    Mail::to($Dept_Head_PIC->user->email)->send(new penanggulanganMail($laporan,$count));
                }
            }

    session()->flash('success', 'Pesan email permintaan approval telah dikirim');

    // Redirect back
    return back();
        
    }

    public function needVerifyEHS(Request $request) {
        
        $laporan = laporan::where('id', $request->id)->first();
        $count = null; 
        if ($laporan->genba_id != null){
            foreach($users as $user){
                if($user->roles[0]->name == "EHS"){
                    // Mail::to('mahsunmuh0@gmail.com')->send(new approvePIC($laporan));
                    Mail::to($user->email)->send(new approvePIC($laporan));
                }
            }
        } else {
            // Mail::to('mahsunmuh0@gmail.com')->send(new approvePIC($laporan,$count));
            Mail::to($laporan->auditor->email)->send(new approvePIC($laporan,$count));
        }

    session()->flash('success', 'Pesan email permintaan verifikasi telah dikirim');

    // Redirect back
    return back();
        
    }

    public function needVerifyEHSAll(Request $request) {
        

        $count = laporan::where('patrol_id', $request->patrol_id)
                            ->where('progress', 11)
                            ->where('verify_submit_at', null)
                            ->where('deleted_at', null)->count();
        if ($count == 0) {
            session()->flash('error', 'Tidak ada laporan yang membutuhkan Verifikasi');

            // Redirect back
            return back();
        }

        $laporan = ehs_patrol::where('id', $request->patrol_id)->first();
        
        // Mail::to('mahsunmuh0@gmail.com')->send(new approvePIC($laporan,$count));
        Mail::to($laporan->temuan[0]->auditor->email)->send(new approvePIC($laporan,$count));

    session()->flash('success', 'Pesan email permintaan Verifikasi telah dikirim kepada EHS yang bersangkutan');

    // Redirect back
    return back();
        
    }

    public function needApproveTemuanEHS(Request $request) {
        
        $users = user::all();
        $laporan = laporan::where('id', $request->id)->first();
        $count = null;
        foreach($users as $user){
            if($user->hasRole(['Departement Head EHS'])){
              
                // Mail::to("mahsunmuh0@gmail.com")->send(new verifyEHSMail($laporan,$count));
                Mail::to($user->email)->send(new verifyEHSMail($laporan,$count));
            }
        }

    session()->flash('success', 'Pesan email permintaan Approval telah dikirim');

    // Redirect back
    return back();
        
    }

    public function needApproveTemuanEHSAll(Request $request) {
        

        $count = laporan::where('patrol_id', $request->patrol_id)
                            ->where('progress', 12)
                            ->where('ACC_Dept_Head_EHS_At', null)
                            ->where('deleted_at', null)->count();

        if ($count == 0) {
            session()->flash('error', 'Tidak ada laporan yang membutuhkan Approval');

            // Redirect back
            return back();
        }
        $laporan = ehs_patrol::where('id', $request->patrol_id)->first();
        $users = user::all();
        foreach($users as $user){
            if($user->hasRole(['Departement Head EHS'])){
              
                // Mail::to("mahsunmuh0@gmail.com")->send(new verifyEHSMail($laporan,$count));
                Mail::to($user->email)->send(new verifyEHSMail($laporan,$count));
            }
        }
        
        

    session()->flash('success', 'Pesan email permintaan Approval telah dikirim');

    // Redirect back
    return back();
        
    }

    public function ApprovedDeptHeadEHS(Request $request) {
        
        $users = user::all();
        $laporan = laporan::where('id', $request->id)->first();
        $count = null;
        Mail::to($laporan->auditor->email)->send(new approveHeadEHS($laporan,$count));

        if($laporan->dept_PIC->id != auth()->user()->id){
            Mail::to($laporan->dept_PIC->email)->send(new approveHeadEHS($laporan,$count));
        }

        Mail::to($laporan->PIC->email)->send(new approveHeadEHS($laporan,$count));

    session()->flash('success', 'Pesan email telah dikirim');

    // Redirect back
    return back();
        
    }

    public function ApprovedDeptHeadEHSAll(Request $request) {
        
        $count = laporan::where('patrol_id', $request->patrol_id)
                            ->where('progress', 13)
                            ->whereNotNull('ACC_Dept_Head_EHS_At')
                            ->where('deleted_at', null)->count();

        if ($count == 0) {
            session()->flash('error', 'Tidak ada laporan yang sudah di approve oleh Dept Head EHS');

            // Redirect back
            return back();
        }

        $laporan = ehs_patrol::where('id', $request->patrol_id)->first();
        $laporan_patrol = laporan::where('patrol_id', $request->patrol_id)
                            ->where('progress', 13)
                            ->whereNotNull('ACC_Dept_Head_EHS_At')
                            ->where('deleted_at', null)->first();
        $users = user::all();

        Mail::to($laporan_patrol->auditor->email)->send(new approveHeadEHS($laporan_patrol,$count));
        if($laporan_patrol->dept_PIC->id != auth()->user()->id){
        Mail::to($laporan_patrol->dept_PIC->email)->send(new approveHeadEHS($laporan_patrol,$count));
        }

        // Mail::to("mahsunmuh0@gmail.com")->send(new approveHeadEHS($laporan,$count));
        Mail::to($laporan_patrol->PIC->email)->send(new approveHeadEHS($laporan,$count));


    session()->flash('success', 'Pesan email telah dikirim');

    // Redirect back
    return back();
        
    }

    
}
