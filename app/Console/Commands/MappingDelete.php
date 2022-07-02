<?php

namespace App\Console\Commands;

use Elasticsearch;
use Illuminate\Console\Command;

class MappingDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mapping:delete {index}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Mapping';

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
        
        $deleteParams = [
            'index' => $index
        ];

        Elasticsearch::indices()->delete($deleteParams);
    }
}
