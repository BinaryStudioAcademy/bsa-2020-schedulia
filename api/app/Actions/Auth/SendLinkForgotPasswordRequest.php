<?php

namespace App\Actions\Auth;

final class SendLinkForgotPasswordRequest
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
