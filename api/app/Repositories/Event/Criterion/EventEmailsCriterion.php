<?php

declare(strict_types=1);

namespace App\Repositories\Event\Criterion;

use App\Contracts\EloquentCriterion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final class EventEmailsCriterion implements EloquentCriterion
{
    private array $eventEmails;

    public function __construct(array $eventEmails)
    {
        $this->eventEmails = $eventEmails;
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->whereIn(
            'invitee_email',
            $this->eventEmails
        );
    }
}
