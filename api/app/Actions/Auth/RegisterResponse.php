<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Entity\User;

final class RegisterResponse
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
