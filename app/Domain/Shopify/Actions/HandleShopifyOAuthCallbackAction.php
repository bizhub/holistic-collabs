<?php

namespace Domain\Shopify\Actions;

use Domain\Shopify\Data\ShopifyOAuthData;
use Domain\Shopify\Enums\ConnectionStatus;
use Domain\Shopify\Models\ShopifyConnection;
use PHPShopify\AuthHelper;

class HandleShopifyOAuthCallbackAction
{
    public function execute(ShopifyOAuthData $data): ShopifyConnection
    {
        $this->verifyState($data);

        $helper = new AuthHelper([
            'ShopUrl'     => $data->shop,
            'ApiKey'      => config('services.shopify.client_id'),
            'ApiSecret'   => config('services.shopify.client_secret'),
            'RedirectUrl' => config('services.shopify.callback'),
        ]);

        $tokenData = $helper->getAccessToken($data->code);

        return ShopifyConnection::updateOrCreate([
            'url' => $data->shop,
        ], [
            'status'       => ConnectionStatus::Active,
            'access_token' => $tokenData['access_token'],
            'scope'        => $tokenData['scope'] ?? null,
        ]);
    }

    protected function verifyState(ShopifyOAuthData $data): void
    {
        $state = session('shopify_oauth_state');
        if ($state !== $data->state) {
            abort(403, 'Invalid OAuth state');
        }
    }
}
