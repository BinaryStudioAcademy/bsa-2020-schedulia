<?php

declare(strict_types=1);

namespace App\Actions\Auth;


final class sendLinkForgotPasswordResponse
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
