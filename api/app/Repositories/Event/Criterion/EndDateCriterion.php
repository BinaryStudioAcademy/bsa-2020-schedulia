<?php

declare(strict_types=1);

namespace App\Repositories\Event\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final class EndDateCriterion implements EloquentCriterion
{
    private string $endDate;

    public function __construct(string $endDate)
    {
        $this->endDate = $endDate;
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->where(
            'start_date',
            '<',
            $this->endDate
        );
    }
}
