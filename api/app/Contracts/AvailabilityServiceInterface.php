<?php

namespace App\Contracts;

use App\Entity\EventType;
use Illuminate\Support\Collection;

interface AvailabilityServiceInterface
{
    public function validateAvailabilities(Collection $availabilities, int $duration): bool;
    public function checkIfTimeIsAvailable(EventType $eventType, string $dateTime): bool;
    public function getAvailableDaysByEventType(EventType $eventType, string $monthDate): array;
}
