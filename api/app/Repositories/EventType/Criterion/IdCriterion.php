<?php

declare(strict_types=1);

namespace App\Repositories\EventType\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;

class IdCriterion implements EloquentCriterion
{
    private int $eventTypeId;

    public function __construct(int $eventTypeId)
    {
        $this->eventTypeId = $eventTypeId;
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->where('id', $this->eventTypeId);
    }
}
