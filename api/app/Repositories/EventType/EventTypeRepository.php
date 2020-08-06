<?php

declare(strict_types=1);

namespace App\Repositories\EventType;

use App\Entity\EventType;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;

final class EventTypeRepository extends BaseRepository
{
    public function getById(int $id): EventType
    {
        return EventType::findOrFail($id);
    }

    public function save(EventType $eventType): EventType
    {
        $eventType->save();

        return $eventType;
    }

    public function delete(EventType $eventType): ?bool
    {
        return $eventType->delete();
    }

    public function getEventTypesByOwnerId(int $id): Collection
    {
        return EventType::where('owner_id', $id)->get();
    }
}
