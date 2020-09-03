<?php

declare(strict_types=1);

namespace App\Repositories\ElasticSearch\Events\Criterion;

use App\Contracts\ElasticSearchCriterion;

final class EventEmailsCriterion implements ElasticSearchCriterion
{
    public static function getCriteria($eventEmails): array
    {
        return [
            'terms' => [
                'invitee_email' => $eventEmails
            ]
        ];
    }
}
