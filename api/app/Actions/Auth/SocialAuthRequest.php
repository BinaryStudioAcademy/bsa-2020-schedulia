<?php


namespace App\Actions\Auth;


final class SocialAuthRequest
{
    private string $provider;

    public function __construct(string $provider)
    {
        $this->provider = $provider;
    }

    public function getProvider(): string
    {
        return $this->provider;
    }
}
