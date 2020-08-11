<?php

declare(strict_types=1);

namespace App\Actions\Profile;

use App\Entity\User;

final class UpdateProfileResponse
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
