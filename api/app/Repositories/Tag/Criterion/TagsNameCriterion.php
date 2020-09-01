<?php

declare(strict_types=1);

namespace App\Repositories\Tag\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final class TagsNameCriterion implements EloquentCriterion
{
    private string $searchString;

    public function __construct(string $searchString)
    {
        $this->searchString = mb_strtolower($searchString);
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->where(
            DB::raw('LOWER(tags.name)'),
            'like',
            '%' . $this->searchString . '%'
        );
    }
}
