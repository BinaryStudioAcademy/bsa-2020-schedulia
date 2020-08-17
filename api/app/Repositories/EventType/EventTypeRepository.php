<?php

declare(strict_types=1);

namespace App\Repositories\EventType;

use App\Entity\EventType;
use App\Repositories\BaseRepository;
use App\Repositories\Criteria\Criteria;
use Illuminate\Support\Collection;

final class EventTypeRepository extends BaseRepository implements EventTypeRepositoryInterface
{
    public function getById(int $id): ?EventType
    {
        return EventType::find($id);
    }

    public function save(EventType $eventType): EventType
    {
        $eventType->save();

        return $eventType;
    }

    public function deleteById(int $id): void
    {
        EventType::destroy($id);
    }

    public function saveAvailabilities(EventType $eventType, array $availabilities): void
    {
        $eventType
            ->availabilities()
            ->createMany($availabilities);
    }

    public function deleteAvailabilities(EventType $eventType): void
    {
        $eventType
            ->availabilities()
            ->delete();
    }

    public function findByCriteria(Criteria ...$criterias): Collection
    {
        $eventType = new EventType();
        $query = $eventType->newQuery();

        foreach ($criterias as $criteria) {
            $query = $criteria->apply($query);
        }

        return $query->get();
    }
}
