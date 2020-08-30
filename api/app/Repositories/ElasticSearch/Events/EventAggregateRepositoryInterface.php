<?php

namespace App\Repositories\ElasticSearch\Events;

use App\Aggregates\Events\EventAggregate;

interface EventAggregateRepositoryInterface
{
    public function save(EventAggregate $eventAggregate): EventAggregate;
    public function search(array $data): Object;
    public function update(array $data): void;
    public function delete(array $data): void;
}
