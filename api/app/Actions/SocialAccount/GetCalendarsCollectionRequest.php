<?php

namespace App\Actions\SocialAccount;


final class GetCalendarsCollectionRequest
{
    private int $userId;
    private array $providers;

    public function __construct(
        ?int $userId,
        array $providers
    ) {
        $this->userId = $userId;
        $this->providers = $providers;
    }

    public function getProviders(): array
    {
        return $this->providers;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}