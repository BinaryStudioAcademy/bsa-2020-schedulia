<?php

declare(strict_types=1);

namespace App\Actions\Tag;

final class GetTagsByEventTypeIdRequest
{
    private ?int $eventTypes;

    public function __construct(?int $eventTypes)
    {
        $this->eventTypes = $eventTypes;
    }

    public function getEventTypes(): ?int
    {
        return $this->eventTypes;
    }
}
