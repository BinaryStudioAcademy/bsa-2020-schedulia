<?php

declare(strict_types=1);

namespace App\Repositories\Availability;

use App\Contracts\EloquentCriterion;
use Illuminate\Support\Collection;

interface AvailabilityRepositoryInterface
{
    public function findByCriteria(EloquentCriterion ...$criteria): Collection;
}
