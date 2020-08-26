<?php

declare(strict_types=1);

namespace App\Repositories\Event\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;

final class OwnerCriterion implements EloquentCriterion
{
    private int $ownerId;

    public function __construct(int $ownerId)
    {
        $this->ownerId = $ownerId;
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->where('owner_id', $this->ownerId);
    }
}
