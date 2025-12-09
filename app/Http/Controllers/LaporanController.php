<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\area;
use App\Models\User;
use App\Models\laporan;
use App\Mail\approvePIC;
use App\Mail\urgentMail;
use App\Mail\emailWO;
use App\Mail\tolakTemuan;
use App\Models\ehs_patrol;
// use Intervention\Image\Facades\Image;
use App\Mail\verifyEHSMail;
use Illuminate\Support\Arr;
use App\Mail\approveHeadEHS;
use App\Models\activity_log;
use Illuminate\Http\Request;
use App\Models\user_has_area;
use App\Mail\penanggulanganMail;
use App\Mail\RequestDueDateLanjutan;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Models\user_notification_count;
use Spatie\Permission\Models\Permission;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LaporanImport;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Exports\TemplateLaporanExport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;



class LaporanController extends Controller{
    public function index(Request $request) {
        
        // Mengambil peran pengguna yang saat ini masuk
        $role = auth()->user()->getRoleNames()->first();
        // Memeriksa apakah permintaan berasal dari AJAX
        if ($request->ajax()){

            // Kolom yang digunakan dalam tabel
            $columns = array( 
                0 =>'id', 
                1 =>'temuan',
                2 =>'area_id',
                3 =>'kategori',
                4 =>'rank',
                5 =>'created_at',
                6 =>'deadline_date',
                7 =>'progress',
                8 =>'progress',
            );

            // Batasan dan awal data yang akan ditampilkan
            $limit = $request->input('length', 10);
            $start = $request->input('start', 0);
            $orderColumnIndex = $request->input('order.0.column', 0);
            $orderColumnName = $columns[$orderColumnIndex] ?? 'created_at';
            $orderColumnName2 = 'rank';

            if ($request->input('order.0.dir') == "asc") {
                $dir = "asc";
            } else {
                $dir = "desc";
            }
            
            if ($orderColumnName == "id") {
                $orderColumnName = "rank";
                $orderColumnName2 = "created_at";
                $dir2 = 'desc';
            } else {
                $orderColumnName2 = "rank";
                $dir2 = 'asc';
            }

            $timeEnd = Carbon::createFromFormat('d/m/Y', $request->input('timeEnd'))->format('Y-m-d');
            $timeStart = Carbon::createFromFormat('d/m/Y', $request->input('timeStart'))->format('Y-m-d');

            if (auth()->user()->hasRole(['EHS'])) {
                if ($request->has('genba_table') && $request->input('genba_table') == "genba_table") {
                    $query = laporan::query()->whereNotNull("genba_id");
                    $genba = true;
                } else {
                    $query = laporan::query()->where("genba_id", null);
                    $genba = false;
                }
            }else{
                if ($request->has('genba_table') && $request->input('genba_table') == "genba_table") {
                    $query = laporan::query()->whereNotNull("genba_id")->where("deleted_at", null);
                    $genba = true;
                } else {
                    $query = laporan::query()->where("genba_id", null)->where("deleted_at", null);
                    $genba = false;
                }
            }
            
            
            // Memfilter berdasarkan rentang waktu jika ada
            if ($request->has('tipeTable') && $request->input('tipeTable') == "semua") {
                $query->whereBetween('created_at', [$timeStart." 00:00:00", $timeEnd." 23:59:59"]);
            } else {
                
                // Memeriksa peran pengguna untuk menyesuaikan query
                if (auth()->user()->hasRole(['EHS'])) {
                    $query->where('auditor_id' , auth()->user()->id)
                    ->whereBetween('created_at', [$timeStart." 00:00:00", $timeEnd." 23:59:59"]);
                } else if (auth()->user()->hasRole(['Departement Head PIC', 'PIC'])) {
                    $query->select('laporan.*')->join('user_has_areas', 'user_has_areas.area_id', '=', 'laporan.area_id')
                          ->where('user_has_areas.user_id', auth()->user()->id)->whereBetween('laporan.created_at', [$timeStart." 00:00:00", $timeEnd." 23:59:59"]);
                }
            }
            
            // Filter berdasarkan kategori jika ada
            if ($request->has('kategori') && $request->input('kategori') != 0) {
                $query->where('kategori', $request->input('kategori'));
            }
            
            
            // Filter berdasarkan area jika ada
            if ($request->has('tipeTable') && $request->input('tipeTable') == "semua") {
                if ($request->has('area') && $request->input('area') != "") {
                    $query->where('area_id', $request->input('area'));
                }
            } else {
                if (auth()->user()->hasRole(['Departement Head PIC', 'PIC'])) {
                    if ($request->has('area') && $request->input('area') != "") {
                        $query->where('user_has_areas.area_id', $request->input('area'));
                    }
                } else {
                    if ($request->has('area') && $request->input('area') != "") {
                        $query->where('area_id', $request->input('area'));
                    }
                }
            }
            
            // Filter berdasarkan rank jika ada
            if ($request->has('rank') && $request->input('rank') != 0) {
                $query->where('rank', $request->input('rank'));
            }
            
            // Filter berdasarkan status jika ada
            if ($request->has('status') && $request->input('status') != 0) {
                if ($request->input('status') == 1 ) {
                    $query->where('progress', '<=' , 10 )->whereNull('PIC_submit_at')->whereNull('ACC_Dept_Head_PIC_At')->whereNull('deleted_at');
                } else if ($request->input('status') == 2) {
                    $query->where('verify_submit_at', null)->where('progress','>=', 10)->whereNull('deleted_at');
                } else if ($request->input('status') == 3) {
                    $query->whereNull('verify_submit_at')->where('progress','>=', 11)->whereNull('deleted_at');
                } else if ($request->input('status') == 4) {
                    $query->whereNull('ACC_Dept_Head_EHS_At')->where('progress', '>=', 12)->whereNull('deleted_at');
                } else if ($request->input('status') == 5) {
                    $query->whereNotNull('ACC_Dept_Head_EHS_At')->where('progress', '>=', 13)->whereNull('deleted_at');
                }else if ($request->input('status') == 6){
                    $query->whereNotNull('deleted_at')->whereNull('ACC_Dept_Head_EHS_At');
                }
            }
            
            // Menghitung total data
            $totalData = $query->count();
            $totalFiltered = $totalData; 

            // Memproses pencarian jika ada
            if(empty($request->input('search.value'))) {            
                $posts = $query->offset($start)
                ->limit($limit)
                ->orderBy($orderColumnName, $dir)
                ->orderBy('progress', 'asc')
                ->orderBy($orderColumnName2, $dir2)
                ->get();
            } else {
                $search = $request->input('search.value'); 
                
                $posts =  $query->where('temuan','LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($orderColumnName, $dir)
                ->orderBy('progress', 'asc')
                ->orderBy($orderColumnName2, $dir2)
                ->get();
                
                $totalFiltered = $query->where('temuan','LIKE',"%{$search}%")
                ->count();
            }
            
            // Mendapatkan data yang relevan
            $data = array();
            if(!empty($posts)) {
                foreach ($posts as $index => $post) {
                    $nestedData['iteration'] = $totalData - $start - $index;
                    if($genba == false){
                        $nestedData['temuan'] = $post->temuan;
                    }
                    $nestedData['area'] = $post->area->name;
                    $nestedData['kategori'] = $post->kategori;
                    $nestedData['rank'] = $post->rank;
                    $nestedData['tanggal_laporan'] = date('d/m/Y', strtotime($post->created_at));
                    $nestedData['deadline'] = date('d/m/Y', strtotime($post->deadline_date));
                    if ($post->ACC_Dept_Head_EHS_At == null && $post->deleted_at !== null){
                        $nestedData['progress'] = '<td class="text-center" style="font-size:12px"><span>Cancel</span></td>';
                        $nestedData['assign_to'] = '<td class="text-center" style="font-size:12px">-</td>';
                    }else if($post->ACC_Dept_Head_PIC_At == null && $post->progress < 10.00) {
                        if ($post->ACC_Dept_Head_PIC_At == null && $post->progress == 0) {
                            $nestedData['progress'] = '<td class="text-center"><span ' . (strtotime($post->deadline_date) < time() ? 'class="pops"' : 'class="pou"') . '>' . $post->progress . '/10</span><br><span>OPEN</span></td>';
                        }else{
                            $nestedData['progress'] = '<td class="text-center"><span ' . (strtotime($post->deadline_date) < time() ? 'class="pop"' : 'class="pou"') . '>' . $post->progress . '/10</span><br><span>' . ($post->progress * 10) . ' %</span></td>';
                        }
                        $nestedData['assign_to'] = '<td class="text-center">'.$post->PIC->name. '</td>';
                    } else if ($post->ACC_Dept_Head_PIC_At == null && $post->progress == 10.00) {
                        $nestedData['progress'] = '<td class="text-center"><span class="pou">' . $post->progress . '/10</span><br><span>Waiting Approval</span></td>';
                        $nestedData['assign_to'] = '<td class="text-center">'. user_has_area::where('area_id', $post->area_id)->whereHas('user.roles', function ($query) {$query->where('name', 'Departement Head PIC');})->first()->user->name .'</td>';
                    } else if ($post->verify_submit_at == null) {
                        $nestedData['progress'] = '<td class="text-center"><span class="pie">' . $post->progress . '/10</span><br><span>Waiting Verify</span></td>';
                        $nestedData['assign_to'] = '<td class="text-center">'.$post->auditor->name. '</td>';
                    } else if ($post->ACC_Dept_Head_EHS_At == null && $post->progress > 10) {
                        $nestedData['progress'] = '<td class="text-center"><span class="fa fa-check text-warning"></span><br><span>Waiting Approval</span></td>';
                        $nestedData['assign_to'] = '<td class="text-center">'.User::role('Departement Head EHS')->first()->name.'</td>';
                    } else {
                        $nestedData['progress'] = '<td class="text-center"><span class="fa fa-check text-navy"></span><br><span>CLOSED</span></td>';
                        $nestedData['assign_to'] = '<td class="text-center">-</td>';
                    }

                    

                    if($genba == false){
                        $nestedData['action'] = '<td><a class="btn btn-info btn-block compose-mail" href="detail/' . $post->id . '">See Detail</a></td>';
                    } else {
                        $nestedData['action'] = '<td><a class="btn btn-info btn-block compose-mail" href="genba/laporan/temuan/' . $post->id . '">See Detail</a></td>';
                    }
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

        if($role == "Departement Head EHS") {
            return redirect('alltable');
        }

        $areas = area::all();

        // Jika bukan permintaan AJAX, kembalikan tampilan tabel
        return view('EHS/table', ['title' => 'Laporan Table',
                                    'active' => 'Laporan Saya',
                                    'halaman' => "Laporan",
                                    'areas' => $areas,
                                ]);
    }

    public function index_all() {
        $role = auth()->user()->getRoleNames()->first();
        $areas = area::all();
        
        return view('EHS/alltable', ['title' => 'Laporan Table',
                                  'active' => 'Semua Laporan',
                                  'halaman' => "Laporan",
                                  'areas' => $areas,
                                ]);
    }
    
    public function create($id) {
        $laporan = ehs_patrol::where('id', $id)->first();

        if($laporan == null) {
            return redirect('/patrolEHS')->with('error', 'Data laporan patrol tidak ditemukan');
        }

        $PIC = user_has_area::where('area_id', $laporan->area_id)->where('role_id', 4)->first();
        

        return view('EHS/createform', 
        ['title' => 'Pembuatan Laporan',
        'active' => 'Pembuatan Laporan',
         'halaman' => "Laporan",
         'laporan' => $laporan,
         'PIC' => $PIC],);
    }

    public function store(Request $request) 
    {

        // Memeriksa apakah pengguna yang sedang masuk memiliki peran sebagai EHS
        if ( auth()->user()->getRoleNames()->first() !=='EHS'){
            return redirect('/patrolEHS')->with('error', 'Pembuatan Laporan hanya bisa dilakukan oleh EHS');
        }

        // Validasi input data
        $validateData = $request->validate([
            'auditor_id' => 'required',
            'patrol_id' => 'required',
            'PIC_id' => 'required',
            'area_id' => 'required',
            'rank' => 'required|in:A,B,C',
            'kategori' => 'required|in:5R,A,B,C,D,E,F,G,O',
            'temuan' => 'required',
            'progress' => 'required',
            'foto_temuan' => 'image|required',
            'deadline_date' => 'required',
        ]);

        // Konversi tanggal deadline menjadi objek Carbon
        $validateData['deadline_date'] = Carbon::createFromFormat('d/m/Y', $request->deadline_date);
        $validateData['deadline_date_awal'] = Carbon::createFromFormat('d/m/Y', $request->deadline_date);
        $now = Carbon::now();
        if ($validateData['deadline_date']->lte($now)) {
            return redirect()->back()->with('error', 'Due Date harus lebih dari tanggal sekarang')->withInput();
        }

        // Memproses dan menyimpan gambar temuan
        $gambar = $request->file('foto_temuan');
        $namaFile = time() . '_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
        $path = public_path('/gambar/foto_temuan');

        // Mengubah ukuran gambar dengan lebar maksimal 720px, menjaga rasio, dan kompres ke kualitas 75%
        $image = Image::make($gambar)
                    ->resize(720, 1600, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode($gambar->getClientOriginalExtension(), 75);
        
        // Menyimpan gambar
        $image->save($path . '/' . $namaFile);

        // Menyimpan nama file ke dalam array yang divalidasi
        $validateData['foto_temuan'] = $namaFile;

        // Menyimpan laporan temuan baru
        $laporan = laporan::create($validateData);

        // Mengirim email jika rank temuan adalah A kepada semua PIC area terkait dan juga departement EHS
        if($validateData['rank'] == 'A'){
            $EHSandDepts = DB::table('model_has_roles as role')
                    ->select('user.email', 'role.role_id', 'user.id')
                    ->join('users as user', 'role.model_id', '=', 'user.id')
                    ->where(function ($query) {
                        $query->where('role.role_id', 3)
                              ->orWhere('role.role_id', 6);
                    })
                    ->where('role.model_id', '!=', auth()->user()->id)
                    ->distinct()
                    ->get();

            foreach($EHSandDepts as $EHSandDept) {
                if($EHSandDept->role_id == 6) {
                    $EHSDept = $EHSandDept->id;
                }

                try{
                    // Mail::to("mahsunmuh0@gmail.com")->send(new urgentMail($laporan));
                    Mail::to($EHSandDept->email)->send(new urgentMail($laporan));
                }catch(\Exception $th){
                    return $th;   
                }
                 
            }

            $PICs = user_has_area::where('area_id', $laporan->area_id)->get();

            
            
            foreach($PICs as $PIC) {
                if($PIC->user_id != $EHSDept){
                    // Mail::to("mahsunmuh0@gmail.com")->send(new urgentMail($laporan));
                    Mail::to($PIC->user->email)->send(new urgentMail($laporan));
                }
            }
            
        }
        
        // Membuat catatan aktivitas
        $data = new activity_log();
        $data->user_id = auth()->user()->id;
        $data->auditor_id = $laporan->auditor_id;
        $data->laporan_id = $laporan->id;
        $data->area_id = $laporan->area_id;
        $data->event_type = "create";
        $data->status_read_auditor = true;
        $data->status_read_ehs = true;
        $data->deskripsi = auth()->user()->name." telah membuat laporan temuan ehs patrol pada area ". $laporan->area->name;
        
        $data->save();

        // melihat id dept head
        $Dept_Head_EHS = DB::table('model_has_roles')
        ->where('role_id', 6)
        ->first();

        // melihat apakah area termasuk bagian dari dept head ehs atau bukan
        $is_dept_head_ehs = true;

        // Menghitung notifikasi untuk PIC area terkait
        $area = area::where('id', $request->area_id)->first();

        foreach($area->area as $pic) {
            //pengecekan untuk dept head EHS apakah sebagai Dept Head PIC pada area ini juga
            if($Dept_Head_EHS->model_id == $pic->user_id) {
                $is_dept_head_ehs = false;
            }

            $count_notification = user_notification_count::where('user_id', $pic->user_id)->first();

            if($count_notification == null) {
                $addCount['user_id'] = $pic->user_id;
                $addCount['count'] = 1;
                user_notification_count::create($addCount);
            } else {
                $addCount['count'] = $count_notification->count + 1;
                $count_notification->update(['count' => $addCount['count']]);
            }
        }

        // Menghitung notifikasi untuk Dept Head EHS jika area bukan bagian dari dept head ehs
        if($is_dept_head_ehs){
            $count_notification_ehs = user_notification_count::where('user_id', $Dept_Head_EHS->model_id)->first();

            if($count_notification_ehs == null) {
            $addCount['user_id'] = $Dept_Head_EHS->model_id;
            $addCount['count'] = 1;
            user_notification_count::create($addCount);
            } else {
            $addCount['count'] = $count_notification_ehs->count + 1;
            $count_notification_ehs->update(['count' => $addCount['count']]);
            }
        }

        return redirect("/createform/$request->patrol_id")->with('success', 'Data Berhasil ditambahkan');

    }

    public function detail($id) {
        Log::info('Mengakses detail laporan', ['id' => $id]);
        $laporan = laporan::where('id', $id)->first();
        
        Log::info('Laporan ditemukan', ['laporan_id' => $laporan->id]);
        if($laporan == null) {
            Log::warning('Laporan tidak ditemukan', ['id' => $id]);
            return redirect('/table')->with('error', 'Data Temuan tidak ditemukan');
        }


        foreach($laporan->area->area as $pic) {
            if($pic->user->roles[0]->name == "PIC") {
                $pic_area = $pic->user_id;
            } else{
                $Dept_Head_pic_area = $pic->user_id;
            }
        }



        if($laporan->genba_id != null) {

            return redirect('/genba/laporan/temuan/'.$laporan->genba_id);
        }
       
        return view('EHS/detailform', ['title' => 'Detail Laporan',
                                       'halaman' => "Laporan",
                                       'active' => 'Laporan Saya',
                                       'laporan' => $laporan,
                                       'PIC_area' => $pic_area,
                                       'Dept_Head_PIC_area' => $Dept_Head_pic_area]);
    }

    public function edit($id) {

        // Daftar peran yang diizinkan untuk mengakses halaman edit
        $laporan = laporan::where('id', $id)->first();

        // Memeriksa role user
        if (!auth()->user()->hasRole(['Departement Head EHS', 'EHS'])) {
            return redirect("/patrolEHS/$laporan->patrol_id")->with('error', 'Account tidak valid, Laporan Edit hanya bisa dilakukan oleh EHS');
        }

        // Memeriksa apakah laporan tidak ditemukan
        if($laporan == null) {
            return redirect('/table')->with('error', 'Data Temuan tidak ditemukan');
        }

        // Memeriksa apakah laporan prosesnya sudah melebihi 100%
        if ( $laporan->deleted_at != null){
            return redirect("/patrolEHS/$laporan->patrol_id")->with('error', 'Maaf aktifitas dilarang');
        }
        
        // Memeriksa apakah laporan telah dihapus
        if ( $laporan->progress > 7.5){
            return redirect("/patrolEHS/$laporan->patrol_id")->with('error', 'Maaf aktifitas dilarang');
        }
        
        // Memeriksa apakah laporan terkait dengan Genba
        if($laporan->genba_id != null) {
            return redirect('/genba/laporan/temuan/'.$laporan->genba_id);
        }
        
        // Mengambil daftar area dan PIC
        $area = area::all();
        $PIC = User::role('PIC')->get();

        return view('EHS/editform', ['title' => 'Edit Laporan',
                                     'halaman' => "Laporan",
                                     'active' => 'Laporan Saya',
                                     'laporan' => $laporan,
                                     'areas' => $area,
                                     'PICs' => $PIC]);

    }

    public function update(Request $request) {
        // Mendapatkan data lama laporan berdasarkan ID
        $dataLama = laporan::where('id', $request->id)->first();

        // declare is dept head ehs
        $is_dept_head_ehs = null;
        
        // Memeriksa apakah laporan telah dihapus
        if ( $dataLama->deleted_at != null){
            return redirect("/patrolEHS/$dataLama->patrol_id")->with('error', 'Maaf aktifitas dilarang');
        }

        // Daftar peran yang diizinkan untuk mengakses halaman update
        $allowedRoles = ['Departement Head EHS', 'EHS'];

        if (!auth()->user()->hasRole(['Departement Head EHS', 'EHS'])) {
            return redirect("/patrolEHS/$dataLama->patrol_id")->with('error', 'Account tidak valid, Laporan Edit hanya bisa dilakukan oleh EHS');
        }

        // Validasi data yang dikirimkan dari formulir
        $validateData = $request->validate([
            'PIC_id' => 'required',
            'area_id' => 'required',
            'rank' => 'required|in:A,B,C',
            'kategori' => 'required|in:5R,A,B,C,D,E,F,G,O',
            'temuan' => 'required',
            'foto_temuan' => 'image',
            'deadline_date' => 'required',
        ]);

        // Konversi format tanggal ke Carbon
        $validateData['deadline_date'] = Carbon::createFromFormat('d/m/Y', $request->deadline_date);
        
        // Mendapatkan tanggal sekarang
        $now = Carbon::now();

        // Memeriksa apakah tanggal yang dimasukkan lebih dari tanggal sekarang
        if ($validateData['deadline_date']->lte($now)) {
            // Tanggal kurang dari atau sama dengan tanggal sekarang
            return redirect()->back()->with('error', 'Due Date harus lebih dari tanggal sekarang')->withInput();
        }

        // Memeriksa apakah ada file gambar yang sudah diunggah
        if ($request->has('foto_temuan')) {
            // Menghapus gambar lama dari penyimpanan
            File::delete(public_path('/gambar/foto_temuan/'.$dataLama->foto_temuan));
            // Menyimpan gambar yang baru diunggah
            $gambar = $request->file('foto_temuan');
            $namaFile = time() . '_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
            $path = public_path('/gambar/foto_temuan');
            $image = Image::make($gambar)
                    ->resize(720, 1600, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode($gambar->getClientOriginalExtension(), 75);
            
            // Menyimpan gambar
            $image->save($path . '/' . $namaFile);        
            
            // Menyimpan nama file gambar yang baru
            $validateData['foto_temuan'] = $namaFile;
        } else {
            // Jika tidak ada file gambar yang diunggah, tetap menggunakan gambar lama
            $validateData['foto_temuan'] = $dataLama->foto_temuan;
        }
        
        // Mendapatkan data laporan berdasarkan ID
        $laporan =  laporan::where('id' ,$request->id)->first();
        // Memperbarui data laporan dengan data yang sudah divalidasi
        $laporan->update($validateData);
        
        // Deskripsi perubahan untuk catatan aktivitas
        $deskripsi = auth()->user()->name . " telah melakukan perubahan pada laporan temuan. ";
        
        // Mendapatkan kolom yang berubah pada laporan
        $kolomBerubah = $laporan->getChanges();

        // Memeriksa apakah perubahan rank membuat laporan menjadi urgent (A)
        if(Arr::has($kolomBerubah, 'rank')){
            if($kolomBerubah['rank'] == 'A') {
                $EHSandDepts = DB::table('model_has_roles as role')
                    ->select('user.email')
                    ->join('users as user', 'role.model_id', '=', 'user.id')
                    ->where(function ($query) {
                        $query->where('role.role_id', 3)
                              ->orWhere('role.role_id', 6);
                    })
                    ->where('role.model_id', '!=', auth()->user()->id)
                    ->distinct()
                    ->get();

            foreach($EHSandDepts as $EHSandDept) {
                // Mail::to("mahsunmuh0@gmail.com")->send(new urgentMail($laporan));
                Mail::to($EHSandDept->email)->send(new urgentMail($laporan));
            }

            $PICs = user_has_area::where('area_id', $laporan->area_id)->get();
            foreach($PICs as $PIC) {
                
                // Mail::to("mahsunmuh0@gmail.com")->send(new urgentMail($laporan));
                Mail::to($PIC->user->email)->send(new urgentMail($laporan));
            }

            }
        }
        
        // Membuat deskripsi dari perubahan yang terjadi pada laporan
        if (!empty($kolomBerubah)) {
            $perubahan = [];
            foreach ($kolomBerubah as $kolom => $nilai) {
                if ($kolom !== 'deadline_date' && $kolom !== 'updated_at') {
                    if($kolom == 'foto_temuan') {
                        $perubahan[] = "$kolom telah diubah";
                    } else {
                        $perubahan[] = "$kolom diubah menjadi $nilai";
                    }
                }
                
            }
            $deskripsi .= implode(", ", $perubahan);
        } else {
            $deskripsi .= "";
        }

        // Membuat catatan aktivitas untuk perubahan yang dilakukan
        $data = new activity_log();
        $data->user_id = auth()->user()->id;
        $data->auditor_id = $laporan->auditor_id; 
        $data->laporan_id = $laporan->id;
        $data->area_id = $laporan->area_id;
        $data->event_type = "edit";
        if(auth()->user()->id == $laporan->auditor_id) {
            $data->status_read_auditor = true;
        }
        
        $data->status_read_ehs = true;
        $data->deskripsi = $deskripsi;

        $data->save();

        // Memperbarui notifikasi untuk auditor jika pengguna auditor
        if (auth()->user()->id != $laporan->auditor_id) {
            $count_notification_ehs = user_notification_count::where('user_id', $laporan->auditor_id)->first();
            if($count_notification_ehs == null) {
                $addCount['user_id'] = $laporan->auditor_id;
                $addCount['count'] = 1;
                user_notification_count::create($addCount);
            } else {
                $addCount['count'] = $count_notification_ehs->count + 1;
                $count_notification_ehs->update(['count' => $addCount['count']]);
                    }
                }

        // mencari id dari dept head
        $Dept_Head_EHS = DB::table('model_has_roles')
        ->where('role_id', 6)
        ->first();

        // Memperbarui notifikasi untuk setiap PIC dan Dept Head PIC yang terkait dengan area laporan
        $area = area::where('id', $request->area_id)->first();

        foreach($area->area as $pic) {

            //pengecekan untuk dept head EHS apakah sebagai Dept Head PIC pada area ini juga
            if($Dept_Head_EHS->model_id == $pic->user_id) {
                $is_dept_head_ehs = false;
            }

            if(auth()->user()->id != $pic->user_id) {
                $count_notification = user_notification_count::where('user_id', $pic->user_id)->first();

                if($count_notification == null) {
                    $addCount['user_id'] = $pic->user_id;
                    $addCount['count'] = 1;
                    user_notification_count::create($addCount);
                } else {
                    $addCount['count'] = $count_notification->count + 1;
                    $count_notification->update(['count' => $addCount['count']]);
                }
            }
        }

        // Memperbarui notifikasi untuk Departement Head EHS jika pengguna bukan Departement Head EHS
        if($is_dept_head_ehs){
            //jika yang mengedit laporan bukan dept head ehs
            if(!auth()->user()->hasRole(['Departement Head EHS'])) {

                $count_notification_ehs = user_notification_count::where('user_id', $Dept_Head_EHS->model_id)->first();
                if($count_notification_ehs == null) {
                    $addCount['user_id'] = $Dept_Head_EHS->model_id;
                    $addCount['count'] = 1;
                    user_notification_count::create($addCount);
                } else {
                    $addCount['count'] = $count_notification_ehs->count + 1;
                    $count_notification_ehs->update(['count' => $addCount['count']]);
                }
            } 
        }

        return redirect("/detail/$dataLama->id")->with('success', 'Data Berhasil Di update');

    }
    
    public function destroy(Request $request){
        // Mendapatkan data laporan berdasarkan ID
        $laporan = laporan::where('id', $request->id)->first();
        // Memeriksa apakah laporan terkait dengan aktivitas Genba
        if ($laporan->genba_id != null){
            $genba = true;
        } else {
            $genba = false;
        }

        if($genba) {
            if($laporan->auditor_id != auth()->user()->id && auth()->user()->getRoleNames()[0] != "Departement Head EHS" &&  auth()->user()->getRoleNames()[0] != "EHS" ){
                return redirect("genba/laporan/temuan/$laporan->id")->with('error', 'Account tidak valid, Proses hapus hanya bisa dilakukan oleh EHS');
            }
        } else{
            // Memeriksa apakah pengguna memiliki peran yang sesuai untuk menghapus laporan
            if ( !auth()->user()->hasRole(['Departement Head EHS', 'EHS'])) {
                return redirect("/patrolEHS/$laporan->patrol_id")->with('error', 'Account tidak valid, Proses hapus hanya bisa dilakukan oleh EHS');
            }
        }

        // Memeriksa apakah laporan telah dihapus sebelumnya
        if ( $laporan->deleted_at != null){
            return redirect("/patrolEHS/$laporan->patrol_id")->with('error', 'Maaf aktifitas dilarang');
        }
        // File::delete(public_path('/gambar/foto_temuan/'.$laporan->foto_temuan));
       
        // Melakukan soft delete pada laporan
        $laporan = laporan::where('id', $request->id)->update(['deleted_at' => now()]);

        // Membuat catatan aktivitas untuk penghapusan laporan
        $log = laporan::where('id', $request->id)->first();
        $data = new activity_log();
        $data->user_id = auth()->user()->id;
        $data->auditor_id = $log->auditor_id; 
        $data->laporan_id = $log->id;
        $data->area_id = $log->area_id;
        $data->event_type = "delete";
        if(auth()->user()->id == $log->auditor_id) {
            $data->status_read_auditor = true;
        }
        $data->status_read_ehs = true;
        $data->deskripsi = auth()->user()->name." telah membatalkan laporan temuan";

        $data->save();


        // mencari id dari dept head
        $Dept_Head_EHS = DB::table('model_has_roles')
        ->where('role_id', 6)
        ->first();
        
        $is_dept_head_ehs = true;

        // Memperbarui notifikasi untuk Auditor
        if (auth()->user()->roles[0]->name != "EHS"){
            $notification_penolakan = user_notification_count::where('user_id', $log->auditor_id)->first();

            if($notification_penolakan == null) {
                $addCount['user_id'] = $log->auditor_id;
                $addCount['count'] = 1;
                user_notification_count::create($addCount);
            } else {
                $addCount['count'] = $notification_penolakan->count + 1;
                $notification_penolakan->update(['count' => $addCount['count']]);
            }
        }

        // Memperbarui notifikasi untuk setiap PIC dan Dept Head PIC yang terkait dengan area laporan
        $area = area::where('id', $log->area_id)->first();
        

        foreach($area->area as $pic) {

            //pengecekan untuk dept head EHS apakah sebagai Dept Head PIC pada area ini juga
            if($Dept_Head_EHS->model_id == $pic->user_id) {
                $is_dept_head_ehs = false;
            }

            if(auth()->user()->id != $pic->user_id) {
                $count_notification = user_notification_count::where('user_id', $pic->user_id)->first();

                if($count_notification == null) {
                    $addCount['user_id'] = $pic->user_id;
                    $addCount['count'] = 1;
                    user_notification_count::create($addCount);
                } else {
                    $addCount['count'] = $count_notification->count + 1;
                    $count_notification->update(['count' => $addCount['count']]);
                }
            }
        }

        // Memperbarui notifikasi untuk Departement Head EHS jika pengguna bukan Departement Head EHS
        if($is_dept_head_ehs){
            //jika yang mengedit laporan bukan dept head ehs
            if(!auth()->user()->hasRole(['Departement Head EHS'])) {

                $count_notification_ehs = user_notification_count::where('user_id', $Dept_Head_EHS->model_id)->first();
                if($count_notification_ehs == null) {
                    $addCount['user_id'] = $Dept_Head_EHS->model_id;
                    $addCount['count'] = 1;
                    user_notification_count::create($addCount);
                } else {
                    $addCount['count'] = $count_notification_ehs->count + 1;
                    $count_notification_ehs->update(['count' => $addCount['count']]);
                }
            } 
        }

        if ($genba) {
            return redirect('/genba/laporan/'.$log->genba_id)->with('success', 'Data Berhasil Di Batalkan');
        } else {
            return redirect("/patrolEHS/$log->patrol_id")->with('success', 'Data Berhasil Di Batalkan');
        }
    }

    public function Accept_EHS(Request $request) {

        // Mengambil data laporan berdasarkan ID
        $laporan = laporan::where('id', $request->laporan_id)->first();

        // Memeriksa peran pengguna
        if (!auth()->user()->hasRole(['Departement Head EHS'])) {
            return redirect("/patrolEHS/$laporan->patrol_id")->with('error', 'Account tidak valid, Proses ACC hanya bisa dilakukan oleh Kepala Departement EHS');
        }
        
        // Memeriksa apakah laporan telah dihapus sebelumnya
        if ( $laporan->deleted_at != null){
            return redirect("/patrolEHS/$laporan->patrol_id")->with('error', 'Maaf aktifitas dilarang');
        }

        // Memperbarui status ACC dan ID Departement Head EHS pada laporan
        $laporan->update([
            'ACC_Dept_Head_EHS_At' => now(),
            'dept_ehs_id' => auth()->user()->id,
            'progress' => 13]);
        
        $laporan->save();

        // $laporanUpdate = laporan::where('id', $request->laporan_id)->first();

        // Membuat catatan aktivitas untuk approval laporan
        $log = laporan::where('id', $request->laporan_id)->first();
        $data = new activity_log();
        $data->user_id = auth()->user()->id;
        $data->auditor_id = $log->auditor_id; 
        $data->laporan_id = $log->id;
        $data->area_id = $log->area_id;
        $data->event_type = "approve";
        if(auth()->user()->id == $log->auditor_id) {
            $data->status_read_auditor = true;
        }
        $data->status_read_ehs = true;
        $data->deskripsi = auth()->user()->name." telah melakukan approval terhadap laporan";;

        $data->save();

        // Memperbarui notifikasi untuk auditor
        $count_notification_ehs = user_notification_count::where('user_id', $laporan->auditor_id)->first();

        if($count_notification_ehs == null) {
            $addCount['user_id'] = $laporan->auditor_id;
            $addCount['count'] = 1;
            user_notification_count::create($addCount);
        } else {
            $addCount['count'] = $count_notification_ehs->count + 1;
            $count_notification_ehs->update(['count' => $addCount['count']]);
                        }

        // Memperbarui notifikasi untuk setiap PIC yang terkait dengan area laporan
        $area = area::where('id', $laporan->area_id)->first();

        foreach($area->area as $pic) {
            if($pic->user_id != auth()->user()->id)
                $count_notification = user_notification_count::where('user_id', $pic->user_id)->first();

                if($count_notification == null) {
                    $addCount['user_id'] = $pic->user_id;
                    $addCount['count'] = 1;
                    user_notification_count::create($addCount);
                } else {
                    $addCount['count'] = $count_notification->count + 1;
                    $count_notification->update(['count' => $addCount['count']]);
                }
        }

        // Memeriksa apakah laporan terkait dengan aktivitas Genba
        if ($laporan->genba_id != null) {

            $users = user::all();
    
            foreach($users as $ehs) {
                if(auth()->user()->id != $ehs->id) {
                    if ($ehs->roles[0]->name == "EHS"){
                        $ehs_notification = user_notification_count::where('user_id', $ehs->id)->first();
        
                        if($ehs_notification == null) {
                            $addCount['user_id'] = $ehs->id;
                            $addCount['count'] = 1;
                            user_notification_count::create($addCount);
                        } else {
                            $addCount['count'] = $ehs_notification->count + 1;
                            $ehs_notification->update(['count' => $addCount['count']]);
                        }
                    }
                }
            }
        }
        
        if ($laporan->genba_id != null){
            $genba = true;
        } else {
            $genba = false;
        }

        if ($genba) {
            return redirect('/genba/laporan/'.$laporan->genba_id)->with('success', 'Data Berhasil Di approve');
        } else {
            return redirect("/patrolEHS/$laporan->patrol_id")->with('success', 'Data Berhasil Di approve');
        }
        
    }

    public function verify_laporan(Request $request) {
        
        // Mengambil data laporan berdasarkan ID
        $dataLama = laporan::where('id', $request->laporan_id)->first();

        // Memeriksa apakah laporan telah dihapus sebelumnya
        if ( $dataLama->deleted_at != null){
            return redirect("/patrolEHS/$dataLama->patrol_id")->with('error', 'Maaf aktifitas dilarang');
        }

        // Memeriksa apakah laporan terkait dengan aktivitas Genba
        if ($dataLama->genba_id != null){
            $genba = true;
        } else {
            $genba = false;
            if ( auth()->user()->getRoleNames()->first() !=='EHS'){
                return redirect("/patrolEHS/$dataLama->patrol_id")->with('error', 'Account tidak valid, Pembuatan laporan penanggulangan hanya bisa dilakukan oleh PIC');
            }
    
            // if ($dataLama->auditor_id !== auth()->id()){
            //     return redirect("/patrolEHS/$dataLama->patrol_id")->with('error', 'Account tidak valid, Laporan hanya bisa di verifikasi oleh yang membuat EHS yang bersangkutan');
            // }
        }
        
        // Memperbarui data laporan dengan informasi verifikasi
        $dataLama->update(['alasan_penolakan' => null,
                           'progress' => 12,
                           'verify_submit_at' => now()]);
                           
                           $dataLama->save();


        // Membuat catatan aktivitas untuk verifikasi laporan
        $laporanUpdate = laporan::where('id', $request->laporan_id)->first();
        
        $log = laporan::where('id', $request->laporan_id)->first();
        $data = new activity_log();
        $data->user_id = auth()->user()->id;
        $data->auditor_id = $log->auditor_id; 
        $data->laporan_id = $log->id;
        $data->area_id = $log->area_id;
        $data->event_type = "approve";
        if(auth()->user()->id == $log->auditor_id) {
            $data->status_read_auditor = true;
        }
        $data->status_read_ehs = true;
        $data->deskripsi = auth()->user()->name." telah melakukan verifikasi terhadap laporan";

        $data->save();

        // melihat id dept head
        $Dept_Head_EHS = DB::table('model_has_roles')
        ->where('role_id', 6)
        ->first();

        // melihat apakah area termasuk bagian dari dept head ehs atau bukan
        $is_dept_head_ehs = true;

        // Menghitung notifikasi untuk PIC area terkait
        $area = area::where('id', $log->area_id)->first();

        foreach($area->area as $pic) {
            //pengecekan untuk dept head EHS apakah sebagai Dept Head PIC pada area ini juga
            if($Dept_Head_EHS->model_id == $pic->user_id) {
                $is_dept_head_ehs = false;
            }

            $count_notification = user_notification_count::where('user_id', $pic->user_id)->first();

            if($count_notification == null) {
                $addCount['user_id'] = $pic->user_id;
                $addCount['count'] = 1;
                user_notification_count::create($addCount);
            } else {
                $addCount['count'] = $count_notification->count + 1;
                $count_notification->update(['count' => $addCount['count']]);
            }
        }

        // Menghitung notifikasi untuk Dept Head EHS jika area bukan bagian dari dept head ehs
        if($is_dept_head_ehs){
            $count_notification_ehs = user_notification_count::where('user_id', $Dept_Head_EHS->model_id)->first();

            if($count_notification_ehs == null) {
            $addCount['user_id'] = $Dept_Head_EHS->model_id;
            $addCount['count'] = 1;
            user_notification_count::create($addCount);
            } else {
            $addCount['count'] = $count_notification_ehs->count + 1;
            $count_notification_ehs->update(['count' => $addCount['count']]);
            }
        }

        // Memperbarui notifikasi untuk pengguna dengan peran EHS jika laporan terkait dengan Genba
        if ($log->genba_id != null) {

            $users = user::all();
    
            foreach($users as $ehs) {
                if(auth()->user()->id != $ehs->id) {
                    if ($ehs->roles[0]->name == "EHS"){
                        $ehs_notification = user_notification_count::where('user_id', $ehs->id)->first();
        
                        if($ehs_notification == null) {
                            $addCount['user_id'] = $ehs->id;
                            $addCount['count'] = 1;
                            user_notification_count::create($addCount);
                        } else {
                            $addCount['count'] = $ehs_notification->count + 1;
                            $ehs_notification->update(['count' => $addCount['count']]);
                        }
                    }
                }
            }
        }

        if ($genba) {
            return redirect('/genba/laporan/'.$dataLama->genba_id)->with('success', 'Data Berhasil Di verifikasi');
        } else {
            return redirect("/patrolEHS/$dataLama->patrol_id")->with('success', 'Data Berhasil Di verifikasi');
        }
        
    }

    public function create_penolakan($id) {
        $dataLama = laporan::where('id', $id)->first();
        $is_pic = false;

        foreach ($dataLama->area->area as $pic) {
            if(auth()->user()->hasRole(['Departement Head PIC']) && auth()->user()->id == $pic->user_id){
                $is_pic = true;
            }
        }

        if (!auth()->user()->hasRole(['Departement Head PIC', 'Departement Head EHS','EHS'])) {
            return redirect("/patrolEHS/$dataLama->patrol_id")->with('error', 'Account tidak valid, hanya beberapa role saja yang di perbolehkan');
        }

        if($dataLama->progress < 10){
            return redirect("/patrolEHS/$dataLama->patrol_id")->with('error', 'Maaf anda tidak bisa mengakses halaman ini');
        }
        
        if($dataLama->progress == 10 && $is_pic == false){
            return redirect("/patrolEHS/$dataLama->patrol_id")->with('error', 'Maaf anda tidak bisa mengakses halaman ini');
        }

        if($dataLama->progress == 11 && !auth()->user()->hasRole(['EHS'])) {
            return redirect("/patrolEHS/$dataLama->patrol_id")->with('error', 'Maaf anda tidak bisa mengakses halaman ini');
        }

        if($dataLama->progress == 12 && !auth()->user()->hasRole(['Departement Head EHS'])) {
            return redirect("/patrolEHS/$dataLama->patrol_id")->with('error', 'Maaf anda tidak bisa mengakses halaman ini');
        }

        if($dataLama->progress == 12 && $dataLama->ACC_Dept_Head_EHS_At != null) {
            return redirect("/patrolEHS/$dataLama->patrol_id")->with('error', 'Maaf anda tidak bisa mengakses halaman ini');
        }

        if($dataLama == null) {
            return redirect('/table')->with('error', 'Data Temuan tidak ditemukan');
        }
        
        $laporan = laporan::where('id', $id)->first();
        $area = area::all();
        $PIC = User::role('PIC')->get();
        if($laporan->genba_id == null) {
            $active = "Laporan Saya";
        } else {
            $active = "schedule";
        }

        if($laporan->genba_id == null) {
            $halaman = "Laporan";
        } else {
            $halaman = "genba";
        }

        return view('EHS/formPenolakan', ['title' => 'Pembuatan Laporan Perbaikan',
                                     'halaman' => $halaman,
                                     'active' => $active,
                                     'laporan' => $laporan,
                                     'areas' => $area,
                                     'PICs' => $PIC]);
    }

    public function requestDueDateLanjutan(Request $request,$id){
        $validateData = $request->validate([
            'alasan_due_date_lanjutan' => 'required',
            'tanggal_request_due_date_lanjutan' => 'required',
        ]);

        $laporan = Laporan::find($id);
        $laporan->update([
            'alasan_due_date_lanjutan' => $validateData['alasan_due_date_lanjutan'],
            'tanggal_request_due_date_lanjutan' => Carbon::createFromFormat('d/m/Y', $validateData['tanggal_request_due_date_lanjutan']),
        ]);
        $status = 'request';
        Mail::to($laporan->auditor->email)->send(new RequestDueDateLanjutan($laporan,$status));
        return redirect("/patrolEHS/$laporan->patrol_id")->with('success', 'Request Due Date Lanjutan Berhasil di Ajukan Ke EHS!');
    }

    public function konfirmasiDueDateLanjutan(Request $request,$id,$status){
        $laporan = Laporan::find($id);
        if($status == 'acc'){
            $laporan->update([
                'deadline_date' => $laporan->tanggal_request_due_date_lanjutan,
            ]);
        $PICs = user_has_area::where('area_id', $laporan->area_id)->get();
            foreach($PICs as $PIC) {
                Mail::to($PIC->user->email)->send(new RequestDueDateLanjutan($laporan,$status));
            }
            return redirect("/patrolEHS/$laporan->patrol_id")->with('success', 'Request Due Date Lanjutan Berhasil di Setujui');
        }else{
            $laporan->update([
                'alasan_due_date_lanjutan' => 'tolak',
                'tanggal_request_due_date_lanjutan' => null,
            ]);
        $status = 'tolak';
        $PICs = user_has_area::where('area_id', $laporan->area_id)->get();
            foreach($PICs as $PIC) {
                Mail::to($PIC->user->email)->send(new RequestDueDateLanjutan($laporan,$status));
            }
            return redirect("/patrolEHS/$laporan->patrol_id")->with('success', 'Request Due Date Lanjutan Berhasil di Tolak');
        }

    }

    public function update_tolak_laporan(Request $request) {

        // Mengambil data laporan berdasarkan ID
        $dataLama = laporan::where('id', $request->laporan_id)->first();

        $is_pic = false;

        foreach ($dataLama->area->area as $pic) {
            if(auth()->user()->hasRole(['Departement Head PIC']) && auth()->user()->id == $pic->user_id){
                $is_pic = true;
            }
        }

        if (!auth()->user()->hasRole(['Departement Head PIC', 'Departement Head EHS','EHS'])) {
            return redirect("/patrolEHS/$dataLama->patrol_id")->with('error', 'Account tidak valid, hanya beberapa role saja yang di perbolehkan');
        }

        if($dataLama->progress < 10){
            return redirect("/patrolEHS/$dataLama->patrol_id")->with('error', 'Maaf anda tidak bisa mengakses halaman ini');
        }

        if($dataLama->progress == 10 && $is_pic == false){
            return redirect("/patrolEHS/$dataLama->patrol_id")->with('error', 'Maaf anda tidak bisa mengakses halaman ini');
        }

        if($dataLama->progress == 11 && !auth()->user()->hasRole(['EHS'])) {
            return redirect("/patrolEHS/$dataLama->patrol_id")->with('error', 'Maaf anda tidak bisa mengakses halaman ini');
        }

        if($dataLama->progress == 12 && !auth()->user()->hasRole(['Departement Head EHS'])) {
            return redirect("/patrolEHS/$dataLama->patrol_id")->with('error', 'Maaf anda tidak bisa mengakses halaman ini');
        }

        if($dataLama->progress == 13 && $dataLama->ACC_Dept_Head_EHS_At != null) {
            return redirect("/patrolEHS/$dataLama->patrol_id")->with('error', 'Maaf anda tidak bisa mengakses halaman ini');
        }

        if($dataLama == null) {
            return redirect('/table')->with('error', 'Data Temuan tidak ditemukan');
        }

        // Validasi data yang diterima dari form
        $validateData = $request->validate([
            'alasan_penolakan' => 'required',
            'progress' => 'required',
        ]);

        if(auth()->user()->hasRole('EHS'))
        {
            $deadline_date_lanjutan = true;
            $validateData['status_due_date_lanjutan'] = $deadline_date_lanjutan;
        }
        // Jika progress lebih besar atau sama dengan 10, maka diatur ke nilai sebelumnya
        if($validateData['progress'] >= 10) {
            $validateData['progress'] = 7.5;
        }

        // Memperbarui data laporan dengan informasi penolakan
        $validateData['PIC_submit_at']  = null;
        $validateData['ACC_Dept_Head_PIC_At']  = null;
        $validateData['verify_submit_at']  = null;
        $laporan =  laporan::where('id' ,$request->laporan_id)->first();
        $laporan->update($validateData);

        // Mengirim email pemberitahuan penolakan kepada PIC yang bersangkutan
        $laporanUpdate = laporan::where('id', $request->laporan_id)->first();
        // Mail::to("mahsunmuh0@gmail.com")->send(new tolakTemuan($laporanUpdate));
        Mail::to($laporanUpdate->PIC->email)->send(new tolakTemuan($laporanUpdate));
        
        // Membuat catatan aktivitas untuk penolakan laporan
        $deskripsi = auth()->user()->name. " melakukan penolakan pada laporan ";
        $kolomBerubah = $laporan->getChanges();
        
        if (!empty($kolomBerubah)) {
            $perubahan = [];
            foreach ($kolomBerubah as $kolom => $nilai) {
                if ($kolom !== 'deadline_date' && $kolom !== 'updated_at' && $kolom !== "PIC_submit_at") {
                    if($kolom == 'alasan_penolakan') {
                        $perubahan[] = "dengan catatan perbaikan lanjutan $nilai ";
                    }
                }
                
            }
            $deskripsi .= implode(", ", $perubahan);
        } else {
            $deskripsi .= "";
        }

        // Menyimpan catatan aktivitas dalam log
        $data = new activity_log();
        $data->user_id = auth()->user()->id;
        $data->auditor_id = $laporan->auditor_id; 
        $data->laporan_id = $laporan->id;
        $data->area_id = $laporan->area_id;
        $data->event_type = "tolak";
        if(auth()->user()->id == $laporan->auditor_id) {
            $data->status_read_auditor = true;
        }
        
        $data->status_read_ehs = true;
        $data->deskripsi = $deskripsi;

        $data->save();
        
        // Mendapatkan ID Departement Head EHS
        $Dept_Head_EHS = DB::table('model_has_roles')
                        ->where('role_id', 6)
                        ->first();
                        
        $is_dept_head_ehs = true;
        
        // Memperbarui notifikasi untuk Auditor
        if (auth()->user()->roles[0]->name != "EHS"){
            $notification_penolakan = user_notification_count::where('user_id', $laporan->auditor_id)->first();

            if($notification_penolakan == null) {
                $addCount['user_id'] = $laporan->auditor_id;
                $addCount['count'] = 1;
                user_notification_count::create($addCount);
            } else {
                $addCount['count'] = $notification_penolakan->count + 1;
                $notification_penolakan->update(['count' => $addCount['count']]);
            }
        }

        // Memperbarui notifikasi untuk setiap PIC dan Dept Head PIC yang terkait dengan area laporan
        $area = area::where('id', $laporan->area_id)->first();

        foreach($area->area as $pic) {
            if(auth()->user()->hasRole(['Departement Head PIC'])) {
                if($Dept_Head_EHS->model_id == $pic->user_id) {
                    $is_dept_head_ehs = false;
                }
                if($pic->user->hasRole(['PIC'])) {
                    $count_notification = user_notification_count::where('user_id', $pic->user_id)->first();
    
                    if($count_notification == null) {
                        $addCount['user_id'] = $pic->user_id;
                        $addCount['count'] = 1;
                        user_notification_count::create($addCount);
                    } else {
                        $addCount['count'] = $count_notification->count + 1;
                        $count_notification->update(['count' => $addCount['count']]);
                    }
                } else if ($pic->user->hasRole(['Departement Head PIC']) && auth()->user()->id != $pic->user_id) {
                    $count_notification = user_notification_count::where('user_id', $pic->user_id)->first();
    
                    if($count_notification == null) {
                        $addCount['user_id'] = $pic->user_id;
                        $addCount['count'] = 1;
                        user_notification_count::create($addCount);
                    } else {
                        $addCount['count'] = $count_notification->count + 1;
                        $count_notification->update(['count' => $addCount['count']]);
                    }
                }

            } else {
                    if($Dept_Head_EHS->model_id == $pic->user_id) {
                        $is_dept_head_ehs = false;
                    }
                    $count_notification = user_notification_count::where('user_id', $pic->user_id)->first();
    
                    if($count_notification == null) {
                        $addCount['user_id'] = $pic->user_id;
                        $addCount['count'] = 1;
                        user_notification_count::create($addCount);
                    } else {
                        $addCount['count'] = $count_notification->count + 1;
                        $count_notification->update(['count' => $addCount['count']]);
                    }
            }
        }


        if ($is_dept_head_ehs){
            if($Dept_Head_EHS->model_id != auth()->user()->id){
                $notification_penolakan = user_notification_count::where('user_id', $Dept_Head_EHS->model_id)->first();
        
                if($notification_penolakan == null) {
                    $addCount['user_id'] = $Dept_Head_EHS->model_id;
                    $addCount['count'] = 1;
                    user_notification_count::create($addCount);
                } else {
                    $addCount['count'] = $notification_penolakan->count + 1;
                    $notification_penolakan->update(['count' => $addCount['count']]);
                }
            }
        }

        if ($laporanUpdate->genba_id != null) {

            $users = user::all();
    
            foreach($users as $ehs) {
                if(auth()->user()->id != $ehs->id) {
                    if ($ehs->roles[0]->name == "EHS"){
                        $ehs_notification = user_notification_count::where('user_id', $ehs->id)->first();
        
                        if($ehs_notification == null) {
                            $addCount['user_id'] = $ehs->id;
                            $addCount['count'] = 1;
                            user_notification_count::create($addCount);
                        } else {
                            $addCount['count'] = $ehs_notification->count + 1;
                            $ehs_notification->update(['count' => $addCount['count']]);
                        }
                    }
                }
            }
        }

        if ($dataLama->genba_id != null){
            $genba = true;
        } else {
            $genba = false;
        }
        
        if ($genba) {
            return redirect('/genba/laporan/'.$dataLama->genba_id)->with('success', 'Laporan Berhasil di Tolak');
        } else {
            return redirect("/patrolEHS/$laporan->patrol_id")->with('success', 'Laporan Berhasil di Tolak');
        }

    }

    public function create_laporan_penanggulangan($id) {
        $allowedRoles = ['Departement Head PIC', 'PIC'];
        $userRole = auth()->user()->getRoleNames()->first();
        $dataLama = laporan::where('id', $id)->first();

        if($dataLama == null) {
            return redirect('/table')->with('error', 'Data Temuan tidak ditemukan');
        }

        if ( $dataLama->deleted_at != null){
            return redirect('/table')->with('error', 'Maaf aktifitas dilarang');
        }
        
        if (!in_array($userRole, $allowedRoles)){
            return redirect('/table')->with('error', 'Account tidak valid, Pembuatan laporan penanggulangan hanya bisa dilakukan oleh PIC');
        }
        
        if($userRole !== "Departement Head PIC") {
            if ($dataLama->PIC_id !== auth()->id()){
                return redirect('/table')->with('error', 'Account tidak valid, Laporan hanya bisa di edit oleh yang membuat PIC yang bersangkutan');
            }
        }
        
        if ($userRole == "Departement Head PIC" && $dataLama->progress == 10){
            return redirect('/table')->with('error', 'Maaf anda tidak bisa melakukan edit pada laporan ini');
        }

        if($dataLama->genba_id == null){
            $inputSementara = false;
        } else {
            $inputSementara = true;
        }
        
        $laporan = laporan::where('id', $id)->first();
        $area = area::all();
        $PIC = User::role('PIC')->get();

        return view('PIC/penanggulangan', ['title' => 'Pembuatan Laporan Perbaikan',
                                     'halaman' => "Laporan",
                                     'active' => 'Laporan Saya',
                                     'laporan' => $laporan,
                                     'areas' => $area,
                                     'PICs' => $PIC,
                                     'inputSementara' => $inputSementara,
                                    'deadline_date_lanjutan'=> $laporan->deadline_date_lanjutan,]);
    }

     public function store_laporan_penanggulangan(Request $request) {
            // Array yang berisi peran yang diizinkan untuk membuat laporan
        $allowedRoles = ['Departement Head PIC', 'PIC'];
        // Mendapatkan peran pengguna yang sedang login
        $userRole = auth()->user()->getRoleNames()->first();
        // Mengambil data laporan yang sudah ada berdasarkan id yang diberikan dalam request
        $dataLama = laporan::where('id', $request->laporan_id)->first();
        // Memeriksa apakah laporan sudah dihapus, jika ya, maka kembali ke halaman /table dengan pesan kesalahan
        if ( $dataLama->deleted_at != null){
            return redirect('/table')->with('error', 'Maaf aktifitas dilarang');
        }


        // Memeriksa apakah peran pengguna termasuk dalam peran yang diizinkan
        // Jika tidak, kembali ke halaman /table dengan pesan kesalahan
        if (!in_array($userRole, $allowedRoles)){
            return redirect('/table')->with('error', 'Account tidak valid, Pembuatan laporan penanggulangan hanya bisa dilakukan oleh PIC');
        }


        // Jika pengguna bukan Departement Head PIC, memeriksa apakah laporan hanya bisa diubah oleh yang membuat laporan
        if($userRole !== "Departement Head PIC") {
            if ($dataLama->PIC_id !== auth()->id()){
                return redirect('/table')->with('error', 'Account tidak valid, Laporan hanya bisa di edit oleh yang membuat PIC yang bersangkutan');
            }
        }


        // Memeriksa apakah pengguna memiliki izin untuk mengedit laporan yang sudah mencapai progress 10%
        if ($userRole == "Departement Head PIC" && $dataLama->progress == 10){
            return redirect('/table')->with('error', 'Maaf anda tidak bisa melakukan edit pada laporan ini');
        }
       
        // Jika progress yang dimasukkan sudah mendekati 100%, memeriksa keberadaan foto penanggulangan
        if ($request->progress >= 9.85){
           
            // Validasi data input berdasarkan aturan yang berlaku
            // Jika foto penanggulangan belum ada, maka wajib diunggah
            if ($dataLama->foto_penanggulangan == null) {


                $validateData = $request->validate([
                    'penanggulangan' => 'required',
                    'temporary_solution' => 'required',
                    'progress' => 'required',
                    'foto_penanggulangan' => 'image|required',
                ]);
            }else{
                $validateData = $request->validate([
                    'penanggulangan' => 'required',
                    'foto_penanggulangan' => 'image|required',
                    'temporary_solution' => 'required',
                    'progress' => 'required',
                ]);
            }


            // Jika terdapat foto penanggulangan yang diunggah, proses dan simpan gambar baru
             
            if (array_key_exists("foto_penanggulangan", $validateData) && $dataLama->foto_penanggulangan !== null) {
               // Hapus gambar lama jika sudah ada
                File::delete(public_path('/gambar/foto_penanggulangan/'.$dataLama->foto_penanggulangan));
            }


            // Proses dan simpan gambar baru
            if (array_key_exists("foto_penanggulangan", $validateData)) {


                $gambar = $request->file('foto_penanggulangan');
                $namaFile = time() . '_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
                $path = public_path('/gambar/foto_penanggulangan');
                // Mengubah ukuran gambar dengan lebar maksimal 720px, menjaga rasio, dan kompres ke kualitas 75%
                $image = Image::make($gambar)
                ->resize(720, 1600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode($gambar->getClientOriginalExtension(), 75);


                // Menyimpan gambar
                $image->save($path . '/' . $namaFile);
       
                $validateData['foto_penanggulangan'] = $namaFile;
            };


            // Update progress laporan menjadi 100%
            $validateData['progress'] = 10;


           
           


            // Tandai waktu pengajuan laporan
            $validateData['PIC_submit_at'] = now();


        } else {
            // Validasi data input jika progress belum mendekati 100%
            $validateData = $request->validate([
                'temporary_solution' => 'required',
                'progress' => 'required',
                'penanggulangan' => '',
                'foto_penanggulangan' => 'image',
            ]);
           
            // Jika terdapat foto penanggulangan yang diunggah, proses dan simpan gambar baru
            if (array_key_exists("foto_penanggulangan", $validateData)) {
                if ($dataLama->foto_penanggulangan !== null) {
                    // Hapus gambar lama jika sudah ada
                    File::delete(public_path('/gambar/foto_penanggulangan/'.$dataLama->foto_penanggulangan));}
            // Proses dan simpan gambar baru
                $gambar = $request->file('foto_penanggulangan');
                $namaFile = time() . '_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
                $path = public_path('/gambar/foto_penanggulangan');
                // Mengubah ukuran gambar dengan lebar maksimal 720px, menjaga rasio, dan kompres ke kualitas 75%
                $image = Image::make($gambar)
                ->resize(720, 1600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode($gambar->getClientOriginalExtension(), 75);


                // Menyimpan gambar
                $image->save($path . '/' . $namaFile);
       
                $validateData['foto_penanggulangan'] = $namaFile;
            }


            // Tandai waktu pengajuan laporan
            $validateData['PIC_submit_at'] = now();
        };
        // Menangkap nilai WO
        if($request->wo != null){
            $validateData['wo'] = $request->wo;
            $validateData['noWO'] = $request->noWO;
        }else{
            $validateData['wo'] = null;
        }
        // Memperbarui data laporan di database
        $laporan =  laporan::where('id' ,$request->laporan_id)->first();


        //due date lanjutan
        if($laporan->status_due_date_lanjutan    == true){
            $deadline_date = Carbon::createFromFormat('d/m/Y', $request->deadline_date_lanjutan)->format('Y-m-d');
            $validateData['deadline_date'] = $deadline_date;
            $validateData['status_due_date_lanjutan'] = false;
        }
        $laporan->update($validateData);
       
        // Mendapatkan informasi laporan yang telah diperbarui
        $laporanUpdate =  laporan::where('id' ,$request->laporan_id)->first();
       
        // Menyusun deskripsi aktivitas yang dilakukan pengguna
        // untuk dicatat dalam log aktivitas
        $deskripsi = auth()->user()->name . " telah melakukan update perbaikan temuan berupa, ";
        $kolomBerubah = $laporan->getChanges();
       
        if (!empty($kolomBerubah)) {
            $perubahan = [];
            foreach ($kolomBerubah as $kolom => $nilai) {
                if ($kolom !== 'deadline_date' && $kolom !== 'updated_at' && $kolom !== "PIC_submit_at") {
                    if($kolom == 'foto_penanggulangan') {
                        $perubahan[] = "penambahan foto bukti penanggulangan";
                    } else if($kolom == 'progress'){
                        $perubahan[] = "$kolom sebanyak ". ($nilai *10)."%";
                    } else if($kolom == 'temporary_solution'){


                    } else {
                        $perubahan[] = "$nilai";
                    }
                }
               
            }
            $deskripsi .= implode(", ", $perubahan);
        } else {
            $deskripsi .= "";
        }


        // Mencatat aktivitas pengguna dalam log aktivitas
        $data = new activity_log();
        $data->user_id = auth()->user()->id;
        $data->auditor_id = $laporan->auditor_id;
        $data->laporan_id = $laporan->id;
        $data->area_id = $laporan->area_id;
        $data->event_type = "update";
        if(auth()->user()->id == $laporan->auditor_id) {
            $data->status_read_auditor = true;
        }
       
        $data->status_read_ehs = true;
        $data->deskripsi = $deskripsi;


        $data->save();


        //email jika temuan diteruskan ke WO
        if($request->wo == 'PE' && $request->progress <10)    
        {
            // Mail::to('mahsunmuh0@gmail.com')->send(new emailWO($laporan));
            Mail::to('dicky.kusworo@astra-juoku.com')->send(new emailWO($laporan));
        }
        if($request->wo == 'ME' && $request->progress <10)    
        {
            Mail::to('zuraida.rochman@astra-juoku.com')->send(new emailWO($laporan));
           
        }
        if($request->wo == 'GA' && $request->progress <10)    
        {
        Mail::to('dewi.kartika@astra-juoku.com')->send(new emailWO($laporan));
        Mail::to('iwan.muhdi@astra-juoku.com')->send(new emailWO($laporan));
        }


        // Mendapatkan ID Departement Head EHS
        $Dept_Head_EHS = DB::table('model_has_roles')
                        ->where('role_id', 6)
                        ->first();
                       
        $is_dept_head_ehs = true;
        // Memperbarui jumlah notifikasi auditor
        $ehs_notification = user_notification_count::where('user_id', $laporanUpdate->auditor_id)->first();
       
        if($ehs_notification == null) {
            $addCount['user_id'] = $laporanUpdate->auditor_id;
            $addCount['count'] = 1;
            user_notification_count::create($addCount);
        } else {
            $addCount['count'] = $ehs_notification->count + 1;
            $ehs_notification->update(['count' => $addCount['count']]);
        }


        // Memperbarui jumlah notifikasi PIC Area dan Dept Head PIC
        $area = area::where('id', $laporanUpdate->area_id)->first();
       
        foreach($area->area as $pic) {
            if (!auth()->user()->hasRole(['Departement Head PIC'])) {
                if($pic->user->hasRole(['Departement Head PIC']) ) {
                    if($Dept_Head_EHS->model_id == $pic->user_id) {
                        $is_dept_head_ehs = false;
                    }
                    $count_notification = user_notification_count::where('user_id', $pic->user_id)->first();
                    if($count_notification == null) {
                        $addCount['user_id'] = $pic->user_id;
                        $addCount['count'] = 1;
                        user_notification_count::create($addCount);
                    } else {
                        $addCount['count'] = $count_notification->count + 1;
                        $count_notification->update(['count' => $addCount['count']]);
                    }
                }
            }
            else {
                if($pic->user->hasRole(['PIC'])) {
                    $count_notification = user_notification_count::where('user_id', $pic->user_id)->first();
                    if($count_notification == null) {
                        $addCount['user_id'] = $pic->user_id;
                        $addCount['count'] = 1;
                        user_notification_count::create($addCount);
                    } else {
                        $addCount['count'] = $count_notification->count + 1;
                        $count_notification->update(['count' => $addCount['count']]);
                    }
                }
            }
        }
       
        if($is_dept_head_ehs){
            if(auth()->user()->id !== $Dept_Head_EHS->model_id) {
                $count_notification_ehs = user_notification_count::where('user_id', $Dept_Head_EHS->model_id)->first();
               
                // Memperbarui jumlah notifikasi Departement Head EHS
                if($count_notification_ehs == null) {
                    $addCount['user_id'] = $Dept_Head_EHS->model_id;
                    $addCount['count'] = 1;
                    user_notification_count::create($addCount);
                } else {
                    $addCount['count'] = $count_notification_ehs->count + 1;
                    $count_notification_ehs->update(['count' => $addCount['count']]);
                }
            }
        }


        // Jika laporan terkait memiliki ID Genba, tambahkan notifikasi kepada EHS
        if ($laporanUpdate->genba_id != null) {


            $users = user::all();
   
            foreach($users as $ehs) {
                if(auth()->user()->id != $ehs->id) {
                    if ($ehs->roles[0]->name == "EHS"){
                        $ehs_notification = user_notification_count::where('user_id', $ehs->id)->first();
       
                        if($ehs_notification == null) {
                            $addCount['user_id'] = $ehs->id;
                            $addCount['count'] = 1;
                            user_notification_count::create($addCount);
                        } else {
                            $addCount['count'] = $ehs_notification->count + 1;
                            $ehs_notification->update(['count' => $addCount['count']]);
                        }
                    }
                }
            }
        }




           
        if ($dataLama->genba_id != null){
            $genba = true;
        } else {
            $genba = false;
        }
       
        if ($genba) {
            return redirect('/genba/laporan/'.$dataLama->genba_id)->with('success', 'Laporan Berhasil di update');
        } else {
            return redirect("/patrolEHS/$dataLama->patrol_id")->with('success', 'Laporan Berhasil di update');
        }
       
    }
    
    public function Accept_PIC(Request $request) {
        
        // Memeriksa apakah pengguna memiliki peran Kepala Departement PIC
        if ( auth()->user()->getRoleNames()->first() !=='Departement Head PIC'){
            return redirect('/table')->with('error', 'Account tidak valid, Proses ACC hanya bisa dilakukan oleh Kepala Departement PIC');
        }

        // Mengambil semua pengguna
        $users = user::all();
        
        // Mengambil data laporan berdasarkan ID yang diberikan dalam request
        $laporan = laporan::where('id', $request->id)->first();

        // Memperbarui status ACC laporan menjadi true, mencatat waktu ACC, serta menaikkan progress menjadi 11
        $laporan->update(['ACC_Dept_Head_PIC_At' => now(),
                          'dept_pic_id' => auth()->user()->id,
                          'progress' => 11]
                          );
                          $laporan->save();

        // Mencatat aktivitas pengguna dalam log aktivitas
        $log = laporan::where('id', $request->id)->first();
        $data = new activity_log();
        $data->user_id = auth()->user()->id;
        $data->auditor_id = $log->auditor_id; 
        $data->laporan_id = $log->id;
        $data->area_id = $log->area_id;
        $data->event_type = "approve";
        if(auth()->user()->id == $log->auditor_id) {
            $data->status_read_auditor = true;
        }
        $data->status_read_ehs = true;
        $data->deskripsi = auth()->user()->name." telah melakukan approval terhadap laporan";;
        
        $data->save();

        // melihat id dept head
        $Dept_Head_EHS = DB::table('model_has_roles')
        ->where('role_id', 6)
        ->first();

        // melihat apakah area termasuk bagian dari dept head ehs atau bukan
        $is_dept_head_ehs = true;

        // Memperbarui jumlah notifikasi auditor
        $ehs_notification = user_notification_count::where('user_id', $log->auditor_id)->first();
        
        if($ehs_notification == null) {
            $addCount['user_id'] = $log->auditor_id;
            $addCount['count'] = 1;
            user_notification_count::create($addCount);
        } else {
            $addCount['count'] = $ehs_notification->count + 1;
            $ehs_notification->update(['count' => $addCount['count']]);
        }

        // Menghitung notifikasi untuk PIC area terkait
        $area = area::where('id', $log->area_id)->first();

        foreach($area->area as $pic) {
            //pengecekan untuk dept head EHS apakah sebagai Dept Head PIC pada area ini juga
            if($Dept_Head_EHS->model_id == $pic->user_id) {
                $is_dept_head_ehs = false;
            }

            if(auth()->user()->id !== $pic->user_id){
                $count_notification = user_notification_count::where('user_id', $pic->user_id)->first();
    
                if($count_notification == null) {
                    $addCount['user_id'] = $pic->user_id;
                    $addCount['count'] = 1;
                    user_notification_count::create($addCount);
                } else {
                    $addCount['count'] = $count_notification->count + 1;
                    $count_notification->update(['count' => $addCount['count']]);
                }
            }
        }

        // Menghitung notifikasi untuk Dept Head EHS jika area bukan bagian dari dept head ehs
        if($is_dept_head_ehs){
            $count_notification_ehs = user_notification_count::where('user_id', $Dept_Head_EHS->model_id)->first();

            if($count_notification_ehs == null) {
            $addCount['user_id'] = $Dept_Head_EHS->model_id;
            $addCount['count'] = 1;
            user_notification_count::create($addCount);
            } else {
            $addCount['count'] = $count_notification_ehs->count + 1;
            $count_notification_ehs->update(['count' => $addCount['count']]);
            }
        }

        // Jika laporan terkait memiliki ID Genba, kirim notifikasi kepada pengguna dengan peran EHS
        if ($log->genba_id != null) {

            $users = user::all();
    
            foreach($users as $ehs) {
                if(auth()->user()->id != $ehs->id) {
                    if ($ehs->roles[0]->name == "EHS"){
                        $ehs_notification = user_notification_count::where('user_id', $ehs->id)->first();
        
                        if($ehs_notification == null) {
                            $addCount['user_id'] = $ehs->id;
                            $addCount['count'] = 1;
                            user_notification_count::create($addCount);
                        } else {
                            $addCount['count'] = $ehs_notification->count + 1;
                            $ehs_notification->update(['count' => $addCount['count']]);
                        }
                    }
                }
            }
        }

        if ($log->genba_id != null){
            $genba = true;
        } else {
            $genba = false;
        }

        if ($genba) {
            return redirect('/genba/laporan/'.$laporan->genba_id)->with('success', 'Laporan Berhasil di Approve');
        } else {
            return redirect("/patrolEHS/$laporan->patrol_id")->with('success', 'Laporan Berhasil di Approve');
        }
        
    }
    // Class import Excel
    public function importIndex(Request $request)
    {
        // Reset session kecuali jika baru upload
        if (!$request->session()->has('success') && !$request->session()->has('error')) {
            $request->session()->forget(['laporan_preview', 'laporan_excel_file']);
            Log::info('Session preview dihapus karena akses halaman import tanpa upload baru.');
        }

        $previewData = session()->get('laporan_preview', collect());
        try {
            $patrols = ehs_patrol::with('laporan_patrol')->latest()->paginate(10);
            Log::info('Loaded patrols with laporan_patrol relationship', ['count' => $patrols->count()]);
        } catch (\Exception $e) {
            Log::error('Failed to load patrols: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('laporan.import.index')->with('error', 'Gagal memuat daftar patrol: ' . $e->getMessage());
        }

        return view('EHS.import-laporan', [
            'title' => 'Import Patrol & Temuan Excel',
            'active' => 'import-laporan',
            'halaman' => 'Patrol EHS',
            'previewData' => $previewData,
            'patrols' => $patrols,
        ]);
    }
    public function storeExcel(Request $request)
    {
        try {
            $request->validate([
                'excel_file' => 'required|file|mimes:xlsx,xls|max:2048',
            ]);

            session()->forget(['laporan_preview', 'laporan_excel_file']);

            $file = $request->file('excel_file');
            $collection = Excel::toCollection(new LaporanImport, $file)->first();

            Log::info('Jumlah baris di collection: ' . $collection->count());
            Log::info('Data mentah collection: ' . json_encode($collection->toArray()));

            $previewData = collect();
            $isValid = true;

            $collection->each(function ($row, $index) use (&$previewData, &$isValid) {
                Log::info('Memproses baris ' . ($index + 2) . ': ' . json_encode($row->toArray()));

                $rowData = [
                    'tanggal' => null,
                    'area' => null,
                    'nama_penemu' => null,
                    'npk' => null,
                    'temuan' => null,
                    'potensi_bahaya' => null,
                    'kategori' => null,
                    'rank' => null,
                    'saran_perbaikan' => null,
                    'url_foto_temuan' => null, // Tambah ini untuk pastikan terdeteksi
                ];

                // Cari kolom tanggal
                $possibleDateKeys = [
                    'tanggal', 'Tanggal', 'TANGGAL', 'date', 'Date', 'DATE',
                    'tgl', 'Tgl', 'TGL', 'tanggal_patrol', 'Tanggal Patrol',
                    'Tanggal_Patrol', 'tanggal patrol', 'date_patrol', 'Date Patrol'
                ];
                foreach ($possibleDateKeys as $key) {
                    if (isset($row[$key]) && trim((string)$row[$key]) !== '') {
                        $rowData['tanggal'] = trim((string)$row[$key]);
                        break;
                    }
                }

                // Proses tanggal
                if ($rowData['tanggal']) {
                    if (is_numeric($rowData['tanggal'])) {
                        try {
                            $dateTime = Date::excelToDateTimeObject($rowData['tanggal']);
                            $rowData['tanggal'] = $dateTime->format('d-m-Y');
                        } catch (\Exception $e) {
                            $rowData['tanggal'] = now()->format('d-m-Y');
                        }
                    } else {
                        $formats = ['d-m-Y', 'd/m/Y', 'Y-m-d', 'm/d/Y', 'd M Y', 'd-M-Y', 'd MMM Y', 'd-MMM-Y', 'm-d-Y', 'Y/m/d'];
                        $parsedDate = null;
                        foreach ($formats as $format) {
                            try {
                                $parsedDate = Carbon::createFromFormat($format, $rowData['tanggal']);
                                if ($parsedDate && $parsedDate->format($format) === $rowData['tanggal']) {
                                    $rowData['tanggal'] = $parsedDate->format('d-m-Y');
                                    break;
                                }
                            } catch (\Exception $e) {
                                continue;
                            }
                        }
                        if (!$parsedDate) {
                            $rowData['tanggal'] = now()->format('d-m-Y');
                        }
                    }
                } else {
                    $rowData['tanggal'] = now()->format('d-m-Y');
                }

                // Pemetaan kolom lain
                $keyMap = [
                    'area' => ['area', 'Area', 'AREA', 'Area Temuan', 'AREA TEMUAN', 'area_temuan'],
                    'nama_penemu' => ['nama_penemu', 'Nama Penemu', 'NAMA PENEMU', 'NAMA_PENEMU'],
                    'npk' => ['npk', 'NPK', 'NPK Penemu', 'NPK PENEMU', 'npk_penemu'],
                    'temuan' => ['temuan', 'Temuan', 'TEMUAN'],
                    'potensi_bahaya' => ['potensi_bahaya', 'Potensi Bahaya', 'POTENSI BAHAYA', 'POTENSI_BAHAYA', 'Risiko Bahaya', 'RISIKO BAHAYA', 'risiko_bahaya'],
                    'kategori' => ['kategori', 'Kategori', 'KATEGORI'],
                    'rank' => ['rank', 'Rank', 'RANK'],
                    'saran_perbaikan' => ['saran_perbaikan', 'Saran Perbaikan', 'SARAN PERBAIKAN', 'SARAN_PERBAIKAN'],
                    'url_foto_temuan' => ['url_foto_temuan', 'URL_Foto_Temuan', 'URL_FOTO_TEMUAN', 'Upload Foto Temuan', 'UPLOAD FOTO TEMUAN', 'upload_foto_temuan'],
                ];
                foreach ($keyMap as $field => $possibleKeys) {
                    foreach ($possibleKeys as $key) {
                        if (isset($row[$key]) && trim((string)$row[$key]) !== '') {
                            $rowData[$field] = trim((string)$row[$key]);
                            break;
                        }
                    }
                }

                Log::info('RowData setelah pemetaan untuk baris ' . ($index + 2) . ': ' . json_encode($rowData));

                // Validasi kolom wajib dan format
                if (empty($rowData['area']) ||
                        empty($rowData['npk']) ||
                        empty($rowData['temuan']) ||
                        empty($rowData['kategori']) ||
                        !in_array(strtoupper($rowData['kategori']), ['5R', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'O']) ||
                        empty($rowData['rank']) ||
                        !in_array(strtoupper($rowData['rank']), ['A', 'B', 'C'])) {
                        $isValid = false;
                        Log::warning('Baris ' . ($index + 2) . ' invalid. Validasi gagal: ' . json_encode($rowData));
                        return false;
                    }
                // Tambah validasi URL opsional
                if (!empty($rowData['url_foto_temuan']) && !filter_var($rowData['url_foto_temuan'], FILTER_VALIDATE_URL)) {
                    Log::warning('URL Foto Temuan tidak valid untuk baris ' . ($index + 2), ['url' => $rowData['url_foto_temuan']]);
                    $rowData['url_foto_temuan'] = null; // Reset jika invalid
                }

                $previewData->push($rowData);
                Log::info('Baris ' . ($index + 2) . ' valid dan dipush ke previewData.');
            });

            Log::info('Total previewData setelah proses: ' . $previewData->count());

            if (!$isValid) {
                session()->forget(['laporan_preview', 'laporan_excel_file']);
                return redirect()->route('laporan.import.index')->with('error', 'Data tidak lengkap atau tidak valid. Silakan periksa kembali data pada kolom wajib (Area, NPK, Temuan, Kategori, Rank).');
            }

            if ($previewData->isEmpty()) {
                session()->forget(['laporan_preview', 'laporan_excel_file']);
                return redirect()->route('laporan.import.index')->with('error', 'File Excel kosong atau format tidak sesuai.');
            }

            session()->put('laporan_preview', $previewData);
            session()->put('laporan_excel_file', $file->store('temp'));

            return redirect()->route('laporan.import.index')->with('success', 'Preview data siap.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            session()->forget(['laporan_preview', 'laporan_excel_file']);
            return redirect()->route('laporan.import.index')->with('error', 'Gagal memproses file: Format data tidak sesuai.');
        } catch (\Exception $e) {
            session()->forget(['laporan_preview', 'laporan_excel_file']);
            return redirect()->route('laporan.import.index')->with('error', 'Gagal memproses file: ' . $e->getMessage());
        }
    }
    // public function downloadTemplate(Request $request)
    // {
    //     $area_id = $request->query('area_id');
    //     if (!$area_id || !area::find($area_id)) {
    //         Log::warning('Download template gagal: Area ID tidak valid', ['area_id' => $area_id]);
    //         return redirect()->route('laporan.import.index')->with('error', 'Pilih area terlebih dahulu.');
    //     }

    //     return Excel::download(new TemplateLaporanExport($area_id), 'template_patrol_temuan_area_' . $area_id . '.xlsx');
    // }
    public function approve(Request $request, $index)
    {
        try {
            $previewData = session()->get('laporan_preview', collect());
            if ($previewData->isEmpty() || !isset($previewData[$index])) {
                Log::warning('Data preview tidak ditemukan untuk index: ' . $index);
                return redirect()->route('laporan.import.index')->with('error', 'Data tidak ditemukan');
            }

            $data = $previewData[$index];
            Log::info('Mencoba approve data: ', ['index' => $index, 'data' => $data]);

            // Validasi data
            if (empty($data['area']) || empty($data['npk']) || empty($data['temuan']) || empty($data['kategori']) || empty($data['rank'])) {
                Log::warning('Data tidak lengkap untuk index: ' . $index, ['data' => $data]);
                return redirect()->route('laporan.import.index')->with('error', 'Data tidak lengkap. Pastikan semua kolom wajib diisi.');
            }

            $area = area::whereRaw('LOWER(name) = ?', [strtolower(trim($data['area']))])->first();
            $penemu = User::where('npk', $data['npk'])->first();

            if (!$area) {
                Log::warning("Area {$data['area']} tidak ditemukan di database.");
                return redirect()->route('laporan.import.index')->with('error', "Area {$data['area']} tidak ditemukan di database.");
            }
            if (!$penemu) {
                Log::warning("Penemu dengan NPK {$data['npk']} tidak ditemukan.");
                return redirect()->route('laporan.import.index')->with('error', "Penemu dengan NPK {$data['npk']} tidak ditemukan.");
            }

            $tanggal_patrol = now()->format('Y-m-d');
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

            $pic = user_has_area::where('area_id', $area->id)
                                ->where('role_id', 4)
                                ->first();
            $pic_id = $pic ? $pic->user_id : auth()->user()->id;

            if (!User::find($pic_id)) {
                Log::error('Invalid pic_id: ' . $pic_id . ' untuk area_id: ' . $area->id);
                return redirect()->route('laporan.import.index')->with('error', 'PIC tidak valid untuk area ini.');
            }

            // Proses URL_Foto_Temuan
            $foto_temuan = null;
            if (!empty($data['url_foto_temuan'])) {
                $url = trim($data['url_foto_temuan']);
                Log::info('Menyimpan URL Google Drive langsung', ['url' => $url, 'index' => $index]);

                // Validasi URL
                if (!filter_var($url, FILTER_VALIDATE_URL) || !preg_match('/drive\.google\.com\/(?:file\/d\/|open\?id=)(.+?)(?:\/view|$)/', $url)) {
                    Log::warning('URL tidak valid atau bukan Google Drive', ['url' => $url]);
                    return redirect()->route('laporan.import.index')->with('error', 'URL untuk baris ' . ($index + 2) . ' tidak valid. Gunakan link Google Drive yang benar.');
                }

                $foto_temuan = $url; // Simpan URL langsung
                Log::info('URL akan disimpan ke foto_temuan', ['url' => $foto_temuan]);
            } else {
                Log::info('Tidak ada URL Foto Temuan', ['index' => $index]);
                return redirect()->route('laporan.import.index')->with('error', 'URL Foto Temuan wajib untuk baris ' . ($index + 2));
            }

            // Simpan ke database
            $laporan = laporan::create([
                'patrol_id' => $patrol->id,
                'area_id' => $area->id,
                'auditor_id' => auth()->user()->id,
                'PIC_id' => $pic_id,
                'tanggal' => Carbon::createFromFormat('d-m-Y', $data['tanggal'])->format('Y-m-d'),  // <--- Revisi ini, pakai $data['tanggal'] dari Excel
                'nama_penemu' => $data['nama_penemu'] ?? $penemu->name,
                'npk' => $data['npk'],
                'temuan' => $data['temuan'],
                'potensi_bahaya' => $data['potensi_bahaya'] ?? null,
                'kategori' => $data['kategori'],
                'rank' => $data['rank'],
                'progress' => 0,
                'deadline_date' => now()->addDays(7)->format('Y-m-d'),
                'foto_temuan' => $foto_temuan,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::info('Laporan tersimpan', ['laporan_id' => $laporan->id, 'foto_temuan' => $foto_temuan ?? 'null']);

            $previewData->forget($index);
            session()->put('laporan_preview', $previewData);

            if ($previewData->isEmpty()) {
                $filePath = session()->get('laporan_excel_file');
                session()->forget(['laporan_preview', 'laporan_excel_file']);
                Storage::delete($filePath);
                Log::info('Session dan file sementara dihapus.');
            }

            if (empty($rowData['tanggal'])) {
                $rowData['tanggal'] = now()->format('d-m-Y');
            }

            return redirect()->route('laporan.import.index')->with('success', 'Patrol dan Temuan berhasil di-approve');
        } catch (\Exception $e) {
            Log::error('Gagal approve: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('laporan.import.index')->with('error', 'Gagal approve: ' . $e->getMessage());
        }
    }

    public function cancel(Request $request, $index)
    {
        try {
            $previewData = session()->get('laporan_preview', collect());
            if ($previewData->isEmpty() || !isset($previewData[$index])) {
                Log::warning('Data preview tidak ditemukan untuk index: ' . $index);
                return redirect()->route('laporan.import.index')->with('error', 'Data tidak ditemukan');
            }

            $previewData->forget($index);
            session()->put('laporan_preview', $previewData);

            if ($previewData->isEmpty()) {
                $filePath = session()->get('laporan_excel_file');
                session()->forget(['laporan_preview', 'laporan_excel_file']);
                Storage::delete($filePath);
                Log::info('Session dan file sementara dihapus.');
            }

            return redirect()->route('laporan.import.index')->with('success', 'Data berhasil dibatalkan');
        } catch (\Exception $e) {
            Log::error('Gagal cancel: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('laporan.import.index')->with('error', 'Gagal cancel: ' . $e->getMessage());
        }
    }
    public function saveExcel(Request $request)
    {
        try {
            $previewData = session()->get('laporan_preview', collect());
            Log::info('Memulai penyimpanan data preview: ', ['count' => count($previewData)]);

            $savedRecords = 0;
            foreach ($previewData as $index => $data) {
                // Validasi data
                if (empty($data['area']) || empty($data['npk']) || empty($data['temuan']) || empty($data['kategori']) || empty($data['rank'])) {
                    Log::warning('Data tidak lengkap untuk index: ' . $index, ['data' => $data]);
                    continue;
                }

                $area = area::whereRaw('LOWER(name) = ?', [strtolower(trim($data['area']))])->first();
                $penemu = User::where('npk', $data['npk'])->first();

                if (!$area) {
                    Log::warning("Area {$data['area']} tidak ditemukan di database.");
                    continue;
                }
                if (!$penemu) {
                    Log::warning("Penemu dengan NPK {$data['npk']} tidak ditemukan.");
                    continue;
                }

                $tanggal_patrol = now()->format('Y-m-d');
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

                $pic = user_has_area::where('area_id', $area->id)
                                    ->where('role_id', 4)
                                    ->first();
                $pic_id = $pic ? $pic->user_id : auth()->user()->id;

                if (!User::find($pic_id)) {
                    Log::error('Invalid pic_id: ' . $pic_id . ' untuk area_id: ' . $area->id);
                    continue;
                }

                // Proses URL_Foto_Temuan
                $foto_temuan = null;
                if (!empty($data['url_foto_temuan'])) {
                    $url = trim($data['url_foto_temuan']);
                    Log::info('Menyimpan URL Google Drive langsung', ['url' => $url, 'index' => $index]);

                    // Validasi URL
                    if (!filter_var($url, FILTER_VALIDATE_URL) || !preg_match('/drive\.google\.com\/(?:file\/d\/|open\?id=)(.+?)(?:\/view|$)/', $url)) {
                        Log::warning('URL tidak valid atau bukan Google Drive', ['url' => $url]);
                        continue;
                    }

                    $foto_temuan = $url;
                    Log::info('URL akan disimpan ke foto_temuan', ['url' => $foto_temuan]);
                } else {
                    Log::info('Tidak ada URL Foto Temuan', ['index' => $index]);
                    continue;
                }

                // Simpan ke database
                $laporan = laporan::create([
                    'patrol_id' => $patrol->id,
                    'area_id' => $area->id,
                    'auditor_id' => auth()->user()->id,
                    'PIC_id' => $pic_id,
                    'tanggal' => Carbon::createFromFormat('d-m-Y', $data['tanggal'])->format('Y-m-d'),
                    'nama_penemu' => $data['nama_penemu'] ?? $penemu->name,
                    'npk' => $data['npk'],
                    'temuan' => $data['temuan'],
                    'potensi_bahaya' => $data['potensi_bahaya'] ?? null,
                    'kategori' => $data['kategori'],
                    'rank' => $data['rank'],
                    'progress' => 0,
                    'deadline_date' => now()->addDays(7)->format('Y-m-d'),
                    'foto_temuan' => $foto_temuan,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                Log::info('Laporan tersimpan: ', ['laporan_id' => $laporan->id]);
                $savedRecords++;
            }

            if ($savedRecords > 0) {
                $filePath = session()->get('laporan_excel_file');
                session()->forget(['laporan_preview', 'laporan_excel_file']);
                Storage::delete($filePath);
                Log::info('Session dan file sementara dihapus.', ['saved_records' => $savedRecords]);
                return redirect()->route('laporan.import.index')->with('success', "$savedRecords laporan berhasil disimpan.");
            }

            Log::info('Tidak ada laporan yang disimpan.', ['saved_records' => $savedRecords]);
            return redirect()->route('laporan.import.index')->with('error', 'Tidak ada laporan yang disimpan. Pastikan data valid.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan laporan: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('laporan.import.index')->with('error', 'Gagal menyimpan laporan: ' . $e->getMessage());
        }
    }

}
