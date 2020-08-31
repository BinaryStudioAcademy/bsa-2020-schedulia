<?php

declare(strict_types=1);

namespace App\Repositories\Tag\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final class EventTypesCriterion implements EloquentCriterion
{
    private int $eventTypes;

    public function __construct(int $eventTypes)
    {
        $this->eventTypes = $eventTypes;
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->where(
            'event_type_id',
            $this->eventTypes
        );
    }
}
