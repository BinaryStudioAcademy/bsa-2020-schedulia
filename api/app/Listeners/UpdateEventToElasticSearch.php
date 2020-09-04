<?php

namespace App\Listeners;

use App\Aggregates\Events\EventAggregate;
use App\Events\EventUpdated;
use App\Repositories\ElasticSearch\Events\EventAggregateRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateEventToElasticSearch implements ShouldQueue
{
    private EventAggregateRepositoryInterface $elasticsearchEventAggregateRepository;

    public function __construct(EventAggregateRepositoryInterface $elasticsearchEventAggregateRepository)
    {
        $this->elasticsearchEventAggregateRepository = $elasticsearchEventAggregateRepository;
    }

    public function handle(EventUpdated $eventUpdated): void
    {
        $eventAggregate = new EventAggregate($eventUpdated->getEvent());

        $this->elasticsearchEventAggregateRepository->save($eventAggregate);
    }
}
