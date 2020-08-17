<?php

declare(strict_types=1);

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final class SearchByNameStringCriteria implements Criteria
{
    private ?string $searchString;

    public function __construct(?string $searchString)
    {
        $this->searchString = $searchString ? mb_strtolower($searchString) : '';
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->where(
            DB::raw('LOWER(name)'),
            'like',
            $this->searchString . '%'
        );
    }
}
