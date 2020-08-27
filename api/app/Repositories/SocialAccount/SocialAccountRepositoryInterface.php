<?php

declare(strict_types=1);

namespace App\Repositories\SocialAccount;

use App\Entity\SocialAccount;
use Illuminate\Support\Collection;
use App\Contracts\EloquentCriterion;

interface SocialAccountRepositoryInterface
{
    public function save(SocialAccount $user): SocialAccount;
    public function findMyByProvider(int $provider): SocialAccount;
    public function findByCriteria(EloquentCriterion ...$criteria): Collection;
}
