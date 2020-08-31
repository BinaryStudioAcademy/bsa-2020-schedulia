<?php

declare(strict_types=1);

namespace App\Repositories\Event\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final class EventStatusCriterion implements EloquentCriterion
{
    private array $eventStatus;

    public function __construct(array $eventStatus)
    {
        $this->eventStatus = $eventStatus;
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->whereIn(
            'status',
            $this->eventStatus
        );
    }
}
