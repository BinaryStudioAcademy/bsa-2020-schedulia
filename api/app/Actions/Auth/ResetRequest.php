<?php
declare(strict_types=1);

namespace App\Actions\Auth;

final class ResetRequest
{
    private string $email;
    private string $password;
    private string $token;

    public function __construct(
        string $email,
        string $password,
        string $token
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->token = $token;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
