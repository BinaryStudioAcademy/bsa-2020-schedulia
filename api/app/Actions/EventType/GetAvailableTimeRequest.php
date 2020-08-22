<?php

declare(strict_types=1);

namespace App\Actions\EventType;

final class GetAvailableTimeRequest
{
    private int $eventTypeId;
    private string $month;

    public function __construct(int $eventTypeId, string $month)
    {
        $this->eventTypeId = $eventTypeId;
        $this->month = $month;
    }

    public function getEventTypeId(): int
    {
        return $this->eventTypeId;
    }

    public function getMonth(): string
    {
        return $this->month;
    }
}
