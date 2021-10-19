<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentRequestCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $withdraw;
    public $emilSubject;
    public $emailBody;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($withdraw, $emilSubject, $emailBody)
    {
        $this->withdraw = $withdraw;
        $this->emilSubject = $emilSubject;
        $this->emailBody = $emailBody;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->emilSubject) {
            return $this->subject($this->emilSubject)->markdown('emails.paymentRequestCreated');
        }
        return $this->subject(__('mail.paymentRequestCreated'))->markdown('emails.paymentRequestCreated');
    }
}
