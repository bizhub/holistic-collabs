<?php

namespace App\Http\Controllers\Admin\Shopify;

use Domain\Shopify\Actions\DisconnectShopifyAction;
use Inertia\Inertia;

class DisconnectShopifyController
{
    public function __invoke(DisconnectShopifyAction $disconnectShopify)
    {
        $disconnectShopify->execute();

        Inertia::flash('success', 'Shopify disconnected');

        return redirect('shopify');
    }
}
