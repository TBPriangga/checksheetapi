<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class urgentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->data->genba_id == null){ 
            return $this->subject('Urgent Rank A')
            ->view('mail.urgentMail')->with(['link_web' => "http://10.14.143.89/portal-web/public"]);
            // ->view('mail.urgentMail')->with(['link_web' => "http://10.14.143.89/portal-web/public"]);
        } else {
            return $this->subject('Urgent Rank A')
            ->view('mail.urgentMailGenba');

        }
    }
}
