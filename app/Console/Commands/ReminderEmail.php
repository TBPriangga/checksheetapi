<?php




namespace App\Console\Commands;




use App\Mail\approvePIC;
use App\Mail\penanggulanganMail;
use App\Mail\verifyEHSMail;
use Illuminate\Support\Facades\Mail;
use App\Models\laporan;
use App\Models\User;
use App\Models\user_has_area;
use Illuminate\Console\Command;
use App\Mail\emailReminder;
use App\Mail\reminderDeadline;
use App\Mail\urgentMail;
use App\Models\ehs_patrol;




class ReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:email';




    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';




    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }




    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       // mengirim email reminder ketika deadline h-1 sampai hari h dan h+ kelipatan seminggu (Rank A dan B)
       $ehsPatrols = ehs_patrol::all();
        foreach ($ehsPatrols as $ehsPatrol)
        {
            $laporans = laporan::where('rank', '!=', 'C')
        ->where(function($query) use ($ehsPatrol){
            // Kondisi untuk deadline yang jatuh pada hari Senin
            $query->where('patrol_id',$ehsPatrol->id)->whereRaw("DAYNAME(deadline_date) = 'Monday'")
                ->whereRaw('DATE(deadline_date) = ?', [now()->addDays(3)->toDateString()])
                ->where('progress', '<', 13)->whereNull('deleted_at');
        })
        ->orWhere(function($query) use ($ehsPatrol) {
            // Kondisi untuk deadline yang jatuh bukan pada hari Senin
            $query->where('patrol_id',$ehsPatrol->id)->where('rank', '!=', 'C')->whereRaw("DAYNAME(deadline_date) = 'Monday'")
                ->whereRaw('DATE(deadline_date) = ?', [now()->toDateString()])
                ->where('progress', '<', 13)->whereNull('deleted_at');
        })->orWhere(function($query) use ($ehsPatrol) {
            // Kondisi untuk deadline yang jatuh bukan pada hari Senin
            $query->where('patrol_id',$ehsPatrol->id)->where('rank', '!=', 'C')->whereRaw("DAYNAME(deadline_date) != 'Monday'")
                ->whereRaw('DATE(deadline_date) BETWEEN ? AND ?', [now()->toDateString(), now()->addDays(1)->toDateString()])
                ->where('progress', '<', 13)->whereNull('deleted_at');
        })
        ->first();




            if($laporans != null)
            {




                $PICs = user_has_area::where('area_id', $ehsPatrol->area_id)->get();
                foreach($PICs as $PIC) {
                       
                        // Mail::to("mahsunmuh0@gmail.com")->send(new reminderDeadline($ehsPatrol));


                        Mail::to($PIC->User->email)->send(new emailReminder($laporans));
                   
                    // dispatch(new \App\Jobs\SendemailReminder($laporan));
                }
            }
        }
       // mengirim email reminder ketika deadline h+ kelipatan seminggu (Rank A dan B dan C)
       $laporans = laporan::Where(function($query) {
            // Kondisi tambahan untuk pengecekan setiap 7 hari
            $query->whereRaw('DATEDIFF(deadline_date, CURDATE()) % 7 = 0')
            ->whereRaw('CURDATE() >= DATE(deadline_date)')
            ->where('progress', '<', 13)
            ->whereRaw('DATE(deadline_date) != CURDATE()');
                })
        ->whereNull('deleted_at')
        ->get();


           foreach ($laporans as $laporan) {
            $PICs = user_has_area::where('area_id', $laporan->area_id)->get();


            foreach($PICs as $PIC) {
               
                    // Mail::to("mahsunmuh0@gmail.com")->send(new emailReminder($laporan));
                    Mail::to($PIC->User->email)->send(new emailReminder($laporan));
               
                // dispatch(new \App\Jobs\SendemailReminder($laporan));
            }
           }








       // mengirim email reminder ketika deadline h-2 sampai hari h
       foreach ($ehsPatrols as $ehsPatrol)
        {
       $laporans = laporan::where(function($query) use ($ehsPatrol) {
           $query->where('patrol_id',$ehsPatrol->id)->whereRaw("DAYNAME(deadline_date) = 'Monday'")
                 ->where('rank', 'C')
                 ->whereRaw('DATE(deadline_date) BETWEEN ? AND ?', [
                     now()->addDays(3)->toDateString(),
                     now()->addDays(4)->toDateString()
                 ])->where('progress', '<', 13)->whereNull('deleted_at');
       })->orWhere(function($query) use ($ehsPatrol) {
           $query->where('patrol_id',$ehsPatrol->id)->whereRaw("DAYNAME(deadline_date) = 'Monday'")
                 ->where('rank', 'C')
                 ->whereRaw('DATE(deadline_date) = ?', [now()->toDateString()])
                 ->where('progress', '<', 13)->whereNull('deleted_at');
       })->orWhere(function($query) use ($ehsPatrol) {
           $query->where('patrol_id',$ehsPatrol->id)->whereRaw("DAYNAME(deadline_date) = 'Tuesday'")
                 ->where('rank', 'C')
                 ->whereRaw('DATE(deadline_date) = ?', [now()->addDays(4)->toDateString()])
                 ->where('progress', '<', 13)->whereNull('deleted_at');
       })->orWhere(function($query) use ($ehsPatrol) {
           $query->where('patrol_id',$ehsPatrol->id)->whereRaw("DAYNAME(deadline_date) = 'Tuesday'")
                ->where('rank', 'C')
                ->whereRaw('DATE(deadline_date) BETWEEN ? AND ?', [now()->toDateString(), now()->addDays(1)->toDateString()])
                ->where('progress', '<', 13)->whereNull('deleted_at');
       })->orWhere(function($query) use ($ehsPatrol) {
           $query->where('patrol_id',$ehsPatrol->id)->whereRaw("DAYNAME(deadline_date) != 'Monday' AND DAYNAME(deadline_date) != 'Tuesday'")
                 ->where('rank', 'C')
                 ->whereRaw('DATE(deadline_date) BETWEEN ? AND ?', [now()->toDateString(), now()->addDays(2)->toDateString()])
                ->where('progress', '<', 13)->whereNull('deleted_at');
       })->first();
       if($laporans != null)
       {






           $PICs = user_has_area::where('area_id', $ehsPatrol->area_id)->get();


           foreach($PICs as $PIC) {
                //    Mail::to("mahsunmuh0@gmail.com")->send(new reminderDeadline($laporans));
                   Mail::to($PIC->User->email)->send(new reminderDeadline($laporans));
               
               // dispatch(new \App\Jobs\SendemailReminder($laporan));
           }
       }








    }




           
        // Mengirim Email kepada Pihak yang mempunyai tanggungan Approval
        // Dept PIC
        // $NeedApprovalsDeptPICAlls = laporan::whereNotNull('PIC_submit_at')->whereNull('ACC_Dept_Head_PIC_At')->get();
        //     foreach ($NeedApprovalsDeptPICAlls as $NeedApprovalsDeptPICAll) {
        //         $laporan = laporan::where('id', $NeedApprovalsDeptPICAll->id)->first();




        //         // $count = null;
        //             foreach($laporan->area->area as $Dept_Head_PIC){
        //                 if($Dept_Head_PIC->user->hasRole(['Departement Head PIC'])){
        //                     // Mail::to('mahsunmuh0@gmail.com')->send(new penanggulanganMail($laporan,$count));
        //                     Mail::to($Dept_Head_PIC->user->email)->send(new penanggulanganMail($laporan,null));
        //                 }
        //             }
        //         // Mail::to('mahsunmuh0@gmail.com')->send(new penanggulanganMail($NeedApprovalsDeptPICAll,$count));
        //     }

        foreach ($ehsPatrols as $ehsPatrol) {
            $NeedApprovalsDeptPICAlls = laporan::where('patrol_id', $ehsPatrol->id)
                ->whereNotNull('PIC_submit_at')
                ->whereNull('ACC_Dept_Head_PIC_At')
                ->get();
            $NeedApprovalsDeptPICAll = laporan::where('patrol_id', $ehsPatrol->id)
                ->whereNotNull('PIC_submit_at')
                ->whereNull('ACC_Dept_Head_PIC_At')
                ->first();
            if ($NeedApprovalsDeptPICAlls->count() > 0) {
                $laporan = laporan::where('id', $NeedApprovalsDeptPICAll->id)->first();
                // $count = null;
                foreach ($laporan->area->area as $Dept_Head_PIC) {
                    if ($Dept_Head_PIC->user->hasRole(['Departement Head PIC'])) {
                        // Mail::to('mahsunmuh0@gmail.com')->send(new penanggulanganMail($NeedApprovalsDeptPICAlls, null));
                        Mail::to($Dept_Head_PIC->user->email)->send(new penanggulanganMail($NeedApprovalsDeptPICAlls,3));
                    }
                }
            }
        }




        // EHS
        // $NeedVerifyEHSAlls = laporan::whereNotNull('PIC_submit_at')->whereNotNull('ACC_Dept_Head_PIC_At')->whereNull('verify_submit_at')->get();
        //     foreach ($NeedVerifyEHSAlls as $NeedVerifyEHSAll) {
        //         $laporan = laporan::where('id', $NeedVerifyEHSAll->id)->first();
        //         $users = User::all();
        //         // $count = null;
        //         if($laporan->genba_id != null){
        //             foreach($users as $user){
        //                 if($user->roles[0]->name == "EHS"){
        //                     // Mail::to('mahsunmuh0@gmail.com')->send(new approvePIC($laporan));
        //                     Mail::to($user->email)->send(new approvePIC($laporan,null));
        //                 }
        //             }
        //         }else{
        //             // Mail::to('mahsunmuh0@gmail.com')->send(new approvePIC($laporan,$count));
        //             Mail::to($laporan->auditor->email)->send(new approvePIC($laporan,null));
        //         }
        //     }
        foreach ($ehsPatrols as $ehsPatrol) {
            $NeedVerifyEHSAlls = laporan::where('patrol_id', $ehsPatrol->id)
                ->whereNotNull('PIC_submit_at')
                ->whereNotNull('ACC_Dept_Head_PIC_At')
                ->whereNull('verify_submit_at')
                ->get();
            $NeedVerifyEHSAll = laporan::where('patrol_id', $ehsPatrol->id)
                ->whereNotNull('PIC_submit_at')
                ->whereNotNull('ACC_Dept_Head_PIC_At')
                ->whereNull('verify_submit_at')
                ->first();
            if ($NeedVerifyEHSAlls->count() > 0) {
                $laporan = laporan::where('id', $NeedVerifyEHSAll->id)->first();
                $users = User::all();
                // $count = null;
                if ($laporan->genba_id != null) {
                    foreach ($users as $user) {
                        if ($user->hasRole('EHS')) {
                            Mail::to('mahsunmuh0@gmail.com')->send(new approvePIC($NeedVerifyEHSAlls, 3));
                            // Mail::to($user->email)->send(new approvePIC($NeedVerifyEHSAlls,1));
                        }
                    }
                } else {
                    // Mail::to('mahsunmuh0@gmail.com')->send(new approvePIC($NeedVerifyEHSAlls, 1));
                    Mail::to($laporan->auditor->email)->send(new approvePIC($NeedVerifyEHSAlls,3));
                }
            }
        }
           
        // Dept EHS
        // $NeedApproveDeptEHSAlls = laporan::whereNotNull('PIC_submit_at')->whereNotNull('ACC_Dept_Head_PIC_At')->whereNotNull('verify_submit_at')->whereNull('ACC_Dept_Head_EHS_At')->get();
        //     foreach ($NeedApproveDeptEHSAlls as $NeedApproveDeptEHSAll) {
        //         $users = User::all();
        //         $laporan = laporan::where('id', $NeedApproveDeptEHSAll->id)->first();
        //         // $count = null;
        //         foreach($users as $user){
        //             if($user->hasRole(['Departement Head EHS'])){
                   
        //                 // Mail::to("mahsunmuh0@gmail.com")->send(new verifyEHSMail($laporan,$count));
        //                 Mail::to($user->email)->send(new verifyEHSMail($laporan,null));
        //             }
        //         }
        //     }
        foreach ($ehsPatrols as $ehsPatrol) {
            $NeedApproveDeptEHSAlls = laporan::where('patrol_id', $ehsPatrol->id)
                ->whereNotNull('PIC_submit_at')
                ->whereNotNull('ACC_Dept_Head_PIC_At')
                ->whereNotNull('verify_submit_at')
                ->whereNull('ACC_Dept_Head_EHS_At')
                ->get();
            $NeedApproveDeptEHSAll = laporan::where('patrol_id', $ehsPatrol->id)
                ->whereNotNull('PIC_submit_at')
                ->whereNotNull('ACC_Dept_Head_PIC_At')
                ->whereNotNull('verify_submit_at')
                ->whereNull('ACC_Dept_Head_EHS_At')
                ->first();
            if ($NeedApproveDeptEHSAlls->count() > 0) {
                $users = User::all();
                $laporan = laporan::where('id', $NeedApproveDeptEHSAll->id)->first();
                // $count = null;
                foreach ($users as $user) {
                    if ($user->hasRole(['Departement Head EHS'])) {
                        // Mail::to('mahsunmuh0@gmail.com')->send(new verifyEHSMail($NeedApproveDeptEHSAlls, 1));
                        Mail::to($user->email)->send(new verifyEHSMail($NeedApproveDeptEHSAlls,3));
                    }
                }
            }
        }    
        // return 0;
    }
}
