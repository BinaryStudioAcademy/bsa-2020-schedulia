<?php

declare(strict_types=1);

namespace App\Repositories\EventType;

use App\Contracts\EloquentCriterion;
use App\Entity\EventType;
use Illuminate\Support\Collection;

interface EventTypeRepositoryInterface
{
    public function getById(int $id): ?EventType;
    public function save(EventType $eventType): EventType;
    public function deleteById(int $id): void;
    public function saveAvailabilities(EventType $eventType, array $availabilities): void;
    public function deleteAvailabilities(EventType $eventType): void;
    public function saveCustomFields(EventType $eventType, array $customFields): void;
    public function deleteCustomFields(EventType $eventType): void;
    public function findByCriteria(EloquentCriterion ...$criteria): Collection;
}
