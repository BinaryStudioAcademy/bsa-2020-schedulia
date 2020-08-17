<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface EloquentCriterion
{
    public function apply(Builder $builder): Builder;
}
