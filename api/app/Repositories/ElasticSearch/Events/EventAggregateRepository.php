<?php

namespace App\Repositories\ElasticSearch\Events;

use App\Aggregates\Events\EventAggregate;

interface EventAggregateRepository
{
    public function index(EventAggregate $eventAggregate): void;
    public function search(array $data): Object;
    public function update(array $data): void;
    public function delete(array $data): void;
}
