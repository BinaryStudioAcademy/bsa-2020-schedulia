<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use Illuminate\Support\Collection;

final class SearchEventTypesByNameResponse
{
    private array $eventTypes;

    public function __construct(Collection $eventTypes)
    {
        $this->eventTypes = $eventTypes->toArray();
    }

    public function getSearchedEventTypes()
    {
        return $this->eventTypes;
    }
}
