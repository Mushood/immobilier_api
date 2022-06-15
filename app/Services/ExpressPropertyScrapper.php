<?php

namespace App\Services;

use Goutte;
use App\Models\Property;

class ExpressPropertyScrapper implements ScrapperInterface
{
    public function getBaseUrl()
    {
        return 'https://www.lexpressproperty.com/en';
    }

    public function getBuySection()
    {
        return '/buy-mauritius/all';
    }

    public function getTotal()
    {
        $total      = 0;
        $url        = $this->getBaseUrl() . $this->getBuySection();
        $crawler    = Goutte::request('GET', $url);
        $selector   = '#content > div.section-results > div.row.justify-content-between.align-items-center.pb-3 > div.col-8.col-lg-7 > h2';

        $crawler->filter($selector)->each(function ($node) use (&$total) {
            $total = $node->text();
        });

        $total = intval(str_replace(" Properties to discover", "", $total));

        return $total;
    }

    public function getLinkFromList()
    {
        $links      = [];
        $url        = $this->getBaseUrl() . $this->getBuySection();
        $crawler    = Goutte::request('GET', $url);
        $selector   = '#content > div.section-results > div.card-result-gallery';

        $crawler->filter($selector)->each(function ($node) use (&$links) {
            $title  = $node->filter('div > div.column-text.col-md-8 > div > div > div > div.column-left.col-xsm-7 > div.card-top > div > h2')->text();
            $link   = $node->filter('div > div.column-text.col-md-8 > div > div > div > div.column-left.col-xsm-7 > div.card-top > div > h2 > a')->link()->getUri();
            $links[] = Property::create([
                'title' => $title,
                'link'  => $link
            ]);
        });

        return $links;
    }
}
