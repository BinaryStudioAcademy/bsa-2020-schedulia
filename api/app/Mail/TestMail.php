<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function build()
    {
        return $this->view('emails.test')
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Schedulia | Test | ' . config('app.env'))
            ->with([ 'test_message' => $this->message ]);
    }
}
