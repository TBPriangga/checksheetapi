<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\genba;
use App\Models\area;
use Illuminate\Support\Facades\Mail;
use App\Mail\genbaPatrols;

class genbaPatrol extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'genba:patrol';

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
        
        $areas = area::all();
        $tanggalSekarang = Carbon::now();
    foreach($areas as $area){
        $genbas = genba::where('tanggal_patrol', '=', $tanggalSekarang->subDays(1)->format('m/d/Y'))->where('area_id', $area->id)->get();
        foreach($genbas as $genba){
            foreach($genba->detail as $member){
                $date = $genba->tanggal_patrol;
                $dateCarbon = Carbon::createFromFormat('m/d/Y', $date);
    
                // Mengonversi ke format yang diinginkan
                $tanggal_patrol = $dateCarbon->format('l, j F Y');
    
                $area = $genba->genba_area->name;
                Mail::to($member->genba_member->email)->send(new genbaPatrols($genbas,$area,$tanggal_patrol));
            }
        }
            foreach($genbas[0]->genba_area->area as $PIC_area){
                if($PIC_area->user->roles[0]->name == 'PIC'){
                    // dd($PIC_area->user->email);
                    Mail::to($PIC_area->user->email)->send(new genbaPatrols($genbas,$area,$tanggal_patrol));
                }
            }
    }
}
}