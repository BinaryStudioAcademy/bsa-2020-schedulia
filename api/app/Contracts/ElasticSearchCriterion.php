<?php

declare(strict_types=1);

namespace App\Contracts;

interface ElasticSearchCriterion
{
    public static function getCriteria($criterion): array;
}
