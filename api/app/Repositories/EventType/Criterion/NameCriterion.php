<?php

declare(strict_types=1);

namespace App\Repositories\EventType\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;

final class NameCriterion implements EloquentCriterion
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->where('name', $this->name);
    }
}
