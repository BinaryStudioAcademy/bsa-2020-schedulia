<?php

declare(strict_types=1);

namespace App\Repositories\ElasticSearch\Events\Criterion;

use App\Contracts\ElasticSearchCriterion;

final class OwnerCriterion implements ElasticSearchCriterion
{
    public static function getCriteria($ownerId): array
    {
        return [
            'term' => [
                'event_type_owner_id' => $ownerId
            ]
        ];
    }
}
