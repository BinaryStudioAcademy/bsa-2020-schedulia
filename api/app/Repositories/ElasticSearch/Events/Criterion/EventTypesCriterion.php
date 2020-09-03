<?php

declare(strict_types=1);

namespace App\Repositories\ElasticSearch\Events\Criterion;

use App\Contracts\ElasticSearchCriterion;

final class EventTypesCriterion implements ElasticSearchCriterion
{
    public static function getCriteria($eventTypes): array
    {
        return [
            'terms' => [
                'event_type_id' => $eventTypes
            ]
        ];
    }
}
