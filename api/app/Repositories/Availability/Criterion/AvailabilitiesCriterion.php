<?php

declare(strict_types=1);

namespace App\Repositories\Availability\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;

final class AvailabilitiesCriterion extends BaseAvailabilityCriterion implements EloquentCriterion
{
    public function apply(Builder $builder): Builder
    {
        return $builder->where('event_type_id', $this->eventTypeId);
    }
}
