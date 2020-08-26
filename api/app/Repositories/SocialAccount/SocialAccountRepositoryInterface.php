<?php

declare(strict_types=1);

namespace App\Repositories\SocialAccount;

use App\Entity\SocialAccount;

interface SocialAccountRepositoryInterface
{
    public function save(SocialAccount $user): SocialAccount;
    public function findByCriteria(EloquentCriterion ...$criteria): Collection;
}
