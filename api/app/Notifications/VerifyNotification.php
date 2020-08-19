<?php

namespace App\Notifications;

use App\Mail\AccountVerificationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;


class VerifyNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = $this->verificationUrl($notifiable);

        return (new AccountVerificationMail())->build($url);
    }

    protected function verificationUrl($notifiable)
    {
        return  env('CLIENT_APP_URL') . '/verified-email?' . http_build_query(
            [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
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
