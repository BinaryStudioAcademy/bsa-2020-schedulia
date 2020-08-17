<?php

declare(strict_types=1);

namespace App\Repositories\EventType\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final class NameCriterion implements EloquentCriterion
{
    private string $searchString;

    public function __construct(string $searchString)
    {
        $this->searchString = mb_strtolower($searchString);
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->where(
            DB::raw('LOWER(name)'),
            'like',
            '%' . $this->searchString . '%'
        );
    }
}
