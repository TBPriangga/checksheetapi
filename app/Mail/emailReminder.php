<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class emailReminder extends Mailable
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
        if($this->data->rank == "A"){
            return $this->subject('Reminder Deadline EHS Patrol')
                    ->view('mail.reminderRankA');
        }else{
            return $this->subject('Reminder Deadline EHS Patrol')
            ->view('mail.reminder');
        }

    }
}
