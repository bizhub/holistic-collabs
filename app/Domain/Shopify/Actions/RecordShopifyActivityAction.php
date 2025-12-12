<?php

namespace Domain\Shopify\Actions;

use Domain\Shopify\Models\ShopifyActivity;

class RecordShopifyActivityAction
{
    public function execute(string $description): ShopifyActivity
    {
        return ShopifyActivity::create([
            'description' => $description,
        ]);
    }
}
