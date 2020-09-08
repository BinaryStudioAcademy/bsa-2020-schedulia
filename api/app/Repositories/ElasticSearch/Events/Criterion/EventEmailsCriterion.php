<?php

declare(strict_types=1);

namespace App\Repositories\ElasticSearch\Events\Criterion;

use App\Contracts\ElasticSearchCriterion;

final class EventEmailsCriterion implements ElasticSearchCriterion
{
    public static function getCriteria($eventEmails): array
    {
        foreach ($eventEmails as $email) {
            $criteria[] = [
                'match_phrase' => [
                    'invitee_email' => $email
                ]
            ];
        }

        return [
            'bool' => [
                'should' => $criteria
            ]
        ];
    }
}
