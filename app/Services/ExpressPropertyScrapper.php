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

    public function getPagination()
    {
        return [
            'page'  => 1,
            'limit' => 15,
            'total' => 0
        ];
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

    public function getBuyLinkFromList($page)
    {
        $links      = [];
        $url        = $this->getBaseUrl() . $this->getBuySection() . '/?p=' . $page;
        $crawler    = Goutte::request('GET', $url);
        $selector   = '#content > div.section-results > div.card-result-gallery';

        $crawler->filter($selector)->each(function ($node) use (&$links) {
            $title  = $node->filter('div > div.column-text.col-md-8 > div > div > div > div.column-left.col-xsm-7 > div.card-top > div > h2')->text();
            $link   = $node->filter('div > div.column-text.col-md-8 > div > div > div > div.column-left.col-xsm-7 > div.card-top > div > h2 > a')->link()->getUri();

            $exists = Property::where('link', $link)->exists();
            if (!$exists) {
                $links[] = Property::create([
                    'title' => $title,
                    'link'  => $link
                ]);
            }
        });

        return $links;
    }

    public function getPropertyDetails($property)
    {
        $crawler    = Goutte::request('GET', $property->link);
        $selector   = '#content';

        $crawler->filter($selector)->each(function ($node) use (&$property) {
            $location           = null;
            $region             = null;
            $purchasingType     = null;
            $landSurface        = null;
            $interiorSurface    = null;

            try {
                $address    = $node->filter('div > div > div.card-description > div > div.col-md-7.col-lg-7 > address')->text();
                if (isset($address)) {
                    $addressParts = explode(',', $address);
                    $location = $addressParts[0];
                    if (count($addressParts) > 1) {
                        $region = $addressParts[1];
                    }
                }
            } catch (\Exception $e) {

            }

            try {
                $price  = $node->filter('div > div > div.card-description > div > div.col-md-5.col-lg-5 > div > div.col-xsm-6.col-md-12 > div > strong')->text();
                $price  = str_replace("Rs ", "", $price);
                $price  = str_replace(",", "", $price);
            } catch (\Exception $e) {

            }

            if (strpos($property->link, "buy") !== false) {
                $purchasingType = Property::TYPE_PURCHASING_BUY;
            }

            try {
                $landSurface  = $node->filter('div > div > div:nth-child(3) > div > div > div:nth-child(1) > div > div:nth-child(1) > div > dl > dd:nth-child(2)')->text();
                $landSurface  = str_replace(" m²", "", $landSurface);
            } catch (\Exception $e) {

            }

            try {
                $interiorSurface  = $node->filter('div > div > div:nth-child(3) > div > div > div:nth-child(1) > div > div:nth-child(1) > div > dl > dd:nth-child(4)')->text();
                $interiorSurface  = str_replace(" m²", "", $interiorSurface);
            } catch (\Exception $e) {

            }

            try {
                $bedrooms = $node->filter('div > div > div:nth-child(3) > div > div > div:nth-child(2) > div > div:nth-child(1) > div > dl > dd:nth-child(2)')->text();
            } catch (\Exception $e) {

            }

            $property->update([
                'location'              => trim($location),
                'region'                => trim($region),
                'price'                 => intval($price),
                'purchasing_type'       => $purchasingType,
                'surface_area_land'     => intval($landSurface),
                'surface_area_interior' => intval($interiorSurface),
                'surface_area'          => $landSurface !== null ? intval($landSurface) : intval($interiorSurface),
                'bedrooms'              => intval($bedrooms),
                'done'                  => true,
                'batch'                 => null
            ]);
        });

    }
}
