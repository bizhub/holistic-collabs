<?php

namespace App\Http\Controllers\Admin\Shopify;

use Domain\Shopify\Actions\HandleShopifyOAuthCallbackAction;
use Domain\Shopify\Data\ShopifyOAuthData;
use Illuminate\Http\Request;

class ShopifyCallbackController
{
    public function __invoke(
        Request $request,
        HandleShopifyOAuthCallbackAction $handleShopifyOAuthCallbackAction,
    ) {
        $data = ShopifyOAuthData::from($request->all());

        $handleShopifyOAuthCallbackAction->execute($data);

        return redirect('shopify');
    }
}
