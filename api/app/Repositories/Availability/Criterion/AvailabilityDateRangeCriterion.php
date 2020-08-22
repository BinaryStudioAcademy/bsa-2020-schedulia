<?php

declare(strict_types=1);

namespace App\Repositories\Availability\Criterion;

use App\Contracts\EloquentCriterion;
use App\Services\Availability\AvailabilityTypes;
use Illuminate\Database\Eloquent\Builder;

final class AvailabilityDateRangeCriterion extends BaseAvailabilityCriterion implements EloquentCriterion
{
    public function apply(Builder $builder): Builder
    {
        return $builder
            ->whereIn('type', AvailabilityTypes::getDateRangeTypes())
            ->where('event_type_id', $this->eventTypeId);
    }
}
