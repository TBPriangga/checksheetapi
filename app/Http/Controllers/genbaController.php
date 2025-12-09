<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\team;
use App\Models\team_member;
use App\Models\genba;
use App\Models\laporan;
use App\Models\activity_log;
use App\Models\user;
use App\Models\area;
use App\Models\genba_detail;
use App\Models\penilaian;
use App\Models\analisis_genba;
use App\Models\user_notification_count;
use App\Mail\reminderNIlai;
use App\Mail\urgentMail;
use App\Mail\reminderDeadline;
use App\Mail\genbaPatrol;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class genbaController extends Controller
{

    public function tableTemuan() {

        
        $areas = area::all();    
    
        return view('management.laporan.table_temuan', ['title' => 'Temuan Gemba Management',
                                  'active' => 'temuan_genba',
                                  'halaman' => "genba",
                                  'areas' => $areas,
                                ]);
    }

    public function indexTeam() {

        $team = team::where('deleted_at', null)->get();
        return view('management.team.dashboard', 
        ['title' => 'Dashboard Team Genba Management',
         'active' => 'team',
         'halaman' => "genba",
         'teams' => $team],);
    }

    public function detailTeam($id) {
        $team = team::where('id', $id)->first();
        return view('management.team.detail', 
        ['title' => 'Detail Team Genba Management',
         'active' => 'team',
         'halaman' => "genba",
         'team' => $team],);
    }

    public function createTeam() {

        return view('management.team.create', 
        ['title' => 'Pembuatan Team Genba Management',
        'active' => 'team',
         'halaman' => "genba",],);
    }

    public function storeTeam(Request $request) {
        // Memeriksa apakah tidak ada anggota tim yang dipilih
        if($request->userID == null) {
            return redirect()->back()->with('error', 'Anggota team tidak boleh kosong');
        }
        // Memeriksa apakah nama tim tidak diisi atau kosong
        if($request->name == null || $request->name == "") {
            return redirect()->back()->with('error', 'Nama team tidak boleh kosong');
        }

        // Memvalidasi input data
        $validateData = $request->validate([
            'name' => 'required',
            'userID' => 'required',
        ]);

        // Membuat tim baru
        $team = team::create($validateData);

        // Menyimpan anggota-anggota tim menggunakan foreach
        foreach ($validateData['userID'] as $value) {
            $validateData['user_id'] = $value;
            $validateData['team_id'] = $team->id;
            team_member::create($validateData);
        }

        return redirect('/genba/team')->with('success', 'Team berhasil dibuat');
    }

    public function editTeam($id) {
        
        return view('management.team.edit', 
        ['title' => 'Edit Team Genba Management',
         'active' => 'team',
         'halaman' => "genba",
         'team_id' => $id],);
    }

    public function UpdateTeam(Request $request) {
        // Memeriksa apakah tidak ada anggota tim yang dipilih
        if($request->userID == null) {
            return redirect()->back()->with('error', 'Anggota team tidak boleh kosong');
        }
        // Memeriksa apakah nama tim tidak diisi atau kosong
        if($request->name == null || $request->name == "") {
            return redirect()->back()->with('error', 'Nama team tidak boleh kosong');
        }

        // Memvalidasi input data
        $validateData = $request->validate([
            'name' => 'required',
            'userID' => 'required',
        ]);

        // Memperbarui nama tim
        $team = Team::where('id', $request->team_id)->update(['name' => $validateData['name']]);
        
        // Menghapus anggota tim yang ada
        team_member::where('team_id', $request->team_id)->delete();

        // Menyimpan anggota-anggota tim yang baru
        foreach ($validateData['userID'] as $value) {
            $validateData['user_id'] = $value;
            $validateData['team_id'] = $request->team_id;
            team_member::create($validateData);
        }

        return redirect('/genba/team')->with('success', 'Team berhasil diubah');
    }

    public function destroyTeam($id) {

        // Memperbarui waktu hapus (soft delete) untuk tim
        $team = Team::where('id', $id)->update(['deleted_at' => now()]);

        // Menghapus anggota tim yang terkait
        team_member::where('team_id', $id)->delete();

        // Mengarahkan kembali ke halaman tim dengan pesan sukses
        return redirect('/genba/team')->with('success', 'Team berhasil dihapus');
    }

    public function indexSchedule(Request $request) {

        if ($request->ajax()){

            // Definisikan kolom-kolom yang akan digunakan untuk pengurutan
            $columns = array( 
                0 =>'created_at', 
                1 =>'team',
                2 =>'area',
                3 =>'tanggal',
                4 =>'action',
            );

            // Ambil parameter dari request untuk pengaturan tabel datatables
            $limit = $request->input('length', 10);
            $start = $request->input('start', 0);
            $orderColumnIndex = $request->input('order.0.column', 0);
            $orderColumnName = $columns[$orderColumnIndex] ?? 'tanggal_patrol';
            
            // Tentukan arah pengurutan
            if ($request->input('order.0.dir') == "asc") {
                $dir = "desc";
            } else {
                $dir = "asc";
            }
            
            // Ubah kolom yang akan diurutkan pertama kali menjadi tanggal_patrol
            if ($orderColumnName == "created_at") {
                $orderColumnName = "tanggal_patrol";
            }

            // Ambil tanggal awal dan akhir dari request dan format ulang menjadi Y-m-d
            $timeStart = Carbon::createFromFormat('d/m/Y', $request->input('timeStart'))->format('Y-m-d');
            $timeEnd = Carbon::createFromFormat('d/m/Y', $request->input('timeEnd'))->format('Y-m-d');

            // membuat queri berdasarkan tanggal dan pastikan data yang dihapus tidak ikut ditampilkan
            $query = genba::query()
                ->whereBetween('tanggal_patrol', [$timeStart, $timeEnd])
                ->whereNull("deleted_at");
          
            // Hitung total data yang ada
            $totalData = $query->count();
            $totalFiltered = $totalData; 

            // Proses pencarian data
            if(empty($request->input('search.value'))) {            
                $posts = $query->offset($start)
                ->limit($limit)
                ->orderBy($orderColumnName, $dir)
                ->get();
            } else {
                $search = $request->input('search.value'); 
                
                $posts =  $query->where('temuan','LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($orderColumnName, $dir)
                ->get();

                // Hitung total data yang difilter
                $totalFiltered = $query->where('temuan','LIKE',"%{$search}%")
                ->count();
            }

            // membuat data yang akan dikirim sebagai JSON
            $data = array();
            if(!empty($posts)) {
                foreach ($posts as $index => $post) {
                    $nestedData['iteration'] = $totalData - $start - $index;
                    $nestedData['team'] = $post->team->name;
                    $nestedData['area'] = $post->genba_area->name;
                    $nestedData['tanggal'] = date('d/m/Y', strtotime($post->tanggal_patrol));                    
                    $nestedData['action'] = '<td><a class="btn btn-info btn-block compose-mail" href="/genba/laporan/' . $post->id . '">See Detail</a></td>';
                    
                    $data[] = $nestedData;
                    
                }
            }

            // membuat array JSON untuk respons
            $json_data = array(
                "draw"            => intval($request->input('draw')),  
                "recordsTotal"    => intval($totalData),  
                "recordsFiltered" => intval($totalFiltered), 
                "data"            => $data   
            );
                        
            return response()->json($json_data); 
        }

        // $genbas = genba::where('deleted_at', null)->get();

        return view('management.schedule.dashboard', 
        ['title' => 'Dashboard Schedule Genba Management',
         'active' => 'schedule',
         'halaman' => "genba",
        //  'genbas' => $genbas
        ],);
    }

    public function createSchedule() {

        return view('management.schedule.create', 
        ['title' => 'Pembuatan Schedule Genba Management',
         'active' => 'schedule',
         'halaman' => "genba",],);
    }

    public function storeSchedule(Request $request) {

        // Memeriksa apakah area tidak dipilih
        if($request->area_id == null) {
            return redirect()->back()->with('error', 'Area tidak boleh kosong');
        }

        // Memeriksa apakah area yang dipilih memiliki PIC
        if($request->PIC_id == null) {
            return redirect()->back()->with('error', 'Area yang dipilih harus memiliki Seorang PIC');
        }

        // Memeriksa apakah tanggal kosong
        if($request->tanggal_patrol == null) {
            return redirect()->back()->with('error', 'Tanggal tidak boleh kosong');
        }

         // Memeriksa apakah tim kosong
        if($request->team_id == null) {
            return redirect()->back()->with('error', 'Team tidak boleh kosong');
        }

        // Memeriksa apakah anggota tim kosong
        if($request->userID == null) {
            return redirect()->back()->with('error', 'Anggota team tidak boleh kosong');
        }

        // Memeriksa apakah PIC auditor tidak dipilih
        if($request->PIC_auditor == null) {
            return redirect()->back()->with('error', 'Harus memilih salah satu anggota untuk menjadi PIC auditor');
        }

        // Menyiapkan data untuk disimpan
        $inputData['area_id'] = $request->area_id;
        $inputData['tanggal_patrol'] = Carbon::createFromFormat('d/m/Y', $request->tanggal_patrol)->format('Y-m-d');
        $inputData['pic_auditor_id'] = $request->PIC_auditor;
        $inputData['team_id'] = $request->team_id;
        
        // Membuat jadwal patroli baru
        $genba = genba::create($inputData);

        // Menyimpan detail jadwal genba management
        $inputData['genba_id'] = $genba->id;
        $inputData['userID'] = $request->userID;

        foreach ($inputData['userID'] as $value) {
            $inputData['user_id'] = $value;
            $inputData['genba_id'] = $genba->id;
            genba_detail::create($inputData);
        }
        return redirect('/genba/schedule')->with('success', 'Team berhasil dibuat');
    }

    
    public function updateSchedule(Request $request) {

        // Memeriksa apakah area tidak dipilih
        if($request->area_id == null) {
            return redirect()->back()->with('error', 'Area tidak boleh kosong');
        }
        
        // Memeriksa apakah area yang dipilih memiliki PIC
        if($request->PIC_id == null) {
            return redirect()->back()->with('error', 'Area yang dipilih harus memiliki Seorang PIC');
        }

        // Memeriksa apakah tanggal tidak dipilih
        if($request->tanggal_patrol == null) {
            return redirect()->back()->with('error', 'Tanggal tidak boleh kosong');
        }

        // Memeriksa apakah tim tidak dipilih
        if($request->team_id == null) {
            return redirect()->back()->with('error', 'Team tidak boleh kosong');
        }

        // Memeriksa apakah anggota tim tidak dipilih
        if($request->userID == null) {
            return redirect()->back()->with('error', 'Anggota team tidak boleh kosong');
        }

        // Memeriksa apakah PIC auditor tidak dipilih
        if($request->PIC_auditor == null) {
            return redirect()->back()->with('error', 'Harus memilih salah satu anggota untuk menjadi PIC auditor');
        }

        // Menyiapkan data untuk disimpan
        $inputData['area_id'] = $request->area_id;
        $inputData['tanggal_patrol'] =Carbon::createFromFormat('d/m/Y', $request->tanggal_patrol)->format('Y-m-d');
        $inputData['pic_auditor_id'] = $request->PIC_auditor;
        $inputData['team_id'] = $request->team_id;
        
        // Memperbarui jadwal genba management
        $genba = genba::where('id', $request->genba_id)->update($inputData);

        $inputData['genba_id'] = $request->genba_id;
        $inputData['userID'] = $request->userID;

        // Menghapus detail jadwal patroli yang lama
        genba_detail::where('genba_id', $inputData['genba_id'])->delete();

        // Menyimpan kembali detail jadwal patroli yang baru
        foreach ($inputData['userID'] as $value) {
            $inputData['user_id'] = $value;
            $inputData['genba_id'] = $request->genba_id;
            genba_detail::create($inputData);
        }
        return redirect('/genba/schedule')->with('success', 'Team berhasil dibuat');
    }

    public function editSchedule($id) {
        $genba = genba::where('id', $id)->first();

        return view('management.schedule.edit', 
        ['title' => 'Dashboard Schedule Genba Management',
         'active' => 'schedule',
         'halaman' => "genba",
         'genba' => $genba],);
    }

    public function destroySchedule($id) {

        genba::where('id', $id)->update(['deleted_at' => now()]);

        return redirect('/genba/team')->with('success', 'Team berhasil dihapus');
    }

    public function genbaDetail($id) {

        // Mengambil data jadwal patroli berdasarkan ID
        $genba = genba::where('id', $id)->first();
        

        // Mengambil temuan-temuan yang terkait dengan jadwal patroli
        $temuans = laporan::where('genba_id', $genba->id)->where('deleted_at', null)->get();
        if($temuans->isEmpty()){
            $exportVisible = false;
        } else {
            $exportVisible = true;
        }
        // Menghitung total nilai dari dari para member team
        $totalNilai = 0;
        $count = 0;
        foreach ($genba->detail as $nilai){
            if($nilai->genba_nilai != null)
            {
            ($totalNilai += $nilai->genba_nilai->pertanyaan_1 + 
            $nilai->genba_nilai->pertanyaan_2 + 
            $nilai->genba_nilai->pertanyaan_3 + 
            $nilai->genba_nilai->pertanyaan_4 + 
            $nilai->genba_nilai->pertanyaan_5 + 
            $nilai->genba_nilai->pertanyaan_6 + 
            $nilai->genba_nilai->pertanyaan_7 + 
            $nilai->genba_nilai->pertanyaan_8 + 
            $nilai->genba_nilai->pertanyaan_9 + 
            $nilai->genba_nilai->pertanyaan_10);
        } else {
            $totalNilai += 0;
        }
        $count += 1;
    }

    // Menghitung rata-rata nilai
    $totalNilai = $totalNilai / $count;

        return view('management.laporan.detail', 
        ['title' => 'Dashboard Schedule Genba Management',
         'active' => 'schedule',
         'halaman' => "genba",
         'genba' => $genba,
         'temuans' => $temuans,
         'total_nilai' => $totalNilai,
         'exportVisible' => $exportVisible
        ]);
    }

    public function createTemuan($id) {
        $genba = genba::where('id', $id)->first();

        return view('management.laporan.create_temuan', 
        ['title' => 'Dashboard Schedule Genba Management',
         'active' => 'schedule',
         'halaman' => "genba",
         'genba' => $genba,]);
    }

    public function storeTemuan(request $request) {
        
        // Validasi input data
        $validateData = $request->validate([
            'auditor_id' => 'required',
            'PIC_id' => 'required',
            'area_id' => 'required',
            'rank' => 'required|in:A,B,C',
            'kategori' => 'required|in:5R,A,B,C,D,E,F,G,O',
            'progress' => 'required',
            'man' => '',
            'material' => '',
            'machine' => '',
            'methode' => '',
            'what' => '',
            'when' => '',
            'where' => '',
            'why' => '',
            'how' => '',
            'foto_temuan' => 'image|required',
            'deadline_date' => 'required',
        ]);

        // Konversi tanggal deadline menjadi objek Carbon
        $validateData['deadline_date'] = Carbon::createFromFormat('d/m/Y', $request->deadline_date);
        
        // Memeriksa apakah tanggal deadline sudah lewat
        $now = Carbon::now();
        if ($validateData['deadline_date']->lte($now)) {
            return redirect()->back()->with('error', 'Due Date harus lebih dari tanggal sekarang')->withInput();
        }

        // Memproses dan menyimpan gambar temuan
        $gambar = $request->file('foto_temuan');
        $namaFile = time() . '_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
        $path = public_path('/gambar/foto_temuan');
        Image::make($gambar)->encode($gambar->getClientOriginalExtension(), 90)->save($path.'/'.$namaFile);

        // Membuat temuan baru
        $validateData['foto_temuan'] = $namaFile;
        $genba = analisis_genba::create($validateData);
        $validateData['genba_id'] = $request->genba_id;
        $validateData['analisis_genba_id'] = $genba->id;
        $laporan = laporan::create($validateData);

         // Mengirim email jika rank temuan adalah A
        if($validateData['rank'] == 'A'){
            Mail::to($laporan->PIC->email)->send(new urgentMail($laporan));
        }

        // Membuat catatan aktivitas
        $data = new activity_log();
        $data->user_id = auth()->user()->id;
        $data->auditor_id = $laporan->auditor_id;
        $data->laporan_id = $laporan->id;
        $data->area_id = $laporan->area_id;
        $data->event_type = "create";
        $data->status_read_auditor = true;
        $data->deskripsi = auth()->user()->name." Telah membuat laporan temuan Genba Management";

        $data->save();

        // Menghitung notifikasi untuk Dept Head EHS
        $Dept_Head_EHS = DB::table('model_has_roles')
                                ->where('role_id', 6)
                                ->first();

        $count_notification_ehs = user_notification_count::where('user_id', $Dept_Head_EHS->model_id)->first();

        if($count_notification_ehs == null) {
            $addCount['user_id'] = $Dept_Head_EHS->model_id;
            $addCount['count'] = 1;
            user_notification_count::create($addCount);
        } else {
            $addCount['count'] = $count_notification_ehs->count + 1;
            $count_notification_ehs->update(['count' => $addCount['count']]);
        }

        // Menghitung notifikasi untuk EHS
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
        
        // Menghitung notifikasi untuk PIC area dan Dept Head PIC
        $area = area::where('id', $laporan->area_id)->first();

        foreach($area->area as $pic) {
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

        return redirect('/genba/laporan/'.$request->genba_id)->with('success', 'Data Berhasil ditambahkan');
    }

    public function detailTemuan($id) {
        $laporan = laporan::where('id', $id)->first();
        if($laporan->genba_id == null) {
            return redirect("detail/".$laporan->id)->with('error', 'Account tidak valid, Laporan Edit hanya bisa dilakukan oleh EHS');
        }
        
        return view('management.laporan.detail_temuan', 
        ['title' => 'Dashboard Schedule Genba Management',
         'active' => 'schedule',
         'halaman' => "genba",
         'laporan' => $laporan,]);
    }

    public function editTemuan($id) {
        $laporan = laporan::where('id', $id)->first();

        if($laporan->genba_id == null) {
            return redirect("detail/".$laporan->id)->with('error', 'Account tidak valid, Laporan Edit hanya bisa dilakukan oleh EHS');
        }

        return view('management.laporan.edit_temuan', 
        ['title' => 'Dashboard Schedule Genba Management',
         'active' => 'schedule',
         'halaman' => "genba",
         'laporan' => $laporan,]);
    }


    public function updateTemuan(request $request) {

        // Mengambil data laporan lama
        $dataLama = laporan::where('id', $request->id)->first();

        // Validasi data laporan
        $validateDataLaporan = $request->validate([
            'auditor_id' => 'required',
            'PIC_id' => 'required',
            'area_id' => 'required',
            'rank' => 'required|in:A,B,C',
            'kategori' => 'required|in:5R,A,B,C,D,E,F,G,O',
            'foto_temuan' => '',
            'deadline_date' => 'required',
        ]);

        // Validasi data analisis genba
        $validateDataAnalisis = $request->validate([
            'man' => '',
            'material' => '',
            'machine' => '',
            'methode' => '',
            'what' => '',
            'when' => '',
            'where' => '',
            'why' => '',
            'how' => '',
        ]);
        
        // Konversi tanggal deadline menjadi objek Carbon
        $validateDataLaporan['deadline_date'] = Carbon::createFromFormat('d/m/Y', $request->deadline_date);
        $now = Carbon::now();
        if ($validateDataLaporan['deadline_date']->lte($now)) {
            return redirect()->back()->with('error', 'Due Date harus lebih dari tanggal sekarang');
        }

        // Jika terdapat perubahan pada gambar temuan
        if ($request->has('foto_temuan')) {
            File::delete(public_path('/gambar/foto_temuan/'.$dataLama->foto_temuan));
            $gambar = $request->file('foto_temuan');
            $namaFile = time() . '_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
            $path = public_path('/gambar/foto_temuan');
            Image::make($gambar)->encode($gambar->getClientOriginalExtension(), 90)->save($path.'/'.$namaFile);
            // $gambar->move($path, $namaFile);
    
            $validateDataLaporan['foto_temuan'] = $namaFile;
        } else {
            $validateDataLaporan['foto_temuan'] = $dataLama->foto_temuan;
        }
        
         // Update data analisis genba
        $genba = analisis_genba::where('id' ,$request->analisis_id)->first();
        $genba->update($validateDataAnalisis);
        $kolomBerubahGenba = $genba->getChanges();

        // Update data laporan
        $laporan =  laporan::where('id' ,$request->id)->first();
        $laporan->update($validateDataLaporan);

        // Kirim email jika rank temuan berubah menjadi A
        $kolomBerubahLaporan = $laporan->getChanges();
        if(Arr::has($kolomBerubahLaporan, 'rank')){
            if($kolomBerubahLaporan['rank'] == 'A') {
                Mail::to($laporan->PIC->email)->send(new urgentMail($laporan));
            }
        }

        // Buat catatan aktivitas tentang perubahan temuan
        $deskripsi = auth()->user()->name . " Telah melakukan perubahan pada laporan temuan. ";
        
        if (!empty($kolomBerubahLaporan)) {
            $perubahan = [];
            foreach ($kolomBerubahLaporan as $kolom => $nilai) {
                if ($kolom !== 'deadline_date' && $kolom !== 'updated_at') {
                    if($kolom == 'foto_temuan') {
                        $perubahan[] = "$kolom telah diubah ";
                    } else {
                        $perubahan[] = "$kolom diubah menjadi $nilai ";
                    }
                }
                
            }
            $deskripsi .= implode(", ", $perubahan);
        } else {
            $deskripsi .= "";
        }

        // Tambahkan perubahan data analisis genba ke dalam deskripsi aktivitas
        if (!empty($kolomBerubahGenba)) {
            $perubahan = [];
            foreach ($kolomBerubahGenba as $kolom => $nilai) {
                if ($kolom !== 'deadline_date' && $kolom !== 'updated_at') {
                        $perubahan[] = "data $kolom diubah menjadi $nilai ";
                }
                
            }
            $deskripsi .= implode(", ", $perubahan);
        } else {
            $deskripsi .= "";
        }
        
        // Simpan aktivitas perubahan
        $data = new activity_log();
        $data->user_id = auth()->user()->id;
        $data->auditor_id = $laporan->auditor_id; 
        $data->laporan_id = $laporan->id;
        $data->area_id = $laporan->area_id;
        $data->event_type = "edit";
        if(auth()->user()->id == $laporan->auditor_id) {
            $data->status_read_auditor = true;
        }
        $data->deskripsi = $deskripsi;

        $data->save();

        // Hitung notifikasi untuk Dept Head EHS
        $Dept_Head_EHS = DB::table('model_has_roles')
                                ->where('role_id', 6)
                                ->first();

        $count_notification_ehs = user_notification_count::where('user_id', $Dept_Head_EHS->model_id)->first();

        if($count_notification_ehs == null) {
            $addCount['user_id'] = $Dept_Head_EHS->model_id;
            $addCount['count'] = 1;
            user_notification_count::create($addCount);
        } else {
            $addCount['count'] = $count_notification_ehs->count + 1;
            $count_notification_ehs->update(['count' => $addCount['count']]);
        }

        // Hitung notifikasi untuk EHS
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
        
        // Hitung notifikasi untuk PIC atau Dept Head PIC
        $area = area::where('id', $laporan->area_id)->first();

        foreach($area->area as $pic) {
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


        return redirect('/genba/laporan/temuan/'.$request->id)->with('success', 'Data Berhasil ditambahkan');

    }

    public function createPenilaian($idGenba, $detail_id) {

        return view('management.laporan.create_penilaian', 
        ['title' => 'Dashboard Schedule Genba Management',
         'active' => 'schedule',
         'halaman' => "genba",
         'genba_id' => $idGenba,
         'detail_id' => $detail_id]);
    }

    public function storePenilaian(Request $request) {

        $validateData = $request->validate([
            'pertanyaan_1' => 'required',
            'pertanyaan_2' => 'required',
            'pertanyaan_3' => 'required',
            'pertanyaan_4' => 'required',
            'pertanyaan_5' => 'required',
            'pertanyaan_6' => 'required',
            'pertanyaan_7' => 'required',
            'pertanyaan_8' => 'required',
            'pertanyaan_9' => 'required',
            'pertanyaan_10' => 'required',
        ]);

        $nilai = penilaian::create($validateData);

        genba_detail::where('id', $request->genba_detail_id)->update(['penilaian_id' => $nilai->id]);

        return redirect('/genba/laporan/'.$request->genba_id)->with('success', 'Data Berhasil ditambahkan');

    }

    public function detailPenilaian($idGenba, $detail_id) {
        $penilaian = penilaian::where('id', $detail_id)->first();
        return view('management.laporan.detail_penilaian', 
        ['title' => 'Dashboard Schedule Genba Management',
         'active' => 'schedule',
         'halaman' => "genba",
         'genba_id' => $idGenba,
         'penilaian' => $penilaian]);
    }

    public function editPenilaian($idGenba, $detail_id) {

        $penilaian = penilaian::where('id', $detail_id)->first();
        return view('management.laporan.edit_penilaian', 
        ['title' => 'Dashboard Schedule Genba Management',
         'active' => 'schedule',
         'halaman' => "genba",
         'genba_id' => $idGenba,
         'penilaian' => $penilaian]);
    }

    public function updatePenilaian(Request $request) {
        $validateData = $request->validate([
            'pertanyaan_1' => 'required',
            'pertanyaan_2' => 'required',
            'pertanyaan_3' => 'required',
            'pertanyaan_4' => 'required',
            'pertanyaan_5' => 'required',
            'pertanyaan_6' => 'required',
            'pertanyaan_7' => 'required',
            'pertanyaan_8' => 'required',
            'pertanyaan_9' => 'required',
            'pertanyaan_10' => 'required',
        ]);

        penilaian::where('id' ,$request->id)->update($validateData);

        return redirect('/genba/laporan/'.$request->genba_id.'/penilaian/detail/'.$request->id)->with('success', 'Data Berhasil diupdate');
    }
}
