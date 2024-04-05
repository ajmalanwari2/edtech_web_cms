<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $info;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details,$info)
    {
        $this->details = $details;
        $this->info = $info;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Contact Us')
        ->from('elearningedtech02@gmail.com', 'Education Technology')
        ->view('mails.contactUsEmail')
        ->with('data',$this->info);
    }
}