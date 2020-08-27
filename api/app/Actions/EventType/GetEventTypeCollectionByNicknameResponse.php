<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use Illuminate\Support\Collection;

final class GetEventTypeCollectionByNicknameResponse
{
    private Collection $eventTypes;

    public function __construct(Collection $eventTypes)
    {
        $this->eventTypes = $eventTypes;
    }

    public function getEventTypes(): Collection
    {
        return $this->eventTypes;
    }
}
