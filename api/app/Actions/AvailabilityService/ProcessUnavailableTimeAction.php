<?php

declare(strict_types=1);

namespace App\Actions\AvailabilityService;

use App\Constants\EventStatus;
use App\Entity\EventType;
use Carbon\Carbon;

final class ProcessUnavailableTimeAction
{
    public function execute(ModificateDateTimeListRequest $request): ModificateDateTimeListResponse
    {
        $modificatedDateTimeList = $this->getUnavailableTime(
            $request->getDateTimeList(),
            $request->getEventType()
        );

        return new ModificateDateTimeListResponse($modificatedDateTimeList);
    }

    private function getUnavailableTime(array $dateTimeList, EventType $eventType)
    {
        $events = $eventType->events
            ->filter(function ($event) {
                return $event->status === EventStatus::SCHEDULED;
            })
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
