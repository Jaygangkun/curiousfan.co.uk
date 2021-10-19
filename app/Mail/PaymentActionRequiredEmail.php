<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentActionRequiredEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $notifiable;
    public $emailSubject;
    public $emailBody;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice, $notifiable, $emailSubject, $emailBody)
    {
        $this->invoice = $invoice;
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
            return $this->subject($this->emailSubject)
                ->markdown('emails.paymentActionRequired');
        }
        return $this->subject(__('mail.paymentActionRequired'))
            ->markdown('emails.paymentActionRequired');
    }
}
