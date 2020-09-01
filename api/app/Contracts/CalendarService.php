<?php

declare(strict_types=1);

namespace App\Contracts;

interface CalendarService
{
    public function createEvent(CalendarEventInterface $calendarEvent): void;
    public function deleteEvent(): void;
}
