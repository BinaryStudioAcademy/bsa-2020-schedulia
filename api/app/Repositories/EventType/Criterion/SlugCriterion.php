<?php

declare(strict_types=1);

namespace App\Repositories\EventType\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;

final class SlugCriterion implements EloquentCriterion
{
    private string $slug;

    public function __construct(string $slug)
    {
        $this->slug = $slug;
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->where('slug', $this->slug);
    }
}
