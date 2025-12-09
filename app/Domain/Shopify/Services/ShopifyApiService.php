<?php

namespace Domain\Shopify\Services;

use PHPShopify\ShopifySDK;
use Domain\Shopify\Settings\ShopifySettings;
use Domain\Shopify\Enums\ConnectionStatus;
use Domain\Shopify\Exceptions\ShopifyNotConnectedException;

class ShopifyApiService
{
    protected ?ShopifySDK $client = null;

    public function __construct(protected ShopifySettings $settings)
    {
        if ($settings->status === ConnectionStatus::Connected) {
            $this->client = new ShopifySDK([
                'ShopUrl' => $settings->url,
                'AccessToken' => $settings->access_token,
            ]);
        }
    }

    public function getClient(): ShopifySDK
    {
        if (!$this->client) {
            throw new ShopifyNotConnectedException;
        }

        return $this->client;
    }

    public function post(string $endpoint, array $data)
    {
        return $this->getClient()->$endpoint->post($data);
    }

    public function get(string $endpoint, array $params = [])
    {
        return $this->getClient()->$endpoint->get($params);
    }
}
