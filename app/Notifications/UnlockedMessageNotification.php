<?php

namespace App\Notifications;

use App\EmailTemplate;
use App\Mail\UnlockedMessageMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UnlockedMessageNotification extends Notification
{
    use Queueable;

    public $unlock;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($unlock)
    {
        $this->unlock = $unlock;
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
        $getEmailTemplate = EmailTemplate::findorFail(9);
        $emailSubject = $getEmailTemplate->emailSubject;
        $emailBody = $getEmailTemplate->emailBody;
        $emailBody = str_replace('<a ', '<a class="button button-primary" ', $emailBody);
        $emailBody = str_replace('{APP_NAME}', env('APP_NAME'), $emailBody);
        $emailBody = str_replace('{name}', $notifiable->name, $emailBody);
        $emailBody = str_replace('{unlock_tipper_name}', $this->unlock->tipper->name, $emailBody);
        $emailBody = str_replace('{unlock_tipper_profile_username}', route('profile.show', ['username' => $this->unlock->tipper->profile->username]), $emailBody);
        $emailBody = str_replace('{unlock_tipper_profile_handle}', $this->unlock->tipper->profile->handle, $emailBody);
        $emailBody = str_replace('{unlock_creator_amount}', opt('payment-settings.currency_symbol') . $this->unlock->creator_amount, $emailBody);
        $emailBody = str_replace('{notifications_link}', route('notifications.index'), $emailBody);
        return (new UnlockedMessageMail($this->unlock, $notifiable, $emailSubject, $emailBody))
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
            'amount' => $this->unlock->creator_amount,
            'from_user' => $this->unlock->tipper->profile->username,
            'from_handle' => $this->unlock->tipper->profile->handle
        ];
    }
}
