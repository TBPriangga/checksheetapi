<?php


namespace App\Http\Livewire;


use Livewire\Component;
use App\Models\laporan;
use App\Models\area;
use App\Models\user_has_area;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class Dashboard extends Component
{
    public $rankAOpen, $rankBOpen, $rankCOpen,$rankAClosed, $rankBClosed, $rankCClosed;
    public $categoryA, $categoryB, $categoryc,$categoryD, $categoryE, $categoryF, $categoryG, $categoryO, $category5R;
    public $categoryAOpen, $categoryBOpen, $categorycOpen,$categoryDOpen, $categoryEOpen, $categoryFOpen, $categoryGOpen, $categoryOOpen, $category5ROpen;
    public $categoryAClosed, $categoryBClosed, $categorycClosed,$categoryDClosed, $categoryEClosed, $categoryFClosed, $categoryGClosed, $categoryOClosed, $category5RClosed;
    public $temuanEHS, $temuanGenba;
    public $rankOpen, $rankClosed;
    public $timeStart, $timeEnd;
    public $timeStartpick, $timeEndPick;
    public $areasFound;


    public $selectedOption = 3;
    public $query;
    protected $listeners = ['radio_change'  => 'receiveRadio',
                            'time_start_change' => 'setTimeStart',
                            'time_end_change' => 'setTimeEnd',
                        ];


    public function userData($query){
    if(auth()->user()->hasRole('Departement Head EHS') && auth()->user()->hasRole('Departement Head PIC')){
        return $query->whereNotNull('area_id');
    }else if(auth()->user()->hasRole('Departement Head PIC')){
        $areaDeptheads = user_has_area::where('user_id', auth()->user()->id)->get();


        // Inisialisasi query orWhere
        foreach($areaDeptheads as $areaDepthead){
            $query = $query->orWhere('area_id', $areaDepthead->area_id);
        }
        return $query;
    }else if(auth()->user()->hasRole('PIC')){
        return $query->where('PIC_id', auth()->user()->id);
    }else{
        return $query->whereNotNull('area_id');
    }
}
                   


    public function mount()
    {
        $this->timeStart = date('Y-m-01'); // Mendapatkan tanggal 1 pada bulan ini
        $this->timeEnd = date('Y-m-d'); // Mendapatkan tanggal hari ini
        $this->areasFound = area::select("areas.name", "areas.id")->join('laporan','laporan.area_id','areas.id')->where(function($query){
            $this->userData($query);
        })->whereBetween('laporan.created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->where('laporan.deleted_at', null)->distinct()->get()->toArray();
        $this->rankOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankAOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('rank', 'A')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankBOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('rank', 'B')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankCOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('rank', 'C')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankAClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('rank', 'A')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankBClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('rank', 'B')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankCClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where('progress','>=', 13)->where('deleted_at', null)->where('rank', 'C')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
       
        $this->categoryAOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'A')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryBOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'B')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryCOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'C')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryDOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'D')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryEOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'E')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryFOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'F')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryGOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'G')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryOOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'O')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->category5ROpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', '5R')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();


        $this->categoryAClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'A')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryBClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'B')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryCClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'C')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryDClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'D')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryEClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'E')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryFClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'F')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryGClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'G')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryOClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'O')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->category5RClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', '5R')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();


        $this->temuanEHS = laporan::where("genba_id", null)->where(function($query){
            $this->userData($query);
        })->where('deleted_at', null)->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->select('id', 'area_id', 'progress')->get();
       
        $this->temuanGenba = laporan::whereNotNull("genba_id")->where('deleted_at', null)->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->select('id', 'area_id', 'progress')->get();
       
    }


    public function receiveRadio($data)
    {
        if ($data == 1) {
            $this->timeStart = date('Y-m-d');
            $this->timeEnd = date('Y-m-d');
            $this->timeStartPick = date("d-m-Y", strtotime($this->timeStart));
            $this->timeEndPick = date("d-m-Y", strtotime($this->timeEnd));
            $this->dispatchBrowserEvent('updateDate');
        } else if ($data == 2) {
            $this->timeStart = date('Y-m-d', strtotime('monday this week')); // Mendapatkan tanggal 1 pada bulan ini
            $this->timeEnd = date('Y-m-d', strtotime('sunday this week')); // Mendapatkan tanggal hari ini
            $this->timeStartPick = date("d-m-Y", strtotime($this->timeStart));
            $this->timeEndPick = date("d-m-Y", strtotime($this->timeEnd));
            $this->selectedOption = 2;
            $this->dispatchBrowserEvent('updateDate');
        } else if ($data == 3) {
            $this->timeStart = date('Y-m-01'); // Mendapatkan tanggal 1 pada bulan ini
            $this->timeEnd = date('Y-m-d'); // Mendapatkan tanggal hari ini
            $this->timeStartPick = date("d-m-Y", strtotime($this->timeStart));
            $this->timeEndPick = date("d-m-Y", strtotime($this->timeEnd));
            $this->selectedOption = 3;
            $this->dispatchBrowserEvent('updateDate');
        }


        $this->rankOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankAOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('rank', 'A')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankBOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('rank', 'B')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankCOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('rank', 'C')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankAClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('rank', 'A')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankBClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('rank', 'B')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankCClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('rank', 'C')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();


        $this->categoryAOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'A')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryBOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'B')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryCOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'C')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryDOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'D')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryEOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'E')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryFOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'F')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryGOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'G')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryOOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'O')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->category5ROpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', '5R')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();


        $this->categoryAClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'A')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryBClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress', '>=', 13)->where('deleted_at', null)->where('kategori', 'B')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryCClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress', '>=', 13)->where('deleted_at', null)->where('kategori', 'C')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryDClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress', '>=', 13)->where('deleted_at', null)->where('kategori', 'D')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryEClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress', '>=', 13)->where('deleted_at', null)->where('kategori', 'E')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryFClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress', '>=', 13)->where('deleted_at', null)->where('kategori', 'F')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryGClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress', '>=', 13)->where('deleted_at', null)->where('kategori', 'G')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryOClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress', '>=', 13)->where('deleted_at', null)->where('kategori', 'O')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->category5RClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress', '>=', 13)->where('deleted_at', null)->where('kategori', '5R')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();


        $this->temuanEHS = laporan::where("genba_id", null)->where(function($query){
            $this->userData($query);
        })->where('deleted_at', null)->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->select('id', 'area_id', 'progress')->get();
        $this->temuanGenba = laporan::whereNotNull("genba_id")->where('deleted_at', null)->where(function($query){
            $this->userData($query);
        })->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->select('id', 'area_id', 'progress')->get();
        $this->areasFound = area::select("areas.name", "areas.id")->join('laporan','laporan.area_id','areas.id')->whereBetween('laporan.created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->where(function($query){
            $this->userData($query);
        })->where('laporan.deleted_at', null)->distinct()->get()->toArray();
    }


    public function setTimeStart($data)
    {
        $this->timeStart = Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d');


        $this->rankOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankAOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('rank', 'A')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankBOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('rank', 'B')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankCOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('rank', 'C')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankAClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('rank', 'A')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankBClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('rank', 'B')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankCClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('rank', 'C')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();


        $this->categoryAOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'A')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryBOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'B')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryCOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'C')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryDOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'D')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryEOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'E')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryFOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'F')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryGOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'G')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryOOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'O')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->category5ROpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', '5R')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();


        $this->categoryAClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress', '>=',13)->where('deleted_at', null)->where('kategori', 'A')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryBClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress', '>=',13)->where('deleted_at', null)->where('kategori', 'B')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryCClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'C')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryDClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'D')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryEClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'E')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryFClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'F')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryGClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'G')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryOClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'O')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->category5RClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', '5R')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();


        $this->temuanEHS = laporan::where("genba_id", null)->where(function($query){
            $this->userData($query);
        })->where('deleted_at', null)->where(function($query){
            $this->userData($query);
        })->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->select('id', 'area_id', 'progress')->get();
        $this->temuanGenba = laporan::whereNotNull("genba_id")->where('deleted_at', null)->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->select('id', 'area_id', 'progress')->get();
        $this->selectedOption = 4;
        $this->areasFound = area::select("areas.name", "areas.id")->join('laporan','laporan.area_id','areas.id')->whereBetween('laporan.created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->where(function($query){
            $this->userData($query);
        })->where('laporan.deleted_at', null)->distinct()->get()->toArray();
    }


    public function setTimeEnd($data)
    {
        $this->timeEnd = Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d');
        // $this->timeEnd = date("Y-m-d", strtotime($data)); // Mendapatkan tanggal 1 pada bulan ini


        $this->rankOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankAOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('rank', 'A')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankBOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('rank', 'B')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankCOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('rank', 'C')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankAClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('rank', 'A')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankBClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('rank', 'B')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->rankCClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('rank', 'C')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();


        $this->categoryAOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'A')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryBOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'B')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryCOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'C')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryDOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'D')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryEOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'E')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryFOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'F')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryGOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'G')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryOOpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', 'O')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->category5ROpen = laporan::whereNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','<=', 12)->where('deleted_at', null)->where('kategori', '5R')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
 
        $this->categoryAClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'A')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryBClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'B')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryCClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'C')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryDClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'D')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryEClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'E')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryFClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'F')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryGClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'G')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->categoryOClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', 'O')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();
        $this->category5RClosed = laporan::whereNotNull('ACC_Dept_Head_EHS_At')->where(function($query){
            $this->userData($query);
        })->where('progress','>=', 13)->where('deleted_at', null)->where('kategori', '5R')->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->count();


        $this->temuanEHS = laporan::where("genba_id", null)->where(function($query){
            $this->userData($query);
        })->where('deleted_at', null)->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->select('id', 'area_id', 'progress')->get();
        $this->temuanGenba = laporan::whereNotNull("genba_id")->where('deleted_at', null)->whereBetween('created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->select('id', 'area_id', 'progress')->get();
        $this->selectedOption = 4;
        $this->areasFound = area::select("areas.name", "areas.id")->where(function($query){
            $this->userData($query);
        })->join('laporan','laporan.area_id','areas.id')->whereBetween('laporan.created_at', [$this->timeStart." 00:00:00", $this->timeEnd." 23:59:59"])->where('laporan.deleted_at', null)->distinct()->get()->toArray();


        // $this->timeEndPick = date("m-d-Y", strtotime($this->timeEnd));
    }




    public function render()
    {
        return view('livewire.dashboard');
    }
}
