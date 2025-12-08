<?php

namespace Domain\Shopify\Actions;

use Domain\Shopify\Data\ShopifyOAuthData;
use Domain\Shopify\Enums\ConnectionStatus;
use Domain\Shopify\Settings\ShopifySettings;
use PHPShopify\AuthHelper;

class HandleShopifyOAuthCallbackAction
{
    public function execute(ShopifyOAuthData $data): ShopifySettings
    {
        $this->verifyState($data);

        $helper = new AuthHelper([
            'ShopUrl'     => $data->shop,
            'ApiKey'      => config('services.shopify.client_id'),
            'ApiSecret'   => config('services.shopify.client_secret'),
            'RedirectUrl' => config('services.shopify.callback'),
        ]);

        $tokenData = $helper->getAccessToken($data->code);

        $settings = resolve(ShopifySettings::class);

        $settings->status       = ConnectionStatus::Connected;
        $settings->store_domain = $data->shop;
        $settings->access_token = $tokenData['access_token'];
        $settings->scopes       = $tokenData['scope'] ?? null;

        $settings->save();

        return $settings;
    }

    protected function verifyState(ShopifyOAuthData $data): void
    {
        $state = session('shopify_oauth_state');
        if ($state !== $data->state) {
            abort(403, 'Invalid OAuth state');
        }
    }
}
