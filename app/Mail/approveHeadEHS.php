<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class approveHeadEHS extends Mailable
{
    use Queueable, SerializesModels;
    public $data, $count;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$count)
    {
        $this->data = $data;
        $this->count = $count;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->count == null) {
            return $this->subject('Temuan Approved')
                        ->view('mail.approvedTemuan');
            
        } else {
            return $this->subject('Temuan Approved')
                        ->view('mail.approvedTemuanAll');
        }
            
        
    }
}
