<?php

namespace App\Console\Commands;

use App\Models\Property;
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
        $properties = Property::all();
        foreach ($properties as $property) {
            $scrapper = new ExpressPropertyScrapper();
            $scrapper->getPropertyDetails($property);
            dump($property->toArray());
        }


        //dd($scrapper->getBuyLinkFromList());

    }
}
