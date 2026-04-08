<?php

namespace Domain\Shopify\Actions;

use Domain\Shopify\Data\OrderCreatedWebhookData;
use Domain\Shopify\Services\ShopifyApiService;

class ImportOrderAction
{
    public function __construct(
        protected ShopifyApiService $api,
        protected HandleOrderCreatedWebhookAction $handleOrderCreatedWebhook,
    ) {}

    public function execute(string $shopifyOrderId)
    {
        $order = $this->api->getClient()->Order((string)$shopifyOrderId)->get();

        $data = OrderCreatedWebhookData::from($order);

        $this->handleOrderCreatedWebhook->execute($data);
    }
}
