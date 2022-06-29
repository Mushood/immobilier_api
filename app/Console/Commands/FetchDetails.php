<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;
use App\Jobs\fetchExpressDetails;

class FetchDetails extends Command
{
    const AMOUNT = 10;

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
        $total = Property::where('done', false)->count();

        for ($i = 0; $i < ceil($total / self::AMOUNT); $i++) {
            Property::where('done', false)->offset($i * self::AMOUNT)->limit(self::AMOUNT)->update([
                'batch' => $i
            ]);
            dispatch(new fetchExpressDetails($i));
        }
    }
}
