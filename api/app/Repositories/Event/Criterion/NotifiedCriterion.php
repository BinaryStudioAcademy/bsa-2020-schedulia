<?php

declare(strict_types=1);

namespace App\Repositories\Event\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final class NotifiedCriterion implements EloquentCriterion
{
    private bool $notified;

    public function __construct(bool $notified)
    {
        $this->notified = $notified;
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->where(
            'notified',
            '=',
            $this->notified
        );
    }
}
