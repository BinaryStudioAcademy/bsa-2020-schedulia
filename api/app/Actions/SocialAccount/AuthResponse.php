<?php

declare(strict_types=1);

namespace App\Actions\SocialAccount;

class AuthResponse
{
    private string $urt;
    private ?array $data;

    public function __construct(string $url, array $data = [])
    {
        $this->url = $url;
        $this->data = $data;
    }

    public function getAuthData(): array
    {
        return $this->data;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
