<?php

namespace App\Console\Commands;

use Elasticsearch;
use Illuminate\Console\Command;
use App\Services\ExpressPropertyScrapper;

class MappingProperty extends Command
{
    const INDEX = 'property';

    protected $signature    = 'mapping:property';
    protected $description  = 'Command description';

    public function handle(ExpressPropertyScrapper $scrapper)
    {
        $mapping['index'] = self::INDEX;

        $properties = [
            'id' => [
                'type' => 'integer'
            ],
            'category' => [
                'type' => 'keyword'
            ],
            'location' => [
                'type' => 'keyword'
            ],
            'region' => [
                'type' => 'keyword'
            ],
            'type' => [
                'type' => 'keyword'
            ],
            'purchasing_type' => [
                'type' => 'keyword'
            ],
            'surface_area' => [
                'type' => 'integer'
            ],
            'surface_area_land' => [
                'type' => 'integer'
            ],
            'surface_area_interior' => [
                'type' => 'integer'
            ],
            'bedrooms' => [
                'type' => 'integer'
            ],
            'bathrooms' => [
                'type' => 'integer'
            ],
            'toilets' => [
                'type' => 'integer'
            ]
        ];

        $mapping['body'] = array(
            'mappings' => array(
                'properties' => $properties
            )
        );

        Elasticsearch::indices()->create($mapping);
    }
}
