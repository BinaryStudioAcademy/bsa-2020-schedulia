<?php

declare(strict_types=1);

namespace App\Services\Calendar\Google;

use App\Services\Calendar\DeleteEventInterface;

final class GoogleCalendarDeleteEvent implements DeleteEventInterface
{
    private int $userId;
    private string $providerId;

    public function __construct(
        int $userId,
        string $providerId
    ) {
        $this->userId = $userId;
        $this->providerId = $providerId;
    }

    public function getProviderId(): string
    {
        return $this->providerId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
