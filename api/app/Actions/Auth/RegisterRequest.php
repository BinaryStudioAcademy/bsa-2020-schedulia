<?php

declare(strict_types=1);

namespace App\Actions\Auth;

final class RegisterRequest
{
    private string $email;
    private string $password;
    private string $name;
    private string $timezone;

    public function __construct(
        string $email,
        string $password,
        string $name,
        string $timezone
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->timezone = $timezone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }
}
