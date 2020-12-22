<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminResetPasswordNotification extends Notification
{
    use Queueable;

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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Reset Password Notication')
                    ->greeting('You can now reset your password my friend,')
                    ->line('You are receiving this email because we received a password reset request for your account.')
                    ->action('Reset Password',
                        url(route('admin.password.reset',
                        [
                            'token' => $this->token,
                            'email' => $notifiable->getEmailForPasswordReset()
                        ])))
                    ->line(
                        Lang::get('This password reset link will expire in :count minutes.',
                        ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]
                    ))
                    ->line(
                        Lang::get('If you did not request a password reset, no further action is required.'
                    ));
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
            //
        ];
    }
}
