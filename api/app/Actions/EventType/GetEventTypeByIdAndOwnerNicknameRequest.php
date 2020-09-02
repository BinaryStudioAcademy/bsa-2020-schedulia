<?php

declare(strict_types=1);

namespace App\Actions\EventType;

final class GetEventTypeByIdAndOwnerNicknameRequest
{
    private int $eventTypeId;
    private string $nickname;

    public function __construct(int $eventTypeId, string $nickname)
    {
        $this->eventTypeId = $eventTypeId;
        $this->nickname = $nickname;
    }

    public function getEventTypeId(): int
    {
        return $this->eventTypeId;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }
}
