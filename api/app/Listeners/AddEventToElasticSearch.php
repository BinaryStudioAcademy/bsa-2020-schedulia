<?php

namespace App\Listeners;

use App\Aggregates\Events\EventAggregate;
use App\Events\EventCreated;
use App\Repositories\ElasticSearch\Events\ElasticsearchEventAggregateRepository;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddEventToElasticSearch implements ShouldQueue
{
    private ElasticsearchEventAggregateRepository $elasticsearchEventAggregateRepository;

    public function __construct(ElasticsearchEventAggregateRepository $elasticsearchEventAggregateRepository)
    {
        $this->elasticsearchEventAggregateRepository = $elasticsearchEventAggregateRepository;
    }

    public function handle(EventCreated $eventCreated): void
    {
        $eventAggregate = new EventAggregate($eventCreated->getEvent());

        $this->elasticsearchEventAggregateRepository->index($eventAggregate);
    }
}
