<?php

declare(strict_types=1);

namespace App\Actions\AvailabilityService;

use App\Entity\EventType;
use App\Repositories\Availability\AvailabilityRepositoryInterface;
use App\Repositories\Availability\Criterion\AvailabilityTypeCriterion;
use App\Services\Availability\AvailabilityTypes;
use Carbon\Carbon;

final class ProcessEveryDayAction
{
    private AvailabilityRepositoryInterface $availabilityRepository;

    public function __construct(AvailabilityRepositoryInterface $availabilityRepository)
    {
        $this->availabilityRepository = $availabilityRepository;
    }

    public function execute(ModificateDateTimeListRequest $request): ModificateDateTimeListResponse
    {
        $modifiedDateTimeList = $this->processEveryDay(
            $request->getDateTimeList(),
            $request->getEventType()
        );

        return new ModificateDateTimeListResponse($modifiedDateTimeList);
    }

    private function processEveryDay(array $dateTimeList, EventType $eventType): array
    {
        $everyDayTypes = AvailabilityTypes::getTypesForEveryDay();
        foreach ($everyDayTypes as $type) {
            $dateTimeList = $this->processEveryDayByType($dateTimeList, $eventType, $type);
        }
        return $dateTimeList;
    }

    private function processEveryDayByType(array $dateTimeList, EventType $eventType, string $type): array
    {
        $everyDayIntervals = $this->availabilityRepository
            ->findByCriteria(new AvailabilityTypeCriterion($eventType->id, $type))
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
}
