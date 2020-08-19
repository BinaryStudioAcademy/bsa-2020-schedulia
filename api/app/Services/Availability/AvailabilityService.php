<?php

declare(strict_types=1);

namespace App\Services\Availability;

use App\Contracts\AvailabilityServiceInterface;
use App\Entity\Availability;
use App\Entity\EventType;
use App\Exceptions\Availability\AvailabilityValidationException;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class AvailabilityService implements AvailabilityServiceInterface
{
    private const MIDNIGHT_TIME = "00:00:00";

    public function validateAvailabilities(Collection $availabilities, int $duration)
    {
        foreach ($availabilities as $availability) {
            $this->validateAvailability($availability, $duration);
        }
        $this->checkAvailabilitiesOnOverlapping($availabilities);
        return true;
    }

    public function getAvailableDaysByEventType(EventType $eventType)
    {
        $availabilities = $eventType->availabilities;
    }

    private function validateAvailability(Availability $availability, int $duration)
    {
        $startDateTime = new Carbon($availability->start_date);
        $endDateTime = new Carbon($availability->end_date);

        $startDate = new Carbon($startDateTime->toDateString());
        $endDate = new Carbon($endDateTime->toDateString());

        $differenceInDays = $endDate->diffInDays($startDate);

        $startTime = $startDateTime->toTimeString();
        $endTime = $endDateTime->toTimeString();

        if ($availability->start_date > $availability->end_date) {
            throw new AvailabilityValidationException(400, "Your end time cannot be before your start time!");
        } else {
            $startDateWithDuration = new Carbon($availability->start_date);
            $startDateWithDuration->addMinutes($duration);
            $startDateWithDuration = $startDateWithDuration->format('Y-m-d H:i:s');
            if ($startDateWithDuration > $availability->end_date && $endTime !== self::MIDNIGHT_TIME) {
                throw new AvailabilityValidationException(400, "Intervals must be at least {$duration} minutes!");
            }
        }

        if (!in_array($availability->type, AvailabilityTypes::getTypes())) {
            throw new AvailabilityValidationException(400, "Unknown Availability type!");
        }

        if ($availability->type !== AvailabilityTypes::DATE_RANGE && $differenceInDays >= 1) {
            if ($differenceInDays === 1 && $endTime !== self::MIDNIGHT_TIME) {
                throw new AvailabilityValidationException(400, "Date for Availability with type '{$availability->type}' must be from one day!");
            }
        }
    }

    private function checkAvailabilitiesOnOverlapping(Collection $availabilities)
    {
        $availabilities = $availabilities->sortBy('type')->values();
        foreach ($availabilities as $index => $availability) {
            if ($index > 0 && $availability->type === $availabilities[$index - 1]->type) {
                if (
                    $availability->start_date > $availabilities[$index - 1]->start_date
                    &&
                    $availability->start_date < $availabilities[$index - 1]->end_date
                ) {
                    throw new AvailabilityValidationException(400, "Intervals are overlapping!");
                }

                if (
                    $availability->end_date < $availabilities[$index - 1]->end_date
                    &&
                    $availability->end_date > $availabilities[$index - 1]->start_date
                ) {
                    throw new AvailabilityValidationException(400, "Intervals are overlapping!");
                }
            }
        }
    }
}
