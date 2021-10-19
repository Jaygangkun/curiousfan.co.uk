<?php

namespace App\Notifications;

use App\EmailTemplate;
use Illuminate\Bus\Queueable;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $getEmailTemplate = EmailTemplate::findorFail(12);
        $emailSubject = $getEmailTemplate->emailSubject;
        $emailBody = $getEmailTemplate->emailBody;
        $emailBody = str_replace('<a ', '<a class="button button-primary" ', $emailBody);
        $emailBody = str_replace('{reset_link}', url('password/reset', $this->token), $emailBody);

        return (new ResetPasswordMail(url('password/reset', $this->token), $emailSubject, $emailBody))
            ->to($notifiable->email);
        // return (new ResetPasswordMail)
        //     ->subject('Your Reset Password Subject Here')
        //     ->line('You are receiving this email because we received a password reset request for your account.')
        //     ->action('Reset Password', url('password/reset', $this->token))
        //     ->line('If you did not request a password reset, no further action is required.');
    }
}