<?php

namespace App\Jobs;

use App\Console\Commands\MappingProperty;
use App\Models\Property;
use App\Services\ExpressPropertyScrapper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IndexProperty implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $batch;

    public function __construct($batch)
    {
        $this->batch = $batch;
    }

    public function handle(ExpressPropertyScrapper $scrapper)
    {
        $properties = Property::where('batch', $this->batch)
            ->orderBy('id', 'ASC')
            ->get()
        ;

        foreach ($properties as $key => $property) {
            $params['body'][] = array(
                'index' => array(
                    '_index' => MappingProperty::INDEX,
                    '_id' => 'property_' . $property->id
                )
            );

            $body = [
                'id'                    => $property->id,
                'category'              => $property->category,
                'location'              => $property->location,
                'region'                => $property->region,
                'type'                  => $property->type,
                'purchasing_type'       => $property->id,
                'surface_area'          => $property->surface_area,
                'surface_area_land'     => $property->surface_area_land,
                'surface_area_interior' => $property->surface_area_interior,
                'bedrooms'              => $property->bedrooms,
                'bathrooms'             => $property->bathrooms,
                'toilets'               => $property->toilets
            ];

            $params['body'][] = $body;
        }

        $return = Elasticsearch::bulk($params);

        if ($return['errors']) {
            throw new \Exception(json_encode($return['items']));
        }
    }
}
