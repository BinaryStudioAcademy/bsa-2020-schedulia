<?php

declare(strict_types=1);

namespace App\DataTransformer\Events;

use App\Entity\Event;
use Illuminate\Support\Collection;

class EventFlowCollection extends ParameterFlowCollection
{
    public function getCollection(): Collection
    {
        return collect($this->collection)->map(function ($item) {
            return new Event($item['_source']);
        });
    }
}
