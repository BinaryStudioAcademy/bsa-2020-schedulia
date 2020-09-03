<?php

declare(strict_types=1);

namespace App\Repositories\ElasticSearch\Events;

use App\Aggregates\Events\EventAggregate;
use App\DataTransformer\Events\EventFlowCollection;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

final class ElasticsearchEventAggregateRepository extends BaseRepository implements EventAggregateRepositoryInterface
{
    public const INDEX_NAME = 'events';
    public const TYPE = '_doc';
    public const DEFAULT_PAGE = 1;
    public const DEFAULT_PER_PAGE = 8;
    public const DEFAULT_SORT = 'start_date';
    public const DEFAULT_DIRECTION = 'ASC';

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

    public function search(
        array $criteria,
        int $page = self::DEFAULT_PAGE,
        int $perPage = self::DEFAULT_PER_PAGE,
        string $sort = self::DEFAULT_SORT,
        string $direction = self::DEFAULT_DIRECTION
    ): LengthAwarePaginator {
        $response = \Elasticsearch::search([
            'index' => self::INDEX_NAME,
            'type' => self::TYPE,
            'size' => $perPage,
            'from' => $perPage*($page-1),
            'body' => [
                'sort' => [
                    $sort => [
                        'order' => $direction
                    ]
                ],
                'query' => [
                    'bool' => [
                        'must' => $criteria
                    ]
                ],
            ]
        ]);

        $eventFlow = new EventFlowCollection($response['hits']['hits']);

        return new LengthAwarePaginator(
            $eventFlow->getCollection(),
            $response['hits']['total']['value'],
            $perPage
        );
    }
}
