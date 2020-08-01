<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Entity\User;
use App\Repositories\BaseRepository;

final class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getById(int $id): ?User
    {
        return User::find($id);
    }

    public function getByEmail(string $email): ?User
    {
        return User::firstWhere('email', $email);
    }
}
