<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Entity\EventType;

final class CloneEventTypeByIdResponse
{
    private EventType $newEventType;

    public function __construct(EventType $newEventType)
    {
        $this->newEventType = $newEventType;
    }

    public function getNewEventType(): EventType
    {
        return $this->newEventType;
    }
}
