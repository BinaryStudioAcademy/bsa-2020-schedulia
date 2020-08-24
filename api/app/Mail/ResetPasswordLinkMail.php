<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Lang;

class ResetPasswordLinkMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct()
    {
        //
    }

    public function build($linkReset, $count)
    {
        return (new MailMessage())
            ->subject(Lang::get('Reset Password from Schedulia'))
            ->line(Lang::get('We’ve received a request to reset your password. If you didn’t make the
        request, just ignore this email.'))
            ->line(Lang::get('Otherwise, you can reset your password using this link:'))
            ->action(Lang::get('Begin process of changing password'), $linkReset)
            ->line(Lang::get('Thanks, The Schedulia Team'));
    }
}
