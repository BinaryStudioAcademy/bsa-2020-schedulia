<?php

declare(strict_types=1);

namespace App\Repositories\Event\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final class StartDateCriterion implements EloquentCriterion
{
    private string $startDate;

    public function __construct(string $startDate)
    {
        $this->startDate = $startDate;
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->where(
            'start_date',
            '>=',
            $this->startDate
        );
    }
}
