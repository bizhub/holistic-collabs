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

    protected function getStatus(): WebhookStatus
    {
        try {
            $webhooks = collect($this->api->getClient()->Webhook->get());

            if ($webhooks->isEmpty()) {
                return WebhookStatus::Disconnected;
            }

            $baseUrl = rtrim(config('services.shopify.webhook_url'), '/');

            $installedTopics = $webhooks->mapWithKeys(fn($webhook) => [
                $webhook['topic'] => rtrim($webhook['address'], '/')
            ])->toArray();

            $missing = [];
            foreach ($this->requiredTopics as $topic) {
                if (!isset($installedTopics[$topic])) {
                    $missing[] = $topic;
                    continue;
                }

                if (strpos($installedTopics[$topic], $baseUrl) !== 0) {
                    $missing[] = $topic;
                }
            }

            return empty($missing)
                ? WebhookStatus::Connected
                : WebhookStatus::Partial;

        } catch (Throwable) {
            return WebhookStatus::Error;
        }
    }
}
