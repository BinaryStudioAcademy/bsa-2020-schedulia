<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Contracts\PresenterCollectionInterface;
use App\Entity\Event;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class EventPresenter implements PresenterCollectionInterface
{
    private EventTypePresenter $eventTypePresenter;
    private CustomFieldValuePresenter $customFieldValuePresenter;
    private EventCalendarPresenter $eventCalendarPresenter;

    public function __construct(
        EventTypePresenter $eventTypePresenter,
        CustomFieldValuePresenter $customFieldValuePresenter,
        EventCalendarPresenter $eventCalendarPresenter
    ) {
        $this->eventTypePresenter = $eventTypePresenter;
        $this->customFieldValuePresenter = $customFieldValuePresenter;
        $this->eventCalendarPresenter = $eventCalendarPresenter;
    }

    public function present(Event $event): array
    {
        return [
            'id' => $event->id,
            'invitee_name' => $event->invitee_name,
            'invitee_email' => $event->invitee_email,
            'start_date' => Carbon::parse($event->start_date)->format('Y-m-d H:m:s'),
            'location' => $event->location,
            'timezone' => $event->timezone,
            'status' => $event->status,
            'created_at' => $event->created_at,
            'event_type' => $this->eventTypePresenter->present($event->eventType),
            'custom_field_values' => $this->customFieldValuePresenter->presentCollection($event->customFieldValues),
            'google_calendar_event' => $this->eventCalendarPresenter->presentCollection($event->googleCalendars)
        ];
    }

    public function presentCollection(Collection $eventCollection): array
    {
        return $eventCollection->map(function ($event) {
            return $this->present($event);
        })->toArray();
    }
}
