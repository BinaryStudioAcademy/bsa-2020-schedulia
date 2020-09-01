<?php

namespace App\Repositories\EventCalendar;

use App\Entity\EventCalendar;

class EventCalendarRepository implements EventCalendarRepositoryInterface
{
    public function getById(int $id): ?EventCalendar
    {
        return EventCalendar::find($id);
    }

    public function getByEventIdAndEventCalendarId(int $eventId, string $eventCalendarId): ?EventCalendar
    {
        return EventCalendar::where('event_id', $eventId)
            ->where('provider_event_id', $eventCalendarId)
            ->firstOrFail();
    }

    public function save(EventCalendar $eventCalendar): EventCalendar
    {
        $eventCalendar->save();

        return $eventCalendar;
    }

    public function deleteById(int $id): void
    {
        EventCalendar::destroy($id);
    }

}