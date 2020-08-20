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
            ->view('emails.sendLinkResetPassword', ['linkReset' =>$linkReset, 'count'=>$count]);
    }
}
