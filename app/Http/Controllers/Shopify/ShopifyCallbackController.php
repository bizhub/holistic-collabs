<?php

namespace App\Http\Controllers\Shopify;

use Domain\Shopify\Actions\HandleShopifyOAuthCallbackAction;
use Domain\Shopify\Data\ShopifyOAuthData;
use Illuminate\Http\Request;

class ShopifyCallbackController
{
    public function __invoke(
        Request $request,
        HandleShopifyOAuthCallbackAction $handleShopifyOAuthCallbackAction,
    ) {
        $data = new ShopifyOAuthData(
            shop: $request->query('shop'),
            state: $request->query('state'),
        );

        $handleShopifyOAuthCallbackAction->execute($data);

        return redirect('shopify');
    }
}
