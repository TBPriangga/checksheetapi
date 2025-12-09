<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class reminderDeadline extends Mailable
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
            return $this->subject('Reminder Deadline EHS Patrol')
            ->view('mail.reminderDeadline');
        } else {
            return $this->subject('Reminder Deadline EHS Patrol')
            ->attach(public_path('gambar/foto_temuan/' . $this->data['foto_temuan']), [
                'as' => 'Temuan.jpg',
                'mime' => 'image/jpeg',
            ])->view('mail.reminderDeadlineGenba');
        }
    }
}
