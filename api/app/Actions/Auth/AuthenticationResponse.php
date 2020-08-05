<?php

namespace App\Actions\Auth;

final class AuthenticationResponse
{
    private $accessToken;
    private $tokenType;
    private $expiresIn;

    public function __construct(
        string $accessToken,
        string $tokenType,
        string $expiresIn
    ) {
        $this->accessToken = $accessToken;
        $this->tokenType = $tokenType;
        $this->expiresIn = $expiresIn;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }
}
