<?php

namespace App\Jobs;

use App\Services\ExpressPropertyScrapper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class fetchExpressLinks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $page;

    public function __construct($iteration)
    {
        $this->page = $iteration + 1;
    }

    public function handle(ExpressPropertyScrapper $scrapper)
    {
        $scrapper->getBuyLinkFromList($this->page);
    }
}
