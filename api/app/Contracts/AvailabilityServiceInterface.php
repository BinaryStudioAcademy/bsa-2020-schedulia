<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface AvailabilityServiceInterface
{
    public function validateAvailabilities(Collection $availabilities, int $duration);
}
