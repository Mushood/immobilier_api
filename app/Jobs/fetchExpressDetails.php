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

    protected $batch;

    public function __construct($batch)
    {
        $this->batch = $batch;
    }

    public function handle(ExpressPropertyScrapper $scrapper)
    {
        $properties = Property::where('done', false)->where('batch', $this->batch)->get();
        foreach ($properties as $property) {
            $scrapper->getPropertyDetails($property);
        }
        Property::where('done', false)->where('batch', $this->batch)->update([
            'batch' => null
        ]);
    }
}
