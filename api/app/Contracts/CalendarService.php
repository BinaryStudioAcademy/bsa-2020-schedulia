<?php

declare(strict_types=1);

namespace App\Contracts;

interface CalendarService
{
    public function createEvent(CalendarEvent $calendarEvent): void;
    public function deleteEvent(): void;
}
