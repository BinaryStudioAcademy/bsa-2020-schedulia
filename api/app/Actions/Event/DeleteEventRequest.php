<?php

declare(strict_types=1);

namespace App\Actions\Event;

final class DeleteEventRequest
{
    private int $id;
    private int $userId;

    public function __construct(int $id, int $userId)
    {
        $this->id = $id;
        $this->userId = $userId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
