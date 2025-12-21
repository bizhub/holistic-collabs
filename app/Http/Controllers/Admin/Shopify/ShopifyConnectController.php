<?php

namespace App\Http\Controllers\Admin\Shopify;

use Inertia\Inertia;

class ShopifyConnectController
{
    public function __invoke()
    {
        return Inertia::render('Admin/Shopify/ConnectForm');
    }
}
