<?php

namespace Domain\Shopify\Actions;

use Domain\Shopify\Services\ShopifyApiService;

class SubscribeWebhookAction
{
    public function __construct(
        protected ShopifyApiService $api,
    ) {}

    public function execute(): void
    {
        $webhooks = [
            [
                'topic' => 'orders/create',
                'address' => 'https://25fe63e4e3e0.ngrok-free.app/ext/shopify/webhook',
            ],
            // ['topic' => 'orders/updated', 'address' => route('shopify.webhooks.orders-updated')],
            // ['topic' => 'customers/create', 'address' => route('shopify.webhooks.customers-create')],
        ];

        foreach ($webhooks as $webhook) {
            $response = $this->api->post('Webhook', [
                'topic'   => $webhook['topic'],
                'address' => $webhook['address'],
                'format'  => 'json',
            ]);
        }
    }
}
