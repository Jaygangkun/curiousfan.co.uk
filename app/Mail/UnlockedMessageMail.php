<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UnlockedMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $unlock;
    public $notifiable;
    public $emailSubject;
    public $emailBody;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($unlock, $notifiable, $emailSubject, $emailBody)
    {
        $this->unlock = $unlock;
        $this->notifiable = $notifiable;
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
        if($this->emailSubject) {
            return $this->subject($this->emailSubject)->markdown('emails.unlockedMessageMail');
        }
        return $this->subject(__('v19.unlockedMessageMail'))->markdown('emails.unlockedMessageMail');
    }
}
