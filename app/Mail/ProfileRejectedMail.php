<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProfileRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $emailSubject;
    public $emailBody;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $emailSubject, $emailBody)
    {
        $this->user = $user;
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
            return $this->subject($this->emailSubject)->markdown('emails.profileRejected');
        }
        return $this->subject(__('mail.rejectedSubject'))->markdown('emails.profileRejected');
    }
}
