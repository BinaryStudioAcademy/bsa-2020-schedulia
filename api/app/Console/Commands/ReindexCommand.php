<?php

namespace App\Console\Commands;

use App\Aggregates\Events\EventAggregate;
use App\Entity\Event;
use App\Repositories\ElasticSearch\Events\EventAggregateRepositoryInterface;
use Illuminate\Console\Command;

class ReindexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elasticksearch:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all events to Elasticsearch';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(EventAggregateRepositoryInterface $elasticsearchEventAggregateRepository)
    {
        parent::__construct();
        $this->elasticsearchEventAggregateRepository = $elasticsearchEventAggregateRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Indexing all events. This might take a while...');

        foreach (Event::cursor() as $event) {
            $eventAggregate = new EventAggregate($event);

            $this->elasticsearchEventAggregateRepository->save($eventAggregate);

            $this->output->write('.');
        }

        $this->info('Done!');
    }
}
