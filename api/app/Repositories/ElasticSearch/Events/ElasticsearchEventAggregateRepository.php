<?php

declare(strict_types=1);

namespace App\Repositories\ElasticSearch\Events;

use App\Aggregates\Events\EventAggregate;
use App\Repositories\BaseRepository;

final class ElasticsearchEventAggregateRepository extends BaseRepository implements EventAggregateRepository
{
    const INDEX_NAME = 'events-index';

    public function index(EventAggregate $eventAggregate): void
    {
        $data = [
            'index' => self::INDEX_NAME,
            'id' => $eventAggregate->getId(),
            'type' => '_doc',
            'body' => $eventAggregate->toArray()
        ];

        \Elasticsearch::index($data);
    }

    public function update(array $data): void
    {
        \Elasticsearch::update($data);
    }

    public function delete(array $data): void
    {
        \Elasticsearch::delete($data);
    }

    public function search(array $data): object
    {
        return \Elasticsearch::search($data);
    }
}
