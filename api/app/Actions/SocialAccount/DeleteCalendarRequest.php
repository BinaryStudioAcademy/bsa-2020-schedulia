<?php

declare(strict_types=1);

namespace App\Actions\SocialAccount;

final class DeleteCalendarRequest
{
    private int $userId;
    private string $provider;

    public function __construct(
        int $userId,
        string $provider
    ) {
        $this->userId = $userId;
        $this->provider = $provider;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProvider(): string
    {
        return $this->provider;
    }
}
