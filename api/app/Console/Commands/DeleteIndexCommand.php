<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elasticksearch:deleteIndex {index}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Index from Elasticksearch index';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $index = $this->argument('index');

        $this->info('Delete Elasticksearch " ' . $index . ' " index. This might take a while...');

        $params = [
            'index' => $index
        ];

        \Elasticsearch::Indices()->Delete($params);

        $this->info('Done!');
    }
}
