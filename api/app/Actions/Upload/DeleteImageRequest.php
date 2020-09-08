<?php

declare(strict_types=1);

namespace App\Actions\Upload;

final class DeleteImageRequest
{
    private int $userId;
    private string $type;

    public function __construct(
        int $userId,
        string $type
    ) {
        $this->userId = $userId;
        $this->type = $type;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
