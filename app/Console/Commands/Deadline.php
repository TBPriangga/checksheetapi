<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\laporan;
use Illuminate\Support\Facades\Mail;
use App\Mail\reminderDeadline;

class Deadline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:deadline';

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
        $tanggalSekarang = Carbon::now();

        $laporans = laporan::where('progress', '<=', 7.5)->whereDate('deadline_date', '>=', $tanggalSekarang)
        ->whereDate('deadline_date', '<=', $tanggalSekarang->addDays(2))->get();

        foreach($laporans as $laporan){
            Mail::to($laporan->PIC->email)->send(new reminderDeadline($laporan));
        }
    }
}
