<?php

namespace App\Http\Livewire;
use App\Models\activity_log;
use App\Models\laporan;
use App\Models\user_has_area;
use App\Models\user_notification_count;
use Illuminate\Support\Facades\DB;

use Livewire\Component;

class Notification extends Component
{
    public $log, $count;
    // public $disabledRefresh = true;
    protected $listeners = ['refreshNotification'  => 'refresh'];

    public function refresh()
    {
        // if($this->disabledRefresh){
            if($this->count != 0 && $this->count != null){
                // dd($this->count);
                DB::table('user_notification_counts')->where('user_id', auth()->user()->id)->update(['count' => 0]);
                // $this->disabledRefresh = false;
            }
        // }

    }
    public function render()
    {
        $count = user_notification_count::where('user_id', auth()->user()->id)->first();
        if ($count != null) {

            $this->count = $count->count;
        }
        $role = auth()->user()->getRoleNames()[0];
        if (auth()->user()->hasRole(['EHS'])){
            $query1 = activity_log::select('activity_logs.*')->join('laporan', 'laporan.id', '=', 'laporan_id')
            ->where('laporan.genba_id', '!=', null)->where('activity_logs.user_id', '!=', auth()->user()->id);
            $query2 = activity_log::where('auditor_id', auth()->user()->id)->where('user_id','!=', auth()->user()->id);

            $this->log = $query1->union($query2)->orderBy('created_at', 'desc')->limit(5)->get();
            
        } else if (auth()->user()->hasRole(['Departement Head EHS'])) {
            $this->log = activity_log::where('user_id','!=', auth()->user()->id)->orderBy('created_at', 'desc')->limit(5)->get();    

        } else if(auth()->user()->hasRole(['PIC'])) {
            $query1 = activity_log::select('activity_logs.*')->join('user_has_areas', 'user_has_areas.area_id', '=', 'activity_logs.area_id')
                                    ->where('user_has_areas.user_id','=',auth()->user()->id)->where('activity_logs.user_id','!=', auth()->user()->id);
            $this->log = $query1->orderBy('created_at', 'desc')->limit(5)->get();
       
        } else if (auth()->user()->hasRole(['Departement Head PIC'])){
            // $area = user_has_area::where('user_id', auth()->user()->id)->get();

            $query1 = activity_log::select('activity_logs.*')->join('user_has_areas', 'user_has_areas.area_id', '=', 'activity_logs.area_id')
                                    ->where('user_has_areas.user_id','=',auth()->user()->id)->where('activity_logs.user_id','!=', auth()->user()->id);
            $this->log = $query1->orderBy('created_at', 'desc')->limit(5)->get();
            
        } else {
            $this->log = activity_log::join('laporan', 'laporan.id', '=', 'activity_logs.laporan_id')
            ->join('genba_details','genba_details.genba_id','=', 'laporan.genba_id')
            ->select('activity_logs.*','laporan.genba_id as genba_id', 'genba_details.user_id as member_id')
            ->where('genba_details.user_id', auth()->user()->id)
            ->where('activity_logs.user_id', '!=', auth()->user()->id)
            ->orderBy('activity_logs.created_at', 'desc')->get();
        }


        return view('livewire.notification');
    }


}
