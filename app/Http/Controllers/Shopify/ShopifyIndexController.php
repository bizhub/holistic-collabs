<?php

namespace App\Http\Controllers\Shopify;

use Domain\Shopify\Data\ShopifyActivityData;
use Domain\Shopify\Data\ShopifyData;
use Domain\Shopify\Models\ShopifyActivity;
use Domain\Shopify\Settings\ShopifySettings;
use Inertia\Inertia;

class ShopifyIndexController
{
    public function __invoke(ShopifySettings $shopify)
    {
        $shopifyActivity = ShopifyActivity::query()
            ->orderByDesc('created_at')
            ->get();

        return Inertia::render('Shopify/Shopify', [
            'shopify' => ShopifyData::from($shopify),
            'activity' => ShopifyActivityData::collect($shopifyActivity),
        ]);
    }
}
