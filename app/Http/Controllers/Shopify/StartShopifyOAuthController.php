<?php

namespace App\Http\Controllers\Shopify;

use Domain\Shopify\Actions\StartShopifyOAuthAction;
use Illuminate\Http\Request;

class StartShopifyOAuthController
{
    public function __invoke(
        Request $request,
        StartShopifyOAuthAction $startShopifyOAuthAction,
    ) {
        return $startShopifyOAuthAction->execute(
            shopUrl: $request->url,
        );
    }
}
