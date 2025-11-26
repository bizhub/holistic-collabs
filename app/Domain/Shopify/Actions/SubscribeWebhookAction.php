<?php

namespace Domain\Shopify\Actions;

use Domain\Shopify\Models\ShopifyConnection;
use Domain\Shopify\Services\ShopifyApiService;

class SubscribeWebhookAction
{
    public function __construct(
        protected ShopifyApiService $api
    ) {}

    public function execute(ShopifyConnection $connection): void
    {
        $this->api->setConnection($connection);

        $webhooks = [
            ['topic' => 'orders/create', 'address' => route('shopify.webhooks.orders-create')],
            ['topic' => 'orders/updated', 'address' => route('shopify.webhooks.orders-updated')],
            ['topic' => 'customers/create', 'address' => route('shopify.webhooks.customers-create')],
        ];

        foreach ($webhooks as $webhook) {
            $this->api->post('webhooks', [
                'webhook' => [
                    'topic' => $webhook['topic'],
                    'address' => $webhook['address'],
                    'format' => 'json',
                ],
            ]);
        }
    }
}
