<?php

namespace App\Listeners;

use App\Events\EventDeleted;
use App\Events\EventUpdated;
use App\Services\Calendar\Google\GoogleCalendarDeleteEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\SocialAccount\Google;

class DeleteEventFromGoogleCalendar implements ShouldQueue
{
    private $googleCalendar;

    public function __construct(Google $googleCalendar)
    {
        $this->googleCalendar = $googleCalendar;
    }

    public function handle(EventUpdated $eventUpdated): void
    {
        if (count($eventUpdated->event->googleCalendars)) {
            $this->googleCalendar->deleteEvent(new GoogleCalendarDeleteEvent(
                $eventUpdated->event->id,
                $eventUpdated->event->eventType->owner->id,
                $eventUpdated->event->googleCalendars[0]->provider_event_id
            ));
        }
    }
}
