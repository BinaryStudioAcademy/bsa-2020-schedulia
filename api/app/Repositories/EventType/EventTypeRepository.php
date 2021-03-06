<?php

declare(strict_types=1);

namespace App\Repositories\EventType;

use App\Contracts\EloquentCriterion;
use App\Entity\EventType;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class EventTypeRepository extends BaseRepository implements EventTypeRepositoryInterface
{
    public const DEFAULT_PAGE = 1;
    public const DEFAULT_PER_PAGE = 4;
    public const DEFAULT_SORTING = 'created_at';
    public const DEFAULT_DIRECTION = 'DESC';
    public const DEFAULT_ALL = false;

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

    public function deleteTags(EventType $eventType): void
    {
        $eventType
            ->tags()
            ->delete();
    }

    public function saveCustomFields(EventType $eventType, array $customFields): void
    {
        $eventType
            ->customFields()
            ->createMany($customFields);
    }

    public function deleteCustomFields(EventType $eventType): void
    {
        $eventType
            ->customFields()
            ->delete();
    }

    public function findByCriteria(EloquentCriterion ...$criteria): Collection
    {
        $query = EventType::query();

        foreach ($criteria as $criterion) {
            $query = $criterion->apply($query);
        }

        return $query->get();
    }

    public function findOneByCriteria(EloquentCriterion ...$criteria): ?EventType
    {
        $query = EventType::query();

        foreach ($criteria as $criterion) {
            $query = $criterion->apply($query);
        }

        return $query->get()->first();
    }

    public function paginateByCriteria(
        array $criteria,
        int $page = self::DEFAULT_PAGE,
        int $perPage = self::DEFAULT_PER_PAGE,
        string $sorting = self::DEFAULT_SORTING,
        string $direction = self::DEFAULT_DIRECTION,
        bool $all = self::DEFAULT_ALL
    ): LengthAwarePaginator {
        $query = EventType::query();

        if ($all) {
            $perPage = $query->count();
        }

        foreach ($criteria as $criterion) {
            $query = $criterion->apply($query);
        }

        return $query
            ->orderBy($sorting, $direction)
            ->paginate($perPage, ['*'], null, $page);
    }
}
