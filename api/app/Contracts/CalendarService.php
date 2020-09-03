<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Services\Calendar\DeleteEventInterface;

interface CalendarService
{
    public function createEvent(CalendarEventInterface $calendarEvent): void;
    public function deleteEvent(DeleteEventInterface $event): void;
}
