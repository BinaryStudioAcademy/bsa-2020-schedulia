<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Entity\EventType;

final class GetEventTypeByIdResponse
{
    private $eventType;

    public function __construct(EventType $eventType)
    {
        $this->eventType = $eventType;
    }

    public function getEventType(): EventType
    {
        return $this->eventType;
    }
}
