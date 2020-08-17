<?php

declare(strict_types=1);

namespace App\Repositories\EventType;

use App\Entity\EventType;
use App\Repositories\Criteria\Criteria;
use Illuminate\Support\Collection;

interface EventTypeRepositoryInterface
{
    public function getById(int $id): ?EventType;
    public function save(EventType $eventType): EventType;
    public function deleteById(int $id): void;
    public function saveAvailabilities(EventType $eventType, array $availabilities): void;
    public function deleteAvailabilities(EventType $eventType): void;
    public function findByCriteria(Criteria ...$criterias): Collection;
}
