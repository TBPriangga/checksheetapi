<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\area;
use App\Models\User;
use App\Models\user_has_area;
use App\Models\laporan;
use App\Models\position;
use App\Models\activity_log;
use App\Models\department;
use App\Models\detail_departement;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class SettingController extends Controller
{
    public function indexKaryawan() {
        if ( auth()->user()->getRoleNames()->first() !== 'Admin' ){
            if(auth()->user()->getRoleNames()->first() !== 'EHS' ){
                return redirect('/')->with('error', 'Account tidak valid, Halaman ini hanya bisa diakses oleh Admin');
            
            }
        }
        
        $JumlahKaryawans = User::count();
        $karyawans = User::where('deleted_at', null)->get();
        $departements = department::count();
        $positions = position::count();

        return view('admin.karyawan.dashboard_management', ['title' => 'Dashboard Karyawan',
                                  'active' => 'Account Management',
                                  'halaman' => "Setting",
                                  'jumlahKaryawans' => $JumlahKaryawans,
                                  'karyawans' => $karyawans,
                                  'departements' => $departements,
                                  'positions' => $positions,
                                ]);
    }

    public function createKaryawan() {
        if ( auth()->user()->getRoleNames()->first() !== 'Admin' ){
            if(auth()->user()->getRoleNames()->first() !== 'EHS' ){
                return redirect('/')->with('error', 'Account tidak valid, Halaman ini hanya bisa diakses oleh Admin');
            }
        }
        $area = area::all();
        $role = role::get();
        $departments = department::get();
        $positions = position::get();
        $detail_departements = detail_departement::get();
        
        return view('admin.karyawan.create_karyawan', 
        ['title' => 'Tambah Karyawan',
        'active' => 'Account Management',
         'halaman' => "Setting",
         'areas' => $area,
         'roles' => $role,
         'departments' => $departments,
         'detail_departements' => $detail_departements,
         'positions' => $positions,
        ],);
    }

    public function storeKaryawan(Request $request) {

        // Memeriksa apakah pengguna yang sedang login memiliki role Admin atau EHS
        if ( auth()->user()->getRoleNames()->first() !=='Admin' ){
            if(auth()->user()->getRoleNames()->first() !== 'EHS' ){
                return redirect('/')->with('error', 'Account tidak valid, Halaman ini hanya bisa diakses oleh Admin');
            }
        }

        // Memvalidasi data yang dikirimkan melalui form
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'npk' => 'required|unique:users|min:5',
            'username' => 'required|unique:users|min:6',
            'dept_id' => 'required',
            'position_id' => 'required',
            'detail_dept_id' => 'required',
            'password' => 'required|min:8',
            'role' => 'required',
            'area' => '',
        ]);       

        // Mengenkripsi password sebelum menyimpannya
        $validateData['password'] = Hash::make($validateData['password']);
        // Menyimpan data karyawan ke dalam database
        $karyawan = user::create($validateData);

        foreach($validateData['role'] as $newRole) {
            // Mendapatkan role dari database berdasarkan ID yang dipilih
            $roles = Role::where('id', $newRole)->first();
            // Memberikan role yang dipilih kepada karyawan yang baru ditambahkan
            $karyawan->assignRole($roles);
        }

        return redirect('/karyawan')->with('success', 'Karyawan Berhasil ditambahkan');
    }

    public function detailKaryawan($id) {

        if ( auth()->user()->getRoleNames()->first() !== 'Admin' ){
            if(auth()->user()->getRoleNames()->first() !== 'EHS' ){
                return redirect('/')->with('error', 'Account tidak valid, Halaman ini hanya bisa diakses oleh Admin');
            }
        }

        $karyawan = User::where('id', $id)->first();

        return view('admin.karyawan.detail_karyawan', ['title' => 'Profile Karyawan',
                                  'active' => 'Account Management',
                                  'halaman' => "Setting",
                                  'karyawan' => $karyawan,
                                ]);
    }

    public function editKaryawan($id) {

        if ( auth()->user()->getRoleNames()->first() !== 'Admin' ){
            if(auth()->user()->getRoleNames()->first() !== 'EHS' ){
                return redirect('/')->with('error', 'Account tidak valid, Halaman ini hanya bisa diakses oleh Admin');
            }
        }

        $karyawan = User::where('id', $id)->first();
        $areas = area::all();
        $role = role::get();
        $departments = department::get();
        $positions = position::get();
        $detail_departements = detail_departement::get();

        return view('admin.karyawan.edit_karyawan', ['title' => 'Profile Karyawan',
                                  'active' => 'Account Management',
                                  'halaman' => "Setting",
                                  'karyawan' => $karyawan,
                                  'areas' => $areas,
                                  'roles' => $role,
                                  'departments' => $departments,
                                  'detail_departements' => $detail_departements,
                                  'positions' => $positions,
                                ]);
    }

    public function updateKaryawan(Request $request, $id) {
        
        if ( auth()->user()->getRoleNames()->first() !=='Admin' ){
            if(auth()->user()->getRoleNames()->first() !== 'EHS' ){
                return redirect('/')->with('error', 'Account tidak valid, Halaman ini hanya bisa diakses oleh Admin');
            }
        }

        $karyawan = user::where('id', $id)->first();

        if($request->password == null) {
            $request['password'] = $karyawan->password;
        } else {
            $request['password'] = Hash::make($request->password);
        }
        
        if ($request->role == 4 && $request->area == null) {
            return redirect('/karyawan/create')->with('error', 'PIC harus memilih Area, Silakan refresh jika terjadi error kembali');
        };
        
        $validateData = $request->validate([
            'name' => 'required',
            'email' => ['required', Rule::unique('users')->ignore($id)],
            'npk' => ['required','min:5', Rule::unique('users')->ignore($id)],
            'username' => ['required','min:6', Rule::unique('users')->ignore($id)],
            'dept_id' => 'required',
            'position_id' => 'required',
            'detail_dept_id' => 'required',
            'password' => 'required','min:8',
        ]);

        $validateData2 = $request->validate([
            'role' => 'required',
            'area' => '',
        ]);       
        $roles = Role::whereIn('id', $validateData2['role'])->pluck('name')->toArray();
        $karyawan->syncRoles([$roles]);
        
        $karyawanUpdate = user::where('id' ,$id)->update($validateData);

        if (array_key_exists("area", $validateData2)) {
            user_has_area::where('user_id', $id)->delete();
            $validateData['user_id'] = $id;
            $validateData['area_id'] = $validateData2['area'];
            $validateData['role_id'] = $request->role;
            $user_has_area = user_has_area::create($validateData);
        }
        

        return redirect('/karyawan')->with('success', 'Karyawan Berhasil Diperbarui');
    }

    public function deleteKaryawan(Request $request){
        if ( auth()->user()->getRoleNames()->first() !=='Admin' ){
            if(auth()->user()->getRoleNames()->first() !== 'EHS' ){
                return redirect('/')->with('error', 'Account tidak valid, Halaman ini hanya bisa diakses oleh Admin');
            }
        }

        $user = User::where('id', $request->id)->first();
        $roles = $user->getRoleNames();
        foreach($roles as $role){
            $user->removeRole($role);
        }
        $area = User_has_area::where('user_id', $request->id)->first();
        if($area !== null) {
            User_has_area::where('user_id', $request->id)->delete();
        }

        User::where('id', $request->id)->update(['deleted_at' => now()]);

        return redirect('/karyawan')->with('success', 'Data Berhasil Di hapus');
    }

    public function storeArea(Request $request) {

        if ( auth()->user()->getRoleNames()->first() !=='Admin' ){
            if(auth()->user()->getRoleNames()->first() !== 'EHS' ){
                return redirect('/')->with('error', 'Account tidak valid, Halaman ini hanya bisa diakses oleh Admin');
            }
        }

        $validateData = $request->validate([
            'name' => 'required',
        ]);       

        
        area::create($validateData);
        
        return redirect('/area')->with('success', 'Area Berhasil ditambahkan');
    }

    public function indexArea() {

        if ( auth()->user()->getRoleNames()->first() !=='Admin' ){
            if(auth()->user()->getRoleNames()->first() !== 'EHS' ){
                return redirect('/')->with('error', 'Account tidak valid, Halaman ini hanya bisa diakses oleh Admin');
            }
        }
        $areas = area::all();
        $picRole = Role::where('name', 'PIC')->orWhere('name', 'Departement Head PIC')->get();
        $usersWithPicRole = collect(); // Initialize an empty collection

        foreach ($picRole as $role) {
            $usersWithPicRole = $usersWithPicRole->merge($role->users()->get());
        }

        return view('admin.area.dashboard_area', ['title' => 'Dashboard Karyawan',
                                  'active' => 'area Management',
                                  'halaman' => "Setting",
                                  'areas' => $areas,
                                  'users' => $usersWithPicRole
                                ]);
    }

    public function deleteArea(Request $request){
        if ( auth()->user()->getRoleNames()->first() !=='Admin' ){
            if(auth()->user()->getRoleNames()->first() !== 'EHS' ){
                return redirect('/')->with('error', 'Account tidak valid, Halaman ini hanya bisa diakses oleh Admin');
            }
        }

        area::where('id', $request->id)->delete();
       
        User_has_area::where('area_id', $request->id)->delete();

        return redirect('/area')->with('success', 'Area Berhasil Di hapus');
    }

    public function pic_assign(Request $request){
        
        if ( auth()->user()->getRoleNames()->first() !=='Admin' ){
            if(auth()->user()->getRoleNames()->first() !== 'EHS' ){
                return redirect('/')->with('error', 'Account tidak valid, Halaman ini hanya bisa diakses oleh Admin');
            }
        }
        $validateData = $request->validate([
            'user_id' => 'required',
            'area_id' => 'required',
        ]);
        $user = user::where('id', $validateData['user_id'])->first();
        $validateData['role_id'] = $user->roles[0]->id;

        User_has_area::create($validateData);
        
        return redirect('/area')->with('success', 'PIC berhasil ditambahkan');
    }

    public function pic_remove_area(Request $request){
        
        if ( auth()->user()->getRoleNames()->first() !=='Admin' ){
            if(auth()->user()->getRoleNames()->first() !== 'EHS' ){
                return redirect('/')->with('error', 'Account tidak valid, Halaman ini hanya bisa diakses oleh Admin');
            }
        }

        $validateData = $request->validate([
            'id' => 'required',
        ]);

        User_has_area::where('id', $request->id)->delete();
        
        return redirect('/area')->with('success', 'PIC berhasil dihapuskan dari area');
    }
    
    public function table_activity(Request $request){
        // Mendapatkan role pengguna yang sedang login
        $role = auth()->user()->getRoleNames()->first();
        // Variabel untuk menandai apakah pengguna merupakan anggota atau bukan
        $member = false;

        if ($request->ajax()){

            // Kolom yang digunakan dalam tabel
            $columns = array( 
                0 =>'',
                1 =>'event_type',
                2 =>'user_id',
                3 =>'area_id',
                4 =>'deskripsi',
                5 =>'created_at',
            );

            // Batasan dan awal data yang akan ditampilkan
            $limit = $request->input('length', 10);
            $start = $request->input('start', 0);
            $orderColumnIndex = $request->input('order.0.column', 5);
            $orderColumnName = $columns[5];
            if ($request->input('order.0.dir') == "asc") {
                $dir = "desc";
            } else {
                $dir = "asc";
            }

             // Mendapatkan tanggal awal dan akhir dari permintaan
            $timeEnd = Carbon::createFromFormat('d/m/Y', $request->input('timeEnd'))->format('Y-m-d');
            $timeStart = Carbon::createFromFormat('d/m/Y', $request->input('timeStart'))->format('Y-m-d');
            
            if ($role == 'PIC' || $role == 'Dept Head PIC') {
                // Query untuk pengguna dengan peran PIC atau Kepala Departemen PIC
                $query = activity_log::select('activity_logs.*')->join('user_has_areas', 'user_has_areas.area_id', '=', 'activity_logs.area_id')
                          ->where('user_has_areas.user_id', auth()->user()->id)->whereBetween('activity_logs.created_at', [$timeStart." 00:00:00", $timeEnd." 23:59:59"]);
                $member = true;
               
            } else if ($role == 'member') {
                // Query untuk pengguna dengan peran anggota
                $query = activity_log::join('laporan', 'laporan.id', '=', 'activity_logs.laporan_id')
                ->join('genba_details','genba_details.genba_id','=', 'laporan.genba_id')
                ->select('activity_logs.*','laporan.genba_id as genba_id', 'genba_details.user_id as member_id')
                ->where('genba_details.user_id', auth()->user()->id)->whereBetween('activity_logs.created_at', [$timeStart." 00:00:00", $timeEnd." 23:59:59"]);
                $member = true;
            }  else if ($role == 'EHS') {
                // Query untuk pengguna dengan peran anggota
                $query = activity_log::select('activity_logs.*')->join('laporan', 'laporan.id', '=', 'activity_logs.laporan_id')
                ->where('laporan.auditor_id', auth()->user()->id)->whereBetween('activity_logs.created_at', [$timeStart." 00:00:00", $timeEnd." 23:59:59"])->orWhere('activity_logs.user_id', auth()->user()->id)->whereBetween('activity_logs.created_at', [$timeStart." 00:00:00", $timeEnd." 23:59:59"]);
                $member = true;
            } else {
                // Query untuk pengguna dengan peran lainnya
                $query = activity_log::query();
            }
            
            // Jika pengguna bukan anggota, tambahkan batasan waktu pada query
            if(!$member) {
                $query->whereBetween('created_at', [$timeStart." 00:00:00", $timeEnd." 23:59:59"]);
            }
            
            // Menghitung total data
            $totalData = $query->count();
            $totalFiltered = $totalData; 
            if(empty($request->input('search.value'))) {            
                $posts = $query->offset($start)
                ->limit($limit)
                ->orderBy($orderColumnName, $dir)
                ->get();
            } else {
                $search = $request->input('search.value');


                if ($role == 'EHS') {
                    $posts = activity_log::select('activity_logs.*')
                        ->where(function($query) use ($search) {
                            $query->where('deskripsi', 'LIKE', "%{$search}%");
                        })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($orderColumnName, $dir)
                        ->get();
               
                    // Hitung total data yang difilter
                    $totalFiltered = activity_log::select('activity_logs.*')
                        ->where(function($query) use ($search) {
                            $query->where('deskripsi', 'LIKE', "%{$search}%");
                        })
                        ->count();
                }else{
                    $posts =  $query->where('deskripsi','LIKE',"%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($orderColumnName, $dir)
                    ->get();
                   
                    $totalFiltered = $query->where('deskripsi','LIKE',"%{$search}%")->count();
                }

            }
            
            // Mendapatkan data yang relevan
            $data = array();
            if(!empty($posts)) {
                foreach ($posts as $index => $post) {
                    $nestedData['iteration'] = $totalData - $start - $index;
                    if($post->event_type == "edit"){
                        $nestedData['event'] = '<span class="label label-warning">'.$post->event_type.'</span>';
                    } else if ($post->event_type == "create" || $post->event_type == "approve")   {
                        $nestedData['event'] = '<span class="label label-primary">'.$post->event_type.'</span>';
                    } else if ($post->event_type == "delete" || $post->event_type == "tolak"){
                        $nestedData['event'] = '<span class="label label-danger">'.$post->event_type.'</span>';
                    } else {
                        $nestedData['event'] = '<span class="label label-info">'.$post->event_type.'</span>';
                    }
                    $nestedData['user'] = $post->user_log->name;
                    $nestedData['area'] = $post->area_log->name;
                    $nestedData['deskripsi'] = $post->deskripsi;
                    $nestedData['waktu'] = $post->created_at->format('g:i a - d.m.Y');
                    if($post->laporan_log->genba_id == null){
                        $nestedData['action'] = '<td><a class="btn btn-info btn-block compose-mail" href="detail/' . $post->laporan_id . '">See Detail</a></td>';
                    } else {
                        $nestedData['action'] = '<td><a class="btn btn-info btn-block compose-mail" href="genba/laporan/temuan/' . $post->laporan_id . '">See Detail</a></td>';
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

        return view('auth.activity', ['title' => 'Activity Log',
                                  'active' => '-',
                                  'halaman' => "-",
                                ]);
    }
    
}
