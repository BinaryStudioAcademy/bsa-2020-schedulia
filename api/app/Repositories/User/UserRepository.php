<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Entity\SocialAccount;
use App\Contracts\EloquentCriterion;
use App\Entity\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;

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

    public function getByVerifiedEmail(string $email): ?User
    {
        return User::where('email', $email)->whereNotNull('email_verified_at')->first();
    }

    public function getByAccountId(string $id): ?SocialAccount
    {
        return SocialAccount::where('account_id', $id)->first();
    }

    public function save(User $user): User
    {
        $user->save();

        return $user;
    }

    public function deleteById(int $id): void
    {
        User::destroy($id);
    }

    public function markUserEmail(User $user): void
    {
        $user->markEmailAsVerified();
    }

    public function findByCriteria(EloquentCriterion ...$criteria): Collection
    {
        $query = User::query();

        foreach ($criteria as $criterion) {
            $query = $criterion->apply($query);
        }

        return $query->get();
    }

    public function findOneByCriteria(EloquentCriterion ...$criteria): User
    {
        $query = User::query();

        foreach ($criteria as $criterion) {
            $query = $criterion->apply($query);
        }

        return $query->first();
    }
}
