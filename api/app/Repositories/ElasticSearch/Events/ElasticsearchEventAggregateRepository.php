<?php

declare(strict_types=1);

namespace App\Repositories\ElasticSearch\Events;

use App\Aggregates\Events\EventAggregate;
use App\Repositories\BaseRepository;

final class ElasticsearchEventAggregateRepository extends BaseRepository implements EventAggregateRepositoryInterface
{
    public const INDEX_NAME = 'events';
    public const TYPE = '_doc';

    public function save(EventAggregate $eventAggregate): EventAggregate
    {
        $data = [
            'index' => self::INDEX_NAME,
            'id' => $eventAggregate->getId(),
            'type' => self::TYPE,
            'body' => $eventAggregate->toArray()
        ];

        \Elasticsearch::index($data);

        return $eventAggregate;
    }

    public function search()
    {
        return \Elasticsearch::search([
                                          'index' => self::INDEX_NAME,
                                          'type' => self::TYPE,
                                          'body' => [
                                              'query' => [
                                                  'bool' => [
                                                      'must' => [
                                                          [
                                                              'terms' => [
                                                                  'event_type_id' => implode(array(2, 5))
                                                              ]
                                                          ],
                                                          [
                                                              'terms' => [
                                                                  'event_type_owner_id' => 1
                                                              ]
                                                          ],
                                                      ]
                                                  ]
                                              ],
                                          ]
        ]);
    }
}
