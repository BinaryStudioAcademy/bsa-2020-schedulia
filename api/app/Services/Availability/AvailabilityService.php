<?php

declare(strict_types=1);

namespace App\Services\Availability;

use App\Contracts\AvailabilityServiceInterface;
use App\Entity\Availability;
use App\Entity\EventType;
use App\Exceptions\Availability\AvailabilityValidationException;
use App\Exceptions\Availability\EndTimeBeforeStartTimeException;
use App\Exceptions\Availability\IntervalsOverlappedException;
use App\Exceptions\Availability\UnknownAvailabilityTypeException;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

final class AvailabilityService implements AvailabilityServiceInterface
{
    private const MIDNIGHT_TIME = "00:00:00";

    public function getAvailableDaysByEventType(EventType $eventType, string $monthDate)
    {
        $availabilityDateRange = $eventType->availabilities
            ->whereIn('type', AvailabilityTypes::getDateRangeTypes())->first();

        $period = $this->getPeriodForEventType($eventType, $monthDate);

        $dateTimeList = [];
        $startTime = (new Carbon($availabilityDateRange->start_date))->toTimeString();
        $endTime = (new Carbon($availabilityDateRange->end_date))->toTimeString();

        foreach ($period as $day) {
            $date = $day->format('Y-m-d');
            $dateTimeList[$date] =
                $this->getAvailableHoursByDate($eventType, $date) ?:
                    [[
                        "type" => $availabilityDateRange->type,
                        "start_time" => $startTime,
                        "end_time" => $endTime
                    ]];
        }

        $dateTimeList = $this->processEveryDay($dateTimeList, $eventType);

        return $dateTimeList;
    }

    private function getPeriodForEventType(EventType $eventType, string $monthDate): CarbonPeriod
    {
        $availabilityDateRange = $eventType->availabilities
            ->whereIn('type', AvailabilityTypes::getDateRangeTypes())->first();

        $monthDate = new Carbon($monthDate);
        $monthDateFirstDay = $monthDate->startOfMonth()->toDateTimeString();
        $monthDateLastDay = $monthDate->endOfMonth()->toDateTimeString();

        if ($availabilityDateRange->start_date > $monthDateFirstDay) {
            $periodStart = $availabilityDateRange->start_date;
        } else {
            $periodStart = $monthDateFirstDay;
        }

        if ($availabilityDateRange->end_date < $monthDateLastDay) {
            $periodEnd = $availabilityDateRange->end_date;
        } else {
            $periodEnd = $monthDateLastDay;
        }

        if (in_array($availabilityDateRange->type, AvailabilityTypes::getIndefiniteTypes())) {
            $periodEnd = $monthDateLastDay;
        }

        return new CarbonPeriod($periodStart, $periodEnd);
    }

    private function processEveryDay(array $dateTimeList, EventType $eventType)
    {
        $everyDayTypes = AvailabilityTypes::getTypesForEveryDay();
        foreach ($everyDayTypes as $type) {
            $dateTimeList = $this->processEveryDayByType($dateTimeList, $eventType, $type);
        }

        return $dateTimeList;
    }

    private function processEveryDayByType($dateTimeList, EventType $eventType, string $type)
    {
        $everyDayIntervals = $eventType->availabilities
            ->where('type', $type)
            ->map(function($availability) {
                return [
                    'type' => $availability->type,
                    'start_date' => (new Carbon($availability->start_date))->toTimeString(),
                    'end_date' => (new Carbon($availability->end_date))->toTimeString()
                ];
            })
            ->values()
            ->all();

        foreach ($dateTimeList as $date => $timeIntervals) {
            $dateCarbon = new Carbon($date);
            if ($everyDayIntervals) {
                $method = 'is' . ucfirst(explode('_', $type)[1]);
                if ($dateCarbon->$method()) {
                    $dateTimeList[$date] = $everyDayIntervals;
                }
            }
        }
        return $dateTimeList;
    }

    public function getAvailableHoursByDate(EventType $eventType, string $date)
    {
        $availabilities = $eventType->availabilities;
        $result = [];
        foreach ($availabilities as $availability) {
            $startDate = (new Carbon($availability->start_date))->toDateString();
            if ($date === $startDate) {
                $result[] = [
                    "type" => $availability->type,
                    "start_time" => (new Carbon($availability->start_date))->toTimeString(),
                    "end_time" => (new Carbon($availability->end_date))->toTimeString()
                ];
            }
        }

        return count($result) ? $result : false;
    }

//    public function chunkDateTimeList(array $dateTimeList, int $interval = 60)
//    {
//        foreach ($dateTimeList as $index => $pairTime) {
//            foreach ($pairTime as $key => $time) {
//                $startTime = $time[0];
//                $endTime = $time[1];
//                while ($startTime !== $endTime) {
//                    $time = new Carbon($startTime);
//                    $time->addMinutes($interval);
//                    $startTime = $time->format('H:i:s');
//                    $dateTimeList[$index][$key][] = $startTime;
//                }
//            }
//        }
//        return $dateTimeList;
//    }

    public function validateAvailabilities(Collection $availabilities, int $duration): bool
    {
        foreach ($availabilities as $availability) {
            $this->validateAvailability($availability, $duration);
        }
        $this->checkAvailabilitiesOnOverlapping($availabilities);
        return true;
    }

    private function validateAvailability(Availability $availability, int $duration): void
    {
        $startDateTime = new Carbon($availability->start_date);
        $endDateTime = new Carbon($availability->end_date);

        $startDate = new Carbon($startDateTime->toDateString());
        $endDate = new Carbon($endDateTime->toDateString());

        $differenceInDays = $endDate->diffInDays($startDate);

        $endTime = $endDateTime->toTimeString();

        if ($availability->start_date > $availability->end_date) {
            throw new EndTimeBeforeStartTimeException();
        } else {
            $startDateWithDuration = new Carbon($availability->start_date);
            $startDateWithDuration->addMinutes($duration);
            $startDateWithDuration = $startDateWithDuration->format('Y-m-d H:i:s');
            if ($startDateWithDuration > $availability->end_date && $endTime !== self::MIDNIGHT_TIME) {
                throw new AvailabilityValidationException(400, "Intervals must be at least {$duration} minutes!");
            }
        }

        if (!in_array($availability->type, AvailabilityTypes::getTypes())) {
            throw new UnknownAvailabilityTypeException();
        }

        if ($availability->type !== AvailabilityTypes::DATE_RANGE && $differenceInDays >= 1) {
            if ($differenceInDays === 1 && $endTime !== self::MIDNIGHT_TIME) {
                throw new AvailabilityValidationException(400, "Date for Availability with type '{$availability->type}' must be from one day!");
            }
        }
    }

    private function checkAvailabilitiesOnOverlapping(Collection $availabilities): void
    {
        $availabilities = $availabilities->sortBy('type')->values();
        foreach ($availabilities as $index => $availability) {
            if ($index > 0 && $availability->type === $availabilities[$index - 1]->type) {
                if (
                    ($availability->start_date > $availabilities[$index - 1]->start_date
                    &&
                    $availability->start_date < $availabilities[$index - 1]->end_date)
                    ||
                    ($availability->end_date < $availabilities[$index - 1]->end_date
                    &&
                    $availability->end_date > $availabilities[$index - 1]->start_date)
                ) {
                    throw new IntervalsOverlappedException();
                }
            }
        }
    }
}
