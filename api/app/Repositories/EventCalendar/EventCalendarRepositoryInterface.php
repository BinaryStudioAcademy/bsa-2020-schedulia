<?php

namespace App\Repositories\EventCalendar;


use App\Entity\EventCalendar;

interface EventCalendarRepositoryInterface
{
    public function getById(int $id): ?EventCalendar;
    public function getByEventId(int $eventId): ?EventCalendar;
    public function getByEventAndProvider(int $eventId, int $providerId): ?EventCalendar;
    public function save(EventCalendar $eventCalendar): void;
    public function deleteById(): void;
}