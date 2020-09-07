<?php

declare(strict_types=1);

namespace App\Repositories\Tag\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final class EventTypeIdCriterion implements EloquentCriterion
{
    private int $eventTypeId;

    public function __construct(int $eventTypeId)
    {
        $this->eventTypeId = $eventTypeId;
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->where(
            'event_type_id',
            '=',
            $this->eventTypeId
        );
    }
}
