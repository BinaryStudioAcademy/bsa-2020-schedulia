<?php

declare(strict_types=1);

namespace App\Actions\Status\Mail;

use Illuminate\Support\Collection;

class MailRequest
{
    private string $email;
    private string $message;

    public function __construct(string $email, string $message)
    {
        $this->email = $email;
        $this->message = $message;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
