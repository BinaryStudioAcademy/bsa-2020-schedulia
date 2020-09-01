<?php

namespace App\Repositories\EventCalendar;

use App\Entity\EventCalendar;

class EventCalendarRepository implements EventCalendarRepositoryInterface
{
    public function getById(int $id): ?EventCalendar
    {
        // TODO: Implement getById() method.
    }

    public function getByEventId(int $eventId): ?EventCalendar
    {
        // TODO: Implement getByEventId() method.
    }

    public function getByEventAndProvider(int $eventId, int $providerId): ?EventCalendar
    {
        // TODO: Implement getByEventAndProvider() method.
    }

    public function save(EventCalendar $eventCalendar): void
    {
        // TODO: Implement save() method.
    }

    public function deleteById(): void
    {
        // TODO: Implement deleteById() method.
    }

}