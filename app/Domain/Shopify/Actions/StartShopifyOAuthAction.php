<?php

namespace Domain\Shopify\Actions;

use Inertia\Inertia;

class StartShopifyOAuthAction
{
    public function execute(string $shopUrl)
    {
        $state = bin2hex(random_bytes(16));
        session(['shopify_oauth_state' => $state]);

        $authUrl = "https://{$shopUrl}/admin/oauth/authorize?" . http_build_query([
            'client_id' => config('services.shopify.client_id'),
            'redirect_uri' => config('services.shopify.callback'),
            'state' => $state,
        ]);

        return Inertia::location($authUrl);
    }
}
