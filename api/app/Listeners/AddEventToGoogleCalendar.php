<?php

namespace App\Listeners;

use App\Events\EventCreated;
use App\Services\Calendar\Google\GoogleCalendarEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\SocialAccount\Google;

class AddEventToGoogleCalendar implements ShouldQueue
{
    private $googleCalendar;

    public function __construct(Google $googleCalendar)
    {
        $this->googleCalendar = $googleCalendar;
    }

    public function handle(EventCreated $eventCreated): void
    {
        $this->googleCalendar->createEvent(
            new GoogleCalendarEvent(
                $eventCreated->event->eventType->name,
                $eventCreated->event->start_date,
                $eventCreated->event->eventType->duration,
                $eventCreated->event->eventType->description
                )
        );
    }
}
