<?php

declare(strict_types=1);

namespace App\Actions\User;

final class UpdateUserPasswordRequest
{
    private int $userId;
    private string $oldPassword;
    private string $newPassword;

    public function __construct(
        int $userId,
        string $oldPassword,
        string $newPassword
    ) {
        $this->userId = $userId;
        $this->oldPassword = $oldPassword;
        $this->newPassword = $newPassword;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    public function getOldPassword(): string
    {
        return $this->oldPassword;
    }
}
