<?php

declare(strict_types=1);

namespace App\Repositories\Event;

use App\Entity\Event;
use App\Repositories\BaseRepository;

final class EventRepository extends BaseRepository implements EventRepositoryInterface
{
    public function save(Event $event): Event
    {
        $event->save();

        return $event;
    }

    public function saveCustomFieldValues(Event $event, array $customFieldValues): void
    {
        $event
            ->customFieldValues()
            ->createMany($customFieldValues);
    }
}
