<?php

namespace App\Http\Controllers\Shopify;

use Domain\Shopify\Data\ShopifyData;
use Domain\Shopify\Settings\ShopifySettings;
use Inertia\Inertia;

class ShopifyIndexController
{
    public function __invoke(ShopifySettings $shopify)
    {
        return Inertia::render('Shopify/Shopify', [
            'shopify' => ShopifyData::from($shopify),
        ]);
    }
}
