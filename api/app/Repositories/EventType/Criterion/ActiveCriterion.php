<?php

declare(strict_types=1);

namespace App\Repositories\EventType\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;

final class ActiveCriterion implements EloquentCriterion
{
    public function apply(Builder $builder): Builder
    {
        return $builder->where('disabled', false);
    }
}
