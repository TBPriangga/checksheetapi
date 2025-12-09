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
    public function index(Request $request) {
        
        // Mendapatkan semua area
        $areas = area::all();

        if ($request->ajax()){

            // Kolom yang digunakan dalam tabel
            $columns = array( 
                0 =>'id',
                1 =>'area',
                2 =>'tanggal',
                3 =>'action',
            );

            // Batasan dan awal data yang akan ditampilkan
            $limit = $request->input('length', 10);
            $start = $request->input('start', 0);
            $orderColumnIndex = $request->input('order.0.column', 0);
            $orderColumnName = $columns[$orderColumnIndex] ?? 'tanggal_patrol';
            
            // Menentukan arah pengurutan
            if ($request->input('order.0.dir') == "asc") {
                $dir = "desc";
            } else {
                $dir = "asc";
            }
            
            // Jika nama kolom adalah "id", ganti menjadi "tanggal_patrol" untuk pengurutan
            if ($orderColumnName == "id") {
                $orderColumnName = "tanggal_patrol";
            }
            
            // Mengubah format tanggal dari input menjadi format yang sesuai
            $timeStart = Carbon::createFromFormat('d/m/Y', $request->input('timeStart'))->format('Y-m-d');
            $timeEnd = Carbon::createFromFormat('d/m/Y', $request->input('timeEnd'))->format('Y-m-d');

            // Memulai query untuk data laporan patrol
            if(auth()->user()->hasRole(['Departement Head EHS', 'EHS'])){
                $query = ehs_patrol::query()
                    ->whereBetween('tanggal_patrol', [$timeStart, $timeEnd]);
            }else{
                $query = ehs_patrol::query()
                ->whereBetween('tanggal_patrol', [$timeStart, $timeEnd])
                ->whereNull("deleted_at");
            }
            
            // Jika peran pengguna adalah PIC atau Kepala Departemen PIC
            if(!auth()->user()->hasRole(['Departement Head EHS', 'EHS'])){
                if (auth()->user()->hasRole(['Departement Head PIC', 'PIC'])) {
                    $query->select('ehs_patrols.*')->join('user_has_areas', 'user_has_areas.area_id', '=', 'ehs_patrols.area_id')
                          ->where('user_has_areas.user_id', auth()->user()->id);
                }
            } 

            // Jika area dipilih dalam filter, tambahkan kondisi untuk memilih area tersebut
            if ($request->has('area') && $request->input('area') != "") {
                $query->where('area_id', $request->input('area'));
            }

            // Menghitung total data
            $totalData = $query->count();
            $totalFiltered = $totalData; 
            
            // Memproses pencarian jika ada
            if(empty($request->input('search.value'))) {            
                $posts = $query->offset($start)
                ->limit($limit)
                ->orderBy($orderColumnName, $dir)
                ->get();
            } else {
                $search = $request->input('search.value'); 

                $posts =  $query->join('areas', 'areas.id', '=', 'ehs_patrols.area_id')
                                ->where('areas.name','LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($orderColumnName, $dir)
                ->get();
                
                $totalFiltered = $query->where('ehs_patrols.area_id','LIKE',"%{$search}%")
                ->count();
            }

            // Mendapatkan data yang relevan dan mempersiapkan untuk ditampilkan
            $data = array();
            if(!empty($posts)) {
                foreach ($posts as $index => $post) {
                    $open = laporan::where('patrol_id', $post->id)->where('progress','<', 10)->whereNull('ACC_Dept_Head_PIC_At')->whereNull('deleted_at')->count();
                    $closed = laporan::where('patrol_id', $post->id)->where('progress', 10)->whereNotNull('PIC_submit_at')->whereNull('deleted_at')->count();
                    $verified = laporan::where('patrol_id', $post->id)->where('progress', 11)->whereNotNull('ACC_Dept_Head_PIC_At')->whereNull('deleted_at')->count();
                    $approve = laporan::where('patrol_id', $post->id)->where('progress', 12)->whereNotNull('verify_submit_at')->whereNull('deleted_at')->count();
                    $clear = laporan::where('patrol_id', $post->id)->where('progress', 13)->whereNotNull('verify_submit_at')->whereNull('deleted_at')->count();
                    // $closed = laporan::where('patrol_id', $post->id)->where('progress', 11)->whereNull('verify_submit_at')->whereNull('deleted_at')->count();
                    // $verified = laporan::where('patrol_id', $post->id)->where('progress', 12)->whereNull('ACC_Dept_Head_EHS_At')->whereNull('deleted_at')->count();
                    // $approve = laporan::where('patrol_id', $post->id)->where('progress', 13)->whereNotNull('ACC_Dept_Head_EHS_At')->whereNull('deleted_at')->count();
                    $nestedData['iteration'] = $totalData - $start - $index;
                    $nestedData['area'] = $post->area_patrol->name;
                    $nestedData['tanggal'] = date('d/m/Y', strtotime($post->tanggal_patrol));                    
                    $nestedData['open'] = '<a href="' . route('patrolEhsDetail', ['id' => $post->id]) . '" style="color: #6a676c;">'.$open.'</a>' ;                   
                    $nestedData['closed'] = $closed;                    
                    $nestedData['verified'] = $verified;                    
                    $nestedData['approve'] = $approve;                 
                    $nestedData['clear'] = $clear;                 
                    $nestedData['action'] = "<td class='text-center'><a class='btn btn-info btn-block compose-mail' href='" . route('patrolEhsDetail', ['id' => $post->id]) . "'>See Detail</a></td>";

                    
                    $data[] = $nestedData;
                    
                }
            }
            
            // Mengumpulkan data untuk respons JSON
            $json_data = array(
                "draw"            => intval($request->input('draw')),  
                "recordsTotal"    => intval($totalData),  
                "recordsFiltered" => intval($totalFiltered), 
                "data"            => $data   
            );
                        
            // Mengembalikan respons JSON
            return response()->json($json_data); 
        }
        
        return view('EHS.patrol.indexPatrol', ['title' => 'Laporan Table',
                                  'active' => 'Laporan Patrol',
                                  'halaman' => "Laporan",
                                  'areas' => $areas,
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
