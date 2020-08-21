<?php

namespace App\Notifications;

use App\Mail\ResetPasswordLinkMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $linkReset =$this->resetUrl($notifiable, $this->token);
        $count = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');
        return (new ResetPasswordLinkMail())->build($linkReset, $count);
    }

    protected function resetUrl($notifiable, $token)
    {
        return  env('CLIENT_APP_URL') . '/reset-password?' . http_build_query(
            [
                    'token' => $token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ]
        );
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
