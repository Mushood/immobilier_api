<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;
use App\Services\ExpressPropertyScrapper;
use Illuminate\Support\Facades\DB;

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
        dump(Property::count());
        $total = DB::table('jobs')->count();
        dd($total);
    }
}
