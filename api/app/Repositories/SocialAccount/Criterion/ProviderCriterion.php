<?php

declare(strict_types=1);

namespace App\Repositories\SocialAccount\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;

final class ProviderCriterion implements EloquentCriterion
{
    private array $providersId;

    public function __construct(array $providersId)
    {
        $this->providersId = $providersId;
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->whereIn('provider_id', $this->providersId);
    }
}
