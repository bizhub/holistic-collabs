<?php

namespace Domain\Shopify\Actions;

use Domain\Shopify\Services\ShopifyApiService;
use Domain\Shopify\Enums\WebhookStatus;
use Illuminate\Support\Facades\Cache;
use Throwable;

class GetWebhookStatusAction
{
    protected array $requiredTopics = [
        'orders/create',
    ];

    protected string $cacheKey = 'shopify_webhook_status';
    protected int $cacheTtlSeconds = 300;

    public function __construct(
        protected ShopifyApiService $api,
    ) {}

    public function execute(): WebhookStatus
    {
        return Cache::remember($this->cacheKey, $this->cacheTtlSeconds, fn() => $this->getStatus());
    }

    protected function getStatus()
    {
        try {
            $webhooks = collect($this->api->getClient()->Webhook->get());

            if ($webhooks->isEmpty()) {
                return WebhookStatus::Disconnected;
            }

            $installedTopics = $webhooks->pluck('topic')->toArray();
            $missing = array_diff($this->requiredTopics, $installedTopics);

            return empty($missing)
                ? WebhookStatus::Connected
                : WebhookStatus::Partial;

        } catch (Throwable) {
            return WebhookStatus::Error;
        }
    }
}
