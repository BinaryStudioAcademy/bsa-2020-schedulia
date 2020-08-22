<?php

declare(strict_types=1);

namespace App\Actions\EventType;

final class GetAvailableTimeRequest
{
    private int $eventTypeId;
    private string $month;
    private string $timezone;

    public function __construct(
        int $eventTypeId,
        string $month,
        string $timezone = 'Europe/Kiev'
    ) {
        $this->eventTypeId = $eventTypeId;
        $this->month = $month;
        $this->timezone = $timezone;
    }

    public function getEventTypeId(): int
    {
        return $this->eventTypeId;
    }

    public function getMonth(): string
    {
        return $this->month;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }
}
