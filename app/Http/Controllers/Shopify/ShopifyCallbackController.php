<?php

namespace App\Http\Controllers\Shopify;

use Domain\Shopify\Actions\HandleShopifyOAuthCallbackAction;
use Illuminate\Http\Request;

class ShopifyCallbackController
{
    public function __invoke(
        Request $request,
        HandleShopifyOAuthCallbackAction $handleShopifyOAuthCallbackAction,
    ) {
        $handleShopifyOAuthCallbackAction->execute($request);

        return redirect('integrations')->with('flash', [
            'message' => 'Shopify connected successfully.',
            'description' => 'Your store is now linked and ready to sync products and orders.',
            'type' => 'success',
        ]);
    }
}
