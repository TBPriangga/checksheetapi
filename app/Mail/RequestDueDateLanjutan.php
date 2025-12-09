<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestDueDateLanjutan extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public $status;

    public function __construct($data,$status)
    {
        $this->data = $data;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->status == 'request'){
            return $this->subject('EHS Patrol : Request Due Date Lanjutan')
                            ->view('mail.requestDueDateLanjutan');
        }elseif($this->status == 'acc'){
            return $this->subject('EHS Patrol : Due Date Lanjutan Disetujui')
            ->view('mail.setujuiDueDateLanjutan');
        }elseif($this->status == 'tolak'){
            return $this->subject('EHS Patrol : Due Date Lanjutan Ditolak')
            ->view('mail.tolakDueDateLanjutan');
        }
    }
}
