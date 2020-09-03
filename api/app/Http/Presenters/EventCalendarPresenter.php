<?php

namespace App\Http\Presenters;

use App\Contracts\PresenterCollectionInterface;
use Illuminate\Support\Collection;

final class EventCalendarPresenter implements PresenterCollectionInterface
{
    public function presentCollection(Collection $eventCalendarCollection): array
    {
        return $eventCalendarCollection->map(function ($eventCalendar) {
            return $this->present($eventCalendar);
        })->toArray();
    }

    public function present($eventCalendar): array
    {
        return [
            'id' => $eventCalendar->id,
            'event_id' => $eventCalendar->event_id,
            'provider_id' => $eventCalendar->provider_id,
            'provider_event_id' => $eventCalendar->provider_event_id
        ];
    }
}
