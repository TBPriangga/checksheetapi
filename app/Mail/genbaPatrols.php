<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class genbaPatrols extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $area;
    public $tanggal_patrol;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$area,$tanggal_patrol)
    {
        $this->data = $data;
        $this->area = $area;
        $this->tanggal_patrol = $tanggal_patrol;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.genbaPatrol');
    }
}
