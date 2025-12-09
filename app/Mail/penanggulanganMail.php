<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class penanggulanganMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data,$count;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $count)
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
            return $this->subject('Need Approve')->view('mail.penanggulanganMail');
        } else if($this->count == 3){
            return $this->subject('Need Approve')->view('mail.reminderPenanggulanganMail');
        }else{
            return $this->subject('Need Approve')->view('mail.penanggulanganMailAll');
        }


        // ->attach(public_path('gambar/foto_temuan/' . $this->data['foto_temuan']), [
        //     'as' => 'Temuan.jpg',
        //     'mime' => 'image/jpeg',
        // ])->attach(public_path('gambar/foto_penanggulangan/' . $this->data['foto_penanggulangan']), [
        //     'as' => 'Penanggulangan.jpg',
        //     'mime' => 'image/jpeg',
        // ])->view('mail.penanggulanganMail');
    }
}
