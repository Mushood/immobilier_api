<?php

namespace App\Jobs;

use App\Models\Property;
use App\Services\ExpressPropertyScrapper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class fetchExpressDetails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle(ExpressPropertyScrapper $scrapper)
    {
        $property = Property::find($this->id);
        $scrapper->getPropertyDetails($property);
    }
}
