<?php

declare(strict_types=1);

namespace App\Repositories\Availability\Criterion;

class BaseAvailabilityCriterion
{
    protected int $eventTypeId;
    protected string $type;

    public function __construct(int $eventTypeId, string $type = '')
    {
        $this->eventTypeId = $eventTypeId;
        $this->type = $type;
    }
}
