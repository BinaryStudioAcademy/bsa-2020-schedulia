<?php

declare(strict_types=1);

namespace App\Actions\Tag;

final class GetTagsByEventTypeIdRequest
{
    private ?int $eventTypeId;

    public function __construct(?int $eventTypeId)
    {
        $this->eventTypeId = $eventTypeId;
    }

    public function getEventTypeId(): ?int
    {
        return $this->eventTypeId;
    }
}
