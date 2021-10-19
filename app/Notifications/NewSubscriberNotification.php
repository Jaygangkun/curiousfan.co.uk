<?php

namespace App\Notifications;

use App\EmailTemplate;
use App\Mail\NewSubscriberMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSubscriberNotification extends Notification
{
    use Queueable;

    public $subscriber;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subscriber)
    {
        $this->subscriber = $subscriber;
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
        $getEmailTemplate = EmailTemplate::findorFail(2);
        $emailSubject = $getEmailTemplate->emailSubject;
        $emailBody = $getEmailTemplate->emailBody;
        $emailBody = str_replace('<a ', '<a class="button button-primary" ', $emailBody);
        $emailBody = str_replace('{APP_NAME}', env('APP_NAME'), $emailBody);
        $emailBody = str_replace('{name}', $notifiable->name, $emailBody);
        $emailBody = str_replace('{subscriber_name}', $this->subscriber->name, $emailBody);
        $emailBody = str_replace('{subscriber_handle}', $this->subscriber->profile->username, $emailBody);
        $emailBody = str_replace('{subscriber_profile_url}', route('profile.show', ['username' => $this->subscriber->profile->username]), $emailBody);
        $emailBody = str_replace('{my_subscribers}', route('mySubscribers'), $emailBody);

        return (new NewSubscriberMail($this->subscriber, $notifiable, $emailSubject, $emailBody))
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
        return ['username' => $this->subscriber->profile->username];
    }
}
