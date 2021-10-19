<?php

namespace App\Notifications;

use App\EmailTemplate;
use App\Mail\TipReceivedEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TipReceivedNotification extends Notification
{
    use Queueable;

    public $tip;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tip)
    {
        $this->tip = $tip;
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
        $getEmailTemplate = EmailTemplate::findorFail(8);
        $emailSubject = $getEmailTemplate->emailSubject;
        $emailBody = $getEmailTemplate->emailBody;
        $emailBody = str_replace('<a ', '<a class="button button-primary" ', $emailBody);
        $emailBody = str_replace('{APP_NAME}', env('APP_NAME'), $emailBody);
        $emailBody = str_replace('{name}', $notifiable->name, $emailBody);
        $emailBody = str_replace('{tipper_name}', $this->tip->tipper->name, $emailBody);
        $emailBody = str_replace('{tipper_profile_link}', route('profile.show', ['username' => $this->tip->tipper->profile->username]), $emailBody);
        $emailBody = str_replace('{tipper_handle}', $this->tip->tipper->profile->handle, $emailBody);
        $emailBody = str_replace('{tip_amount}', opt('payment-settings.currency_symbol') . $this->tip->creator_amount, $emailBody);
        $emailBody = str_replace('{tip_post_link}', route('single-post', ['post' => $this->tip->post_id]), $emailBody);
        $emailBody = str_replace('{my_tips}', route('myTips'), $emailBody);

        return (new TipReceivedEmail($this->tip, $notifiable, $emailSubject,$emailBody))
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
        return [
            'amount' => $this->tip->creator_amount,
            'from_user' => $this->tip->tipper->profile->username,
            'from_handle' => $this->tip->tipper->profile->handle
        ];
    }
}
