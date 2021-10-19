<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewSubscriberMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subscriber;
    public $notifiable;
    public $emailSubject;
    public $emailBody;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subscriber, $notifiable, $emailSubject, $emailBody)
    {
        $this->subscriber = $subscriber;
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
            return $this->subject($this->emailSubject)
                ->markdown('emails.creatorPaidSubscriber');
        }
        return $this->subject(__('mail.creatorPaidSubscriber'))
            ->markdown('emails.creatorPaidSubscriber');
    }
}
