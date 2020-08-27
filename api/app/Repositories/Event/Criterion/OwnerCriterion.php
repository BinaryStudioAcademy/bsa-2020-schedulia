<?php

declare(strict_types=1);

namespace App\Repositories\Event\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;

use function Clue\StreamFilter\fun;

final class OwnerCriterion implements EloquentCriterion
{
    private int $ownerId;

    public function __construct(int $ownerId)
    {
        $this->ownerId = $ownerId;
    }

    public function apply(Builder $builder): Builder
    {
         $build = $builder->join('event_types', function ($join) {
            $join->on('events.event_type_id', '=', 'event_types.id')
                ->where('event_types.owner_id', '=', $this->ownerId);
        });

         return $build;
//         $builder->where('event_type_id', 1);
    }
}
