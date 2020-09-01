<?php

namespace App\Listeners;

use App\Events\EventDeleted;
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

    public function handle(EventDeleted $eventDeleted): void
    {
        if(count($eventDeleted->event['google_calendar_event']))
        {
            $this->googleCalendar->deleteEvent(new GoogleCalendarDeleteEvent(
                $eventDeleted->event['id'],
                $eventDeleted->event['event_type']['owner']['id'],
                $eventDeleted->event['google_calendar_event'][0]['provider_event_id']
            ));
        }
    }
}
