<?php

declare(strict_types=1);

namespace App\Repositories\Event;

use App\Entity\Event;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class EventRepository extends BaseRepository implements EventRepositoryInterface
{
    public const DEFAULT_PAGE = 1;
    public const DEFAULT_PER_PAGE = 8;
    public const DEFAULT_SORT = 'created_at';
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
            ->paginate($perPage, ['*'], null, $page);
    }
}
