<?php

namespace Domain\Shopify\Actions;

use Domain\Shopify\Services\ShopifyApiService;
use Illuminate\Support\Facades\Cache;

class DeleteAllWebhooksAction
{
    public function __construct(
        protected ShopifyApiService $api,
        protected RecordShopifyActivityAction $recordShopifyActivity,
    ) {}

    public function execute()
    {
        $existing = $this->api->get('Webhook');

        foreach ($existing as $ex) {
            $this->api->getClient()->Webhook($ex['id'])->delete();
        }

        Cache::forget('shopify_webhook_status');

        $this->recordShopifyActivity->execute('Delete all webhooks');
    }
}
