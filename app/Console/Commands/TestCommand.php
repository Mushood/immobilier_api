<?php

namespace App\Console\Commands;

use Goutte;
use Illuminate\Console\Command;

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
        $crawler = Goutte::request('GET', 'https://www.lexpressproperty.com/en/buy-mauritius/all/?currency=MUR&filters%5Binterior_unit%5D%5Beq%5D=m2&filters%5Bland_unit%5D%5Beq%5D=m2');
        $crawler->filter('#content > div.section-results > div:nth-child(3) > div > div.column-text.col-md-8 > div > div > div > div.column-left.col-xsm-7 > div.card-top > div > h2')->each(function ($node) {
            dump($node->text());
        });
    }
}
