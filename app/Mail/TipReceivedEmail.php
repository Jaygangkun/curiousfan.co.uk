<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TipReceivedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $tip;
    public $notifiable;
    public $emailSubject;
    public $emailBody;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tip, $notifiable, $emailSubject, $emailBody)
    {
        $this->tip = $tip;
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
        if($this->emailSubject){
            return $this->subject($this->emailSubject)->markdown('emails.tipReceivedMail');
        }
        return $this->subject(__('mail.tipReceivedMail'))->markdown('emails.tipReceivedMail');
    }
}
