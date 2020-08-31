<?php

namespace App\Repositories\ElasticSearch\Events;

use App\Aggregates\Events\EventAggregate;

interface EventAggregateRepositoryInterface
{
    public function save(EventAggregate $eventAggregate): EventAggregate;
}
