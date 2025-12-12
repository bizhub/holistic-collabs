<?php

namespace Domain\Shopify\Actions;

use Domain\Shopify\Data\ShopifyOAuthData;
use Domain\Shopify\Enums\ConnectionStatus;
use Domain\Shopify\Settings\ShopifySettings;
use PHPShopify\AuthHelper;
use PHPShopify\ShopifySDK;

class HandleShopifyOAuthCallbackAction
{
    public function __construct(
        protected ShopifySettings $settings,
        protected RecordShopifyActivityAction $recordShopifyActivity,
    ) {}

    public function execute(ShopifyOAuthData $data): void
    {
        $this->verifyState($data);

        ShopifySDK::config([
            'ShopUrl' => $data->shop,
            'ApiKey' => config('services.shopify.client_id'),
            'SharedSecret' => config('services.shopify.client_secret'),
        ]);

        $accessToken = AuthHelper::getAccessToken();

        $this->settings->status = ConnectionStatus::Connected;
        $this->settings->url = $data->shop;
        $this->settings->access_token = $accessToken;

        $this->settings->save();

        $this->recordShopifyActivity->execute('Connect to Shopify store: ' . $data->shop);
    }

    protected function verifyState(ShopifyOAuthData $data): void
    {
        $state = session('shopify_oauth_state');
        if ($state !== $data->state) {
            abort(403, 'Invalid OAuth state');
        }
    }
}
