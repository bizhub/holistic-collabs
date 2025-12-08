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
            code: $request->query('code'),
            state: $request->query('state'),
            hmac: $request->query('hmac'),
        );

        $handleShopifyOAuthCallbackAction->execute($data);

        return redirect('integrations');
    }
}
