<?php

namespace App\Repositories\EventCalendar;


use App\Entity\EventCalendar;

interface EventCalendarRepositoryInterface
{
    public function getById(int $id): ?EventCalendar;
    public function getByEventIdAndEventCalendarId(int $eventId, string $eventCalendarId): ?EventCalendar;
    public function save(EventCalendar $eventCalendar): EventCalendar;
    public function deleteById(int $id): void;
}