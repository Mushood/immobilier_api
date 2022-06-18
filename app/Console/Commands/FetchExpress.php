<?php

namespace App\Console\Commands;

use App\Jobs\fetchExpressLinks;
use App\Services\ExpressPropertyScrapper;
use Illuminate\Console\Command;

class FetchExpress extends Command
{
    protected $signature    = 'fetch:express';
    protected $description  = 'Command description';

    public function handle(ExpressPropertyScrapper $scrapper)
    {
        $pagination = $scrapper->getPagination();
        $pagination['total'] = $scrapper->getTotal();

        $iterations = ceil($pagination['total'] / $pagination['limit']);
        for($i = 0; $i < $iterations; $i++) {
            dispatch(new fetchExpressLinks($i));
        }
    }
}
