<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationRequestedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $emailSubject;
    public $emailBody;

    public function __construct($user, $emailSubject, $emailBody)
    {
        $this->user = $user;
        $this->emailSubject = $emailSubject;
        $this->emailBody = $emailBody;
    }

    public function build()
    {
        if($this->emailSubject) {
            return $this->subject($this->emailSubject)->markdown('emails.verificationRequested');
        }
        return $this->subject(__('mail.verificationRequested'))->markdown('emails.verificationRequested');
    }
}
