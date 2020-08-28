<?php

declare(strict_types=1);

namespace App\Actions\EventType;

final class GetEventTypeCollectionByNicknameRequest
{
    private string $nickname;

    public function __construct(string $nickname)
    {
        $this->nickname = $nickname;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }
}
