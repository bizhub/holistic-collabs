<?php

namespace Domain\Shopify\Actions;

use Domain\Shopify\Services\ShopifyApiService;

class SubscribeWebhookAction
{
    public function __construct(
        protected ShopifyApiService $api,
        protected RecordShopifyActivityAction $recordShopifyActivity,
    ) {}

    public function execute(): void
    {
        $webhooks = [
            [
                'topic' => 'orders/create',
                'address' => 'https://eb831722c264.ngrok-free.app/ext/shopify/webhook/orders/created',
            ],
        ];

        $existing = $this->api->get('Webhook');

        foreach ($webhooks as $webhook) {
            foreach ($existing as $ex) {
                if ($ex['topic'] === $webhook['topic']) {
                    $this->api->getClient()->Webhook($ex['id'])->delete();
                }
            }

            $this->api->post('Webhook', [
                'topic' => $webhook['topic'],
                'address' => $webhook['address'],
                'format' => 'json',
            ]);

            $this->recordShopifyActivity->execute('Subscribe to orders/create webhook');
        }
    }
}
