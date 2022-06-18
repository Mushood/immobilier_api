<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;
use App\Jobs\fetchExpressDetails;

class FetchDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:details';

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
        $properties = Property::where('done', false)->limit(1000)->get('id');

        foreach ($properties as $key => $property) {
            dispatch(new fetchExpressDetails($property->id));
            if ($key > 1000) {
                break;
            }
        }
    }
}
