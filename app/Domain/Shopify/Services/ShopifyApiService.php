<?php

namespace Domain\Shopify\Services;

use PHPShopify\ShopifySDK;
use Domain\Shopify\Models\ShopifyConnection;

class ShopifyApiService
{
    protected ShopifySDK $client;

    public function setConnection(ShopifyConnection $connection): self
    {
        $this->client = new ShopifySDK([
            'ShopUrl'     => $connection->url,
            'AccessToken' => $connection->access_token,
        ]);

        return $this;
    }

    public function getClient(): ShopifySDK
    {
        return $this->client;
    }

    public function post(string $endpoint, array $data)
    {
        return $this->client->$endpoint->post($data);
    }

    public function get(string $endpoint, array $params = [])
    {
        return $this->client->$endpoint->get($params);
    }
}
