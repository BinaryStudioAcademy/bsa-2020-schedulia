<?php

declare(strict_types=1);

namespace App\Services\Calendar\Google;

use App\Services\Calendar\DeleteEventInterface;

final class GoogleCalendarDeleteEvent implements DeleteEventInterface
{
    private int $eventId;
    private int $userId;
    private string $providerEventId;

    public function __construct(
        int $eventId,
        int $userId,
        string $providerEventId
    ) {
        $this->eventId = $eventId;
        $this->userId = $userId;
        $this->providerEventId = $providerEventId;
    }

    public function getEventId(): int
    {
        return $this->eventId;
    }

    public function getProviderEventId(): string
    {
        return $this->providerEventId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
