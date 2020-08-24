<?php

declare(strict_types=1);

namespace App\Services\Availability;

use App\Actions\AvailabilityService\ModificateDateTimeListRequest;
use App\Actions\AvailabilityService\ProcessEveryDayAction;
use App\Actions\AvailabilityService\ProcessExactDatesAction;
use App\Actions\AvailabilityService\ProcessUnavailableTimeAction;
use App\Contracts\AvailabilityServiceInterface;
use App\Entity\Availability;
use App\Entity\EventType;
use App\Exceptions\Availability\AvailabilityValidationException;
use App\Exceptions\Availability\EndTimeBeforeStartTimeException;
use App\Exceptions\Availability\IntervalsOverlappedException;
use App\Exceptions\Availability\TimeIsAlreadyBookedException;
use App\Exceptions\Availability\UnknownAvailabilityTypeException;
use App\Exceptions\Availability\WeekendException;
use App\Repositories\Availability\AvailabilityRepository;
use App\Repositories\Availability\Criterion\AvailabilitiesCriterion;
use App\Repositories\Availability\Criterion\AvailabilityDateRangeCriterion;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

final class AvailabilityService implements AvailabilityServiceInterface
{
    private const MIDNIGHT_TIME = "00:00:00";
    private ProcessEveryDayAction $processEveryDayAction;
    private ProcessExactDatesAction $processExactDatesAction;
    private ProcessUnavailableTimeAction $processUnavailableTimeAction;
    private AvailabilityRepository $availabilityRepository;

    public function __construct(
        ProcessEveryDayAction $processEveryDayAction,
        ProcessExactDatesAction $processExactDatesAction,
        ProcessUnavailableTimeAction $processUnavailableTimeAction,
        AvailabilityRepository $availabilityRepository
    ) {
        $this->processEveryDayAction = $processEveryDayAction;
        $this->processExactDatesAction = $processExactDatesAction;
        $this->processUnavailableTimeAction = $processUnavailableTimeAction;
        $this->availabilityRepository = $availabilityRepository;
    }

    public function validateAvailabilities(Collection $availabilities, int $duration): bool
    {
        $dateRangeAvailability = $availabilities->whereIn('type', AvailabilityTypes::getDateRangeTypes())->all();
        if (!count($dateRangeAvailability)) {
            throw new AvailabilityValidationException("There must be availability with type 'date_range*'");
        }

        foreach ($availabilities as $availability) {
            $this->validateAvailability($availability, $duration);
        }
        $this->checkAvailabilitiesOnOverlapping($availabilities);
        return true;
    }

    public function getAvailableDaysByEventType(EventType $eventType, string $monthDate): array
    {
        $availabilityDateRange = $this->availabilityRepository
            ->findByCriteria(new AvailabilityDateRangeCriterion($eventType->id))
            ->first();

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

        $dateTimeList = $this->processEveryDayAction->execute(
            new ModificateDateTimeListRequest($dateTimeList, $eventType)
        )->getModifiedTimeList();

        $dateTimeList = $this->processExactDatesAction->execute(
            new ModificateDateTimeListRequest($dateTimeList, $eventType)
        )->getModifiedTimeList();

        $dateTimeList = $this->processUnavailableTimeAction->execute(
            new ModificateDateTimeListRequest($dateTimeList, $eventType)
        )->getModifiedTimeList();

        return $dateTimeList;
    }

    public function checkIfTimeIsAvailable(EventType $eventType, string $dateTime): bool
    {
        $dateObj = new Carbon($dateTime);
        $date = $dateObj->toDateString();
        $time = new Carbon($dateObj->toTimeString());

        $dateTimeList = $this->getAvailableDaysByEventType($eventType, $date);
        if (!empty($dateTimeList[$date])) {
            foreach ($dateTimeList[$date] as $index => $interval) {
                if ($time->gte($interval['start_time']) && $time->lte($interval['end_time'])) {
                    if (!in_array($time->toTimeString(), $interval['unavailable'])) {
                        return true;
                    } else {
                        throw new TimeIsAlreadyBookedException();
                    }
                }
            }
        }

        if (isset($dateTimeList[$date]) && $dateObj->isWeekend() && empty($dateTimeList[$date])) {
            throw new WeekendException();
        }
        return false;
    }

    private function getPeriodForEventType(Availability $availability, string $monthDate): CarbonPeriod
    {
        $monthDate = new Carbon($monthDate);
        $availabilityStartDate = new Carbon($availability->start_date);
        $availabilityEndDate = new Carbon($availability->end_date);
        $monthDateFirstDay = $monthDate->startOfMonth()->toDateTimeString();
        $monthDateLastDay = $monthDate->endOfMonth()->toDateTimeString();

        if ($availabilityStartDate->gt($monthDateFirstDay)) {
            $periodStart = $availabilityStartDate->toDateTimeString();
        } else {
            $periodStart = $monthDateFirstDay;
        }

        if ($availabilityEndDate->lt($monthDateLastDay)) {
            $periodEnd = $availabilityEndDate->toDateTimeString();
        } else {
            $periodEnd = $monthDateLastDay;
        }

        if (in_array($availability->type, AvailabilityTypes::getIndefiniteTypes())) {
            $periodEnd = $monthDateLastDay;
        }

        return new CarbonPeriod($periodStart, $periodEnd);
    }

    private function getAvailableHoursByDate(EventType $eventType, string $date): ?array
    {
        $availabilities = $this->availabilityRepository
            ->findByCriteria(
                new AvailabilitiesCriterion($eventType->id)
            );
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

        if ($startDateTime->gt($endDateTime->toDateTimeString())) {
            throw new EndTimeBeforeStartTimeException();
        } else {
            $startDateWithDuration = new Carbon($availability->start_date);
            $startDateWithDuration->addMinutes($duration);

            if ($startDateWithDuration->gt($endDateTime) && $endTime !== self::MIDNIGHT_TIME) {
                throw new AvailabilityValidationException("Intervals must be at least {$duration} minutes!");
            }
        }

        if (!in_array($availability->type, AvailabilityTypes::getTypes())) {
            throw new UnknownAvailabilityTypeException();
        }

        if (!in_array($availability->type, AvailabilityTypes::getDateRangeTypes()) && $differenceInDays >= 1) {
            if ($differenceInDays === 1 && $endTime !== self::MIDNIGHT_TIME || $differenceInDays > 1) {
                throw new AvailabilityValidationException("Date for Availability with type '{$availability->type}' must be from one day!");
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
