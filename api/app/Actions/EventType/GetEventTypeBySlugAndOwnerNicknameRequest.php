<?php

declare(strict_types=1);

namespace App\Actions\EventType;

final class GetEventTypeBySlugAndOwnerNicknameRequest
{
    private string $slug;
    private string $ownerNickname;

    public function __construct(string $slug, string $ownerNickname)
    {
        $this->slug = $slug;
        $this->ownerNickname = $ownerNickname;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getOwnerNickname(): string
    {
        return $this->ownerNickname;
    }
}
