<?php

namespace App\Notifications;

use App\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentActionRequiredEmail;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentActionRequired extends Notification
{
    use Queueable;

    public $invoice;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $getEmailTemplate = EmailTemplate::findorFail(3);
        $emailSubject = $getEmailTemplate->emailSubject;
        $emailBody = $getEmailTemplate->emailBody;
        $emailBody = str_replace('<a ', '<a class="button button-primary" ', $emailBody);
        $emailBody = str_replace('{APP_NAME}', env('APP_NAME'), $emailBody);
        $emailBody = str_replace('{name}', $notifiable->name, $emailBody);
        $emailBody = str_replace('{invoice_amount}', opt('payment-settings.currency_symbol') .  $this->invoice->amount, $emailBody);
        $emailBody = str_replace('{profile_link}', route('profile.show', ['username' => $this->invoice->subscription->creator->profile->username]), $emailBody);
        $emailBody = str_replace('{profile_handle}', $this->invoice->subscription->creator->profile->handle, $emailBody);
        $emailBody = str_replace('{invoice_url}', $this->invoice->invoice_url, $emailBody);
        return (new PaymentActionRequiredEmail($this->invoice, $notifiable, $emailSubject, $emailBody))
            ->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->invoice;
    }
}
