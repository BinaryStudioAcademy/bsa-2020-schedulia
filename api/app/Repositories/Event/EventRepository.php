<?php

declare(strict_types=1);

namespace App\Repositories\Event;

use App\Contracts\EloquentCriterion;
use App\Entity\Event;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class EventRepository extends BaseRepository implements EventRepositoryInterface
{
    public const DEFAULT_PAGE = 1;
    public const DEFAULT_PER_PAGE = 8;
    public const DEFAULT_SORT = 'start_date';
    public const DEFAULT_DIRECTION = 'ASC';

    public function save(Event $event): Event
    {
        $event->save();

        return $event;
    }

    public function paginate(
        array $criteria,
        int $page = self::DEFAULT_PAGE,
        int $perPage = self::DEFAULT_PER_PAGE,
        string $sort = self::DEFAULT_SORT,
        string $direction = self::DEFAULT_DIRECTION
    ): LengthAwarePaginator {
        $query = Event::query();

        foreach ($criteria as $criterion) {
            $query = $criterion->apply($query);
        }

        return $query
            ->orderBy('events.' . $sort, $direction)
            ->select('events.*')
            ->paginate($perPage, ['*'], null, $page);
    }

    public function saveCustomFieldValues(Event $event, array $customFieldValues): void
    {
        $event
            ->customFieldValues()
            ->createMany($customFieldValues);
    }

    public function getEventsEmails(
        array $criteria
    ): Collection {
        $query = Event::query();

        foreach ($criteria as $criterion) {
            $query = $criterion->apply($query);
        }

        return $query
            ->select('events.invitee_email')
            ->distinct()
            ->get();
    }


    public function getById(int $id): ?Event
    {
        return Event::find($id);
    }

    public function deleteById(int $id): void
    {
        Event::destroy($id);
    }

    public function findByCriteria(EloquentCriterion ...$criteria): Collection
    {
        $query = Event::query();

        foreach ($criteria as $criterion) {
            $query = $criterion->apply($query);
        }

        return $query->get();
    }
}
