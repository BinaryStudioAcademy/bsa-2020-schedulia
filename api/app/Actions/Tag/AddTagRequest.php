<?php

declare(strict_types=1);

namespace App\Actions\Tag;

final class AddTagRequest
{
    private int $eventTypeId;
    private string $name;

    public function __construct(
        int $eventTypeId,
        string $name
    ) {
        $this->eventTypeId = $eventTypeId;
        $this->name = $name;
    }

    public function getEventTypeId(): int
    {
        return $this->eventTypeId;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
