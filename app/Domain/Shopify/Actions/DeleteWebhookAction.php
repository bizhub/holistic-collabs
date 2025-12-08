<?php

namespace Domain\Shopify\Actions;

use Domain\Shopify\Services\ShopifyApiService;

class DeleteWebhookAction
{
    public function __construct(
        protected ShopifyApiService $api,
    ) {}

    public function execute(string $webhookId): void
    {
        $this->api->getClient()->Webhook($webhookId)->delete();
    }
}
