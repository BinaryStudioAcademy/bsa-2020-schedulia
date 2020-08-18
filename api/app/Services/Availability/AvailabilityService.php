<?php

declare(strict_types=1);

namespace App\Services\Availability;

use App\Contracts\AvailabilityServiceInterface;

final class AvailabilityService implements AvailabilityServiceInterface
{
    public function validateAvailabilities(array $availabilities)
    {
        foreach ($availabilities as $availability) {
            $this->validateAvailability($availability);
        }
        return true;
    }

    private function validateAvailability($availability)
    {
        if ($availability['start_date'] > $availability['end_date']) {
            abort(400, "Your end time cannot be before your start time!");
        }

        if ($availability['start_date'] === $availability['end_date']) {
            abort(400, "Start time and end time cannot be equal!");
        }
    }
}
