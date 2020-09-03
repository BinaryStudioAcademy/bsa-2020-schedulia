<?php

declare(strict_types=1);

namespace App\Repositories\Event\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final class SearchStringCriterion implements EloquentCriterion
{
    private string $searchString;

    public function __construct(string $searchString)
    {
        $this->searchString = mb_strtolower($searchString);
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->where(
            DB::raw('LOWER(invitee_name)'),
            'like',
            '%' . $this->searchString . '%'
        );
    }
}
