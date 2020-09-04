<?php

namespace App\Console\Commands;

use App\Repositories\ElasticSearch\Events\EventAggregateRepositoryInterface;
use Illuminate\Console\Command;

class DeleteIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elasticksearch:deleteIndex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Index from Elasticksearch index';

    private EventAggregateRepositoryInterface $elasticsearchEventAggregateRepository;
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
        $this->info('Delete Elasticksearch index. This might take a while...');

        $this->elasticsearchEventAggregateRepository->deleteIndex();

        $this->info('Done!');
    }
}
