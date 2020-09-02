<?php

declare(strict_types=1);

namespace App\Repositories\ElasticSearch\Events\Criterion;

use App\Contracts\ElasticSearchCriterion;

final class EndDateCriterion implements ElasticSearchCriterion
{
    public static function getCriteria($endDate): array
    {
        return [
            'range' => [
                'start_date_timestamp' => [
                    'lt' => $endDate,
                ]
            ]
        ];
    }
}
