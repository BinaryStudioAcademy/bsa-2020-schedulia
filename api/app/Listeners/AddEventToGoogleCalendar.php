<?php

namespace App\Listeners;

use App\Events\EventCreated;
use App\Services\Calendar\Google\GoogleCalendarEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\SocialAccount\Google;

class AddEventToGoogleCalendar implements ShouldQueue
{
    private $googleCalendar;

    public function __construct(Google $googleCalendar): void
    {
        $this->googleCalendar = $googleCalendar;
    }

    public function handle(EventCreated $eventCreated): void
    {
        $eventCreated->googleCalendar->create(new GoogleCalendarEvent());
    }
}
