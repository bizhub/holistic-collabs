<?php

namespace App\Http\Controllers\Admin\Shopify;

use Domain\Shopify\Actions\GetWebhookStatusAction;
use Domain\Shopify\Data\ShopifyActivityData;
use Domain\Shopify\Data\ShopifyData;
use Domain\Shopify\Models\ShopifyActivity;
use Domain\Shopify\Settings\ShopifySettings;
use Inertia\Inertia;

class ShopifyIndexController
{
    public function __invoke(
        ShopifySettings $shopify,
        GetWebhookStatusAction $getWebhookStatus,
    ) {
        $shopifyActivity = ShopifyActivity::query()
            ->orderByDesc('created_at')
            ->get();

        return Inertia::render('Admin/Shopify/Shopify', [
            'shopify' => ShopifyData::from($shopify),
            'activity' => ShopifyActivityData::collect($shopifyActivity),
            'webhook_status' => $getWebhookStatus->execute(),
        ]);
    }
}
