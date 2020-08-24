<?php

declare(strict_types=1);

namespace App\Repositories\Availability;

use App\Contracts\EloquentCriterion;
use App\Entity\Availability;
use Illuminate\Support\Collection;

final class AvailabilityRepository implements AvailabilityRepositoryInterface
{
    public function findByCriteria(EloquentCriterion ...$criteria): Collection
    {
        $query = Availability::query();

        foreach ($criteria as $criterion) {
            $query = $criterion->apply($query);
        }

        return $query->get();
    }
}
