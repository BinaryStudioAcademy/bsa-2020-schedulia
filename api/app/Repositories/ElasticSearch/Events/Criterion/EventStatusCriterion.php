<?php

declare(strict_types=1);

namespace App\Repositories\ElasticSearch\Events\Criterion;

use App\Contracts\ElasticSearchCriterion;

final class EventStatusCriterion implements ElasticSearchCriterion
{
    public static function getCriteria($eventStatus): array
    {
        return [
            'terms' => [
                'status' => $eventStatus
            ]
        ];
    }
}
