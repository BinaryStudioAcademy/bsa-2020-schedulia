<?php

declare(strict_types=1);

namespace App\Actions\AvailabilityService;

use App\Entity\EventType;
use App\Repositories\Availability\AvailabilityRepositoryInterface;
use App\Repositories\Availability\Criterion\AvailabilityTypeCriterion;
use App\Services\Availability\AvailabilityTypes;
use Carbon\Carbon;

final class ProcessExactDatesAction
{
    private AvailabilityRepositoryInterface $availabilityRepository;

    public function __construct(AvailabilityRepositoryInterface $availabilityRepository)
    {
        $this->availabilityRepository = $availabilityRepository;
    }

    public function execute(ModificateDateTimeListRequest $request): ModificateDateTimeListResponse
    {
        $modificatedDateTimeList = $this->processExactDates(
            $request->getDateTimeList(),
            $request->getEventType()
        );

        return new ModificateDateTimeListResponse($modificatedDateTimeList);
    }

    private function processExactDates(array $dateTimeList, EventType $eventType): array
    {
        $exactDates = $this->availabilityRepository
            ->findByCriteria(
                new AvailabilityTypeCriterion($eventType->id, AvailabilityTypes::EXACT_DATE)
            )
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
}
