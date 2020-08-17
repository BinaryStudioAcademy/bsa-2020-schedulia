<?php

declare(strict_types=1);

namespace App\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;

interface Criteria
{
    public function apply(Builder $builder): Builder;
}
