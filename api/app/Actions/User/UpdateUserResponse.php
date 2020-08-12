<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Entity\User;

final class UpdateUserResponse
{
    private User $profile;

    public function __construct(User $profile)
    {
        $this->profile = $profile;
    }

    public function getProfile(): User
    {
        return $this->profile;
    }
}
