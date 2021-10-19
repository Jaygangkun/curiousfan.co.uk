<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentRequestProcessed extends Mailable
{
    use Queueable, SerializesModels;

    public $withdraw;
    public $emailSubject;
    public $emailBody;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($withdraw, $emailSubject, $emailBody)
    {
        $this->withdraw = $withdraw;
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
            return $this->subject($this->emailSubject)->markdown('emails.paymentRequestPaid');
        }
        return $this->subject(__('mail.paymentRequestPaid'))->markdown('emails.paymentRequestPaid');
    }
}
