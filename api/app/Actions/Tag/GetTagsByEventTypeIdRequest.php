<?php

declare(strict_types=1);

namespace App\Actions\Tag;

final class GetTagsByEventTypeIdRequest
{
    private ?array $eventTypes;

    public function __construct(?array $eventTypes) {
        $this->eventTypes = $eventTypes;
    }

    public function getEventTypes(): ?array
    {
        return $this->eventTypes;
    }
}
