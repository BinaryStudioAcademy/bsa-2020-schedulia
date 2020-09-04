<?php

declare(strict_types=1);

namespace App\Repositories\ElasticSearch\Events\Criterion;

use App\Contracts\ElasticSearchCriterion;

final class SearchStringCriterion implements ElasticSearchCriterion
{
    public static function getCriteria($searchString): array
    {
        return [
            'query_string' => [
                'fields' => ['invitee_name^2','event_type_tags'],
                'query' => '*' . $searchString . '*',
            ]
        ];
    }
}
