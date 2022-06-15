<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ExpressPropertyScrapper;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:me';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $scrapper = new ExpressPropertyScrapper();
        dd($scrapper->getLinkFromList());
    }
}
