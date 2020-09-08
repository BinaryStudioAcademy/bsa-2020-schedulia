<?php

declare(strict_types=1);

namespace App\Repositories\ElasticSearch\Events\Criterion;

use App\Contracts\ElasticSearchCriterion;

final class TagsCriterion implements ElasticSearchCriterion
{
    public static function getCriteria($eventTags): array
    {
        return [
            'match' => [
                'event_type_tags.name' => $eventTags
            ]
        ];
    }
}
