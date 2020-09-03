<?php

namespace App\Repositories\ElasticSearch\Events;

use App\Aggregates\Events\EventAggregate;
use Illuminate\Pagination\LengthAwarePaginator;

interface EventAggregateRepositoryInterface
{
    public function save(EventAggregate $eventAggregate): EventAggregate;
    public function search (
        array $criteria,
        int $page,
        int $perPage,
        string $sort,
        string $direction): LengthAwarePaginator;
}
