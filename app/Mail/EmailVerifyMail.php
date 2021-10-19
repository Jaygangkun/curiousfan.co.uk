<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerifyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $verifyUrl;
    public $emailSubject;
    public $emailBody;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($verifyUrl, $emailSubject, $emailBody)
    {
        $this->verifyUrl = $verifyUrl;
        $this->emailSubject = $emailSubject;
        $this->emailBody = $emailBody;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->emailSubject){
            return $this->subject($this->emailSubject)
                ->markdown('emails.emailVerifyMail');
        }
        return $this->subject('Please verify your email')
            ->markdown('emails.emailVerifyMail');
    }
}
