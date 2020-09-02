<?php

declare(strict_types=1);

namespace App\Repositories\ElasticSearch\Events\Criterion;

use App\Contracts\ElasticSearchCriterion;

final class StartDateCriterion implements ElasticSearchCriterion
{
    public static function getCriteria($startDate): array
    {
        return [
            'range' => [
                'start_date_timestamp' => [
                    'gte' => $startDate,
                ]
            ]
        ];
    }
}
