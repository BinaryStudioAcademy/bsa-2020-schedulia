<?php

declare(strict_types=1);

namespace App\Repositories\Tag\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final class EndDateCriterion implements EloquentCriterion
{
    private string $endDate;
    private int $ownerId;

    public function __construct(
        string $endDate,
        int $ownerId
    ) {
        $this->endDate = $endDate;
        $this->ownerId = $ownerId;
    }

    public function apply(Builder $builder): Builder
    {
        return $build = $builder
            ->join('event_types', function ($join) {
                $join->on('tags.event_type_id', '=', 'event_types.id')
                    ->where('event_types.owner_id', '=', $this->ownerId)
                    ->join('events', function ($join) {
                        $join->on('event_types.id', '=', 'events.event_type_id')
                            ->where('events.start_date','<', $this->endDate);
                    })
                    ->distinct();
            });
    }
}
