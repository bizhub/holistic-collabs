<?php

namespace Domain\Shopify\Actions;

use Domain\Shopify\Models\ShopifyConnection;
use Domain\Shopify\Services\ShopifyApiService;

class DeleteWebhookAction
{
    public function __construct(
        protected ShopifyApiService $api
    ) {}

    public function execute(ShopifyConnection $connection, string $webhookId): void
    {
        $this->api->setConnection($connection);

        $this->api->getClient()->Webhook($webhookId)->delete();
    }
}
