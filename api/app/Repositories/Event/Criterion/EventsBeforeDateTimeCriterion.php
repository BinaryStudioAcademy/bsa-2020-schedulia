<?php

declare(strict_types=1);

namespace App\Repositories\Event\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final class EventsBeforeDateTimeCriterion implements EloquentCriterion
{
    private string $momentOfDateTime;

    public function __construct(string $momentOfDateTime)
    {
        $this->momentOfDateTime = $momentOfDateTime;
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->where(
            'start_date',
            '<=',
            $this->momentOfDateTime
        );
    }
}
