<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use Illuminate\Support\Collection;

final class GetEventTypeCollectionResponse
{
    private Collection $eventType;

    public function __construct(Collection $eventType)
    {
        $this->eventType = $eventType;
    }

    public function getEventTypeCollection(): Collection
    {
        return $this->eventType;
    }
}
