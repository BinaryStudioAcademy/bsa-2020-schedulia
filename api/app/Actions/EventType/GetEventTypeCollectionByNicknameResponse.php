<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use Illuminate\Support\Collection;

final class GetEventTypeCollectionByNicknameResponse
{
    private Collection $eventTypes;
    private string $ownerName;

    public function __construct(
        Collection $eventTypes,
        string $ownerName
    ) {
        $this->eventTypes = $eventTypes;
        $this->ownerName = $ownerName;
    }

    public function getEventTypes(): Collection
    {
        return $this->eventTypes;
    }

    public function getOwnerName(): string
    {
        return $this->ownerName;
    }
}
