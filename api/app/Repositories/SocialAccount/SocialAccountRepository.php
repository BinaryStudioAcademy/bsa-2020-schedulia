<?php

declare(strict_types=1);

namespace App\Repositories\SocialAccount;

use App\Contracts\EloquentCriterion;
use App\Entity\SocialAccount;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

final class SocialAccountRepository extends BaseRepository implements SocialAccountRepositoryInterface
{
    public function save(SocialAccount $socialAccount): SocialAccount
    {
        $socialAccount->save();

        return $socialAccount;
    }

    public function delete(SocialAccount $socialAccount): SocialAccount
    {
        $socialAccount->delete();
    }

    public function findByCriteria(EloquentCriterion ...$criteria): Collection
    {
        $query = SocialAccount::query();

        foreach ($criteria as $criterion) {
            $query = $criterion->apply($query);
        }

        return $query->get();
    }

    public function findByProvider(int $provider, int $userId): SocialAccount
    {
        return SocialAccount::firstOrNew(['provider_id' => $provider, 'user_id' => $userId]);
    }
}
