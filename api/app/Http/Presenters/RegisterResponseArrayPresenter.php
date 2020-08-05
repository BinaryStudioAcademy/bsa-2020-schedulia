<?php

declare(strict_types = 1);

namespace App\Http\Presenters;

use App\Entity\User;

final class RegisterResponseArrayPresenter
{
    public function present(User $user): array
    {
        return [
            'user_id' => $user->getId(),
            'email' => $user->getEmail(),
            'name' => $user->getName(),
//            'timezone' => $user->getTimezone(),
        ];
    }
}
