<?php

declare(strict_types=1);

namespace App\Repositories\EventType;

use App\Entity\EventType;
use Illuminate\Support\Collection;

interface EventTypeRepositoryInterface
{
    public function getById(int $id): ?EventType;
    public function save(EventType $eventType): EventType;
    public function deleteById(int $id): void;
    public function getEventTypesByOwnerId(int $id): Collection;
    public function saveAvailabilities(EventType $eventType, array $availabilities): void;
    public function deleteAvailabilities(EventType $eventType): void;
}
