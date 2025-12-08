<?php

namespace Domain\Shopify\Services;

use PHPShopify\ShopifySDK;
use Domain\Shopify\Settings\ShopifySettings;
use Domain\Shopify\Enums\ConnectionStatus;

class ShopifyApiService
{
    protected ?ShopifySDK $client = null;

    public function __construct(protected ShopifySettings $settings)
    {
        if ($settings->status === ConnectionStatus::Connected) {
            $this->client = new ShopifySDK([
                'ShopUrl'     => $settings->store_domain,
                'AccessToken' => $settings->access_token,
            ]);
        }
    }

    public function getClient(): ShopifySDK
    {
        if (!$this->client) {
            throw new \RuntimeException('Shopify integration is not connected.');
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
