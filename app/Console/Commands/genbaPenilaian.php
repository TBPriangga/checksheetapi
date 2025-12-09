<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Genba;
use Illuminate\Support\Facades\Mail;
use App\Mail\reminderNIlai;

class genbaPenilaian extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'genba:penilaian';

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
                // Ambil data dari tabel genba
                $tanggalSekarang = Carbon::now();

                $genba = Genba::where('tanggal_patrol', '<=', $tanggalSekarang->subDays(3)->format('m/d/Y'))->get();
                foreach($genba as $genba_detail){
                    foreach($genba_detail->detail as $detail) {
                        if($detail->penilaian_id == null) {
                            Mail::to($detail->genba_member->email)->send(new reminderNilai());
                        }
                    }
                }
    }
}
