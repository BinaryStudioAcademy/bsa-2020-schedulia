<?php

namespace App\Actions\Zoom;

final class ZoomCallbackRequest
{
    private string $code;
    private int $userId;

    public function __construct(string $code, string $state)
    {
        $this->code = $code;
        $this->userId = (int)$state;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
