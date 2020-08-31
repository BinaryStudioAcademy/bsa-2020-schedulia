<?php

namespace App\Listeners;

use App\Aggregates\Events\EventAggregate;
use App\Events\EventCreated;
use App\Repositories\ElasticSearch\Events\EventAggregateRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddEventToElasticSearch implements ShouldQueue
{
    private EventAggregateRepositoryInterface $elasticsearchEventAggregateRepository;

    public function __construct(EventAggregateRepositoryInterface $elasticsearchEventAggregateRepository)
    {
        $this->elasticsearchEventAggregateRepository = $elasticsearchEventAggregateRepository;
    }

    public function handle(EventCreated $eventCreated): void
    {
        $eventAggregate = new EventAggregate($eventCreated->getEvent());

        $this->elasticsearchEventAggregateRepository->save($eventAggregate);
    }
}
