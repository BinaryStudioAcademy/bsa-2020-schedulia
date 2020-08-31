<?php

declare(strict_types=1);

namespace App\Repositories\Tag\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final class EventTypesCriterion implements EloquentCriterion
{
    private array $eventTypes;

    public function __construct(array $eventTypes)
    {
        $this->eventTypes = $eventTypes;
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->whereIn(
            'event_type_id',
            $this->eventTypes
        );
    }
}
