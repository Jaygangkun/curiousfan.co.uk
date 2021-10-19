<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminNotify extends Notification
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // add 'mail' to send like notifications
        return ['database'];
    }


    public function toMail($notifiable)
    {
        $user = route('profile.show', ['username' => $this->user->id]);

        return (new MailMessage)
            ->subject("test")
            ->greeting("aaaaaaaa1")
            ->line(new HtmlString('bbbbbbbbbbbbb'));
    }


    
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->user;
    }
}
