<?php

namespace App\Repositories\Event;

use App\Contracts\EloquentCriterion;
use App\Entity\Event;
use Illuminate\Support\Collection;

interface EventRepositoryInterface
{
    public function save(Event $event): Event;
    public function saveCustomFieldValues(Event $event, array $customFieldValues): void;
    public function findByCriteria(EloquentCriterion ...$criteria): Collection;
}
