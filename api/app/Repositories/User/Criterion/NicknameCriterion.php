<?php

declare(strict_types=1);

namespace App\Repositories\User\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;

final class NicknameCriterion implements EloquentCriterion
{
    private string $nickname;

    public function __construct(string $nickname)
    {
        $this->nickname = $nickname;
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->where('nickname', $this->nickname);
    }
}
