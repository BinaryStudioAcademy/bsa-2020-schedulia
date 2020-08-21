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

    public function validateAvailabilities(Collection $availabilities, int $duration): bool
    {
        foreach ($availabilities as $availability) {
            $this->validateAvailability($availability, $duration);
        }
        $this->checkAvailabilitiesOnOverlapping($availabilities);
        return true;
    }

    public function getAvailableDaysByEventType(EventType $eventType, string $monthDate): array
    {
        $availabilityDateRange = $eventType->availabilities
            ->whereIn('type', AvailabilityTypes::getDateRangeTypes())->first();

        $period = $this->getPeriodForEventType($availabilityDateRange, $monthDate);

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
                        "end_time" => $endTime,
                        "unavailable" => []
                    ]];
            if (in_array($availabilityDateRange->type, AvailabilityTypes::getWeekdaysTypes())) {
                if ($day->isSaturday() || $day->isSunday()) {
                    $dateTimeList[$date] = [];
                }
            }
        }

        $dateTimeList = $this->processEveryDay($dateTimeList, $eventType);
        $dateTimeList = $this->processExactDates($dateTimeList, $eventType);
        $dateTimeList = $this->getUnavailableTime($dateTimeList, $eventType);

        return $dateTimeList;
    }

    public function checkIfTimeIsAvailable(EventType $eventType, string $dateTime): bool
    {
        $dateObj = new Carbon($dateTime);
        $date = $dateObj->toDateString();
        $time = $dateObj->toTimeString();

        $dateTimeList = $this->getAvailableDaysByEventType($eventType, $date);
        if (isset($dateTimeList[$date])) {
            foreach ($dateTimeList[$date] as $index => $pairTime) {
                if (in_array($time, $dateTimeList[$date][$index]['times'])) {
                    return true;
                }
            }
        }
        return false;
    }

    private function getPeriodForEventType(Availability $availability, string $monthDate): CarbonPeriod
    {
        $monthDate = new Carbon($monthDate);
        $monthDateFirstDay = $monthDate->startOfMonth()->toDateTimeString();
        $monthDateLastDay = $monthDate->endOfMonth()->toDateTimeString();

        if ($availability->start_date > $monthDateFirstDay) {
            $periodStart = $availability->start_date;
        } else {
            $periodStart = $monthDateFirstDay;
        }

        if ($availability->end_date < $monthDateLastDay) {
            $periodEnd = $availability->end_date;
        } else {
            $periodEnd = $monthDateLastDay;
        }

        if (in_array($availability->type, AvailabilityTypes::getIndefiniteTypes())) {
            $periodEnd = $monthDateLastDay;
        }

        return new CarbonPeriod($periodStart, $periodEnd);
    }

    private function processEveryDay(array $dateTimeList, EventType $eventType): array
    {
        $everyDayTypes = AvailabilityTypes::getTypesForEveryDay();
        foreach ($everyDayTypes as $type) {
            $dateTimeList = $this->processEveryDayByType($dateTimeList, $eventType, $type);
        }
        return $dateTimeList;
    }

    private function processExactDates(array $dateTimeList, EventType $eventType): array
    {
        $exactDates = $eventType->availabilities
            ->where('type', AvailabilityTypes::EXACT_DATE)
            ->map(fn ($availability) => [
                'type' => $availability->type,
                'start_date' => (new Carbon($availability->start_date))->toDateString(),
                'start_time' => (new Carbon($availability->start_date))->toTimeString(),
                'end_date' => (new Carbon($availability->end_date))->toTimeString(),
                'end_time' => (new Carbon($availability->end_date))->toTimeString(),
            ])
            ->groupBy('start_date')
            ->map(fn ($availability) => $availability
                ->map(fn ($interval) => [
                    'type' => $interval['type'],
                    'start_time' => $interval['start_time'],
                    'end_time' => $interval['end_time'],
                    'unavailable' => []
                ])
                ->all())
            ->all();

        foreach ($dateTimeList as $date => $intervals) {
            if (isset($exactDates[$date])) {
                $dateTimeList[$date] = $exactDates[$date];
            }
        }

        return $dateTimeList;
    }

    private function processEveryDayByType(array $dateTimeList, EventType $eventType, string $type): array
    {
        $everyDayIntervals = $eventType->availabilities
            ->where('type', $type)
            ->map(function ($availability) {
                return [
                    'type' => $availability->type,
                    'start_time' => (new Carbon($availability->start_date))->toTimeString(),
                    'end_time' => (new Carbon($availability->end_date))->toTimeString(),
                    'unavailable' => []
                ];
            })
            ->values()
            ->all();

        foreach ($dateTimeList as $date => $timeIntervals) {
            $dateCarbon = new Carbon($date);
            if ($everyDayIntervals) {
                $isDayName = 'is' . ucfirst(explode('_', $type)[1]);
                if ($dateCarbon->$isDayName()) {
                    $dateTimeList[$date] = $everyDayIntervals;
                }
            }
        }
        return $dateTimeList;
    }

    private function getAvailableHoursByDate(EventType $eventType, string $date): ?array
    {
        $availabilities = $eventType->availabilities;
        $result = [];
        foreach ($availabilities as $availability) {
            $startDate = (new Carbon($availability->start_date))->toDateString();
            if ($date === $startDate) {
                $result[] = [
                    "type" => $availability->type,
                    "start_time" => (new Carbon($availability->start_date))->toTimeString(),
                    "end_time" => (new Carbon($availability->end_date))->toTimeString(),
                    "unavailable" => []
                ];
            }
        }

        return count($result) ? $result : null;
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

    private function getUnavailableTime(array $dateTimeList, EventType $eventType)
    {
        $events = $eventType->events
            ->map(fn ($event) => [
                'start_date' => (new Carbon($event->start_date))->toDateString(),
                'start_time' => (new Carbon($event->start_date))->toTimeString(),
        ])
            ->groupBy('start_date')
            ->map(fn ($event) => $event->all())
            ->all();
        $eventsDateTime = [];
        foreach ($events as $date =>$event) {
            foreach ($event as $key => $time) {
                $eventsDateTime[$date][] = $time['start_time'];
            }
        }

        foreach ($dateTimeList as $date => $intervals) {
            foreach ($intervals as $key => $interval) {
                if (isset($eventsDateTime[$date])) {
                    $dateTimeList[$date][$key]['unavailable'] = $eventsDateTime[$date];
                }
            }
        }
        return $dateTimeList;
    }
}
