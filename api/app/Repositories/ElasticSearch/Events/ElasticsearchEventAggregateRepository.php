<?php

declare(strict_types=1);

namespace App\Repositories\ElasticSearch\Events;

use App\Aggregates\Events\EventAggregate;
use App\Repositories\BaseRepository;

final class ElasticsearchEventAggregateRepository extends BaseRepository implements EventAggregateRepositoryInterface
{
    public const INDEX_NAME = 'events';

    public function save(EventAggregate $eventAggregate): EventAggregate
    {
        $data = [
            'index' => self::INDEX_NAME,
            'id' => $eventAggregate->getId(),
            'type' => '_doc',
            'body' => $eventAggregate->toArray()
        ];

        \Elasticsearch::index($data);

        return $eventAggregate;
    }
}
