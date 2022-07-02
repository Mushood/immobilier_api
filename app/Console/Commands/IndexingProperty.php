<?php

namespace App\Console\Commands;

use App\Jobs\fetchExpressLinks;
use App\Jobs\IndexProperty;
use App\Models\Property;
use App\Services\ExpressPropertyScrapper;
use Illuminate\Console\Command;

class IndexingProperty extends Command
{
    const AMOUNT = 100;
    protected $signature    = 'indexing:property';
    protected $description  = 'Command description';

    public function handle(ExpressPropertyScrapper $scrapper)
    {
        $count = Property::where('done', true)->orderBy('id', 'ASC')->count();

        for ($i = 0; $i < ceil($count/self::AMOUNT);$i++) {
            Property::where('done', true)->skip($i * self::AMOUNT)->limit(self::AMOUNT)->update([
                'batch' => $i
            ]);
            dispatch(new IndexProperty($i));
        }
    }
}
