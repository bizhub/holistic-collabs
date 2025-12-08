<?php

namespace App\Http\Controllers\Shopify;

use Inertia\Inertia;

class ShopifyConnectController
{
    public function __invoke()
    {
        return Inertia::render('Shopify/ConnectForm');
    }
}
