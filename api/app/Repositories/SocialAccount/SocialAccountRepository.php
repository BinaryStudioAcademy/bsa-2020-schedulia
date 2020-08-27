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

    public function findByCriteria(EloquentCriterion ...$criteria): Collection
    {
        $query = SocialAccount::query();

        foreach ($criteria as $criterion) {
            $query = $criterion->apply($query);
        }

        return $query->get();
    }

    public function findMyByProvider(int $provider): SocialAccount
    {
        return SocialAccount::where('provider_id', '=', $provider)->where('user_id', '=', Auth::id())->firstOrFail();
    }
}