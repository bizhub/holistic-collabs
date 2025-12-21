<?php

namespace App\Http\Controllers\Admin\Shopify;

use Domain\Shopify\Actions\StartShopifyOAuthAction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StartShopifyOAuthController
{
    public function __invoke(
        Request $request,
        StartShopifyOAuthAction $startShopifyOAuthAction,
    ) {
        $authUrl = $startShopifyOAuthAction->execute(
            shopUrl: $request->url,
        );

        return Inertia::location($authUrl);
    }
}
