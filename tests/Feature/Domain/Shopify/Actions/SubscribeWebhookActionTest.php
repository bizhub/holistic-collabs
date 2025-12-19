<?php

use Domain\Shopify\Actions\SubscribeWebhookAction;
use Domain\Shopify\Actions\RecordShopifyActivityAction;
use Domain\Shopify\Services\ShopifyApiService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use PHPShopify\ShopifySDK;

it('deletes existing webhook with same topic and recreates it', function () {
    Cache::shouldReceive('forget')
        ->once()
        ->with('shopify_webhook_status');

    Config::set('services.shopify.webhook_url', 'https://example.com');

    $existingWebhooks = [
        [
            'id' => '123',
            'topic' => 'orders/create',
        ],
    ];

    $webhookResource = Mockery::mock();
    $webhookResource->shouldReceive('delete')->once();

    $sdk = Mockery::mock(ShopifySDK::class);
    $sdk->shouldReceive('Webhook')
        ->once()
        ->with('123')
        ->andReturn($webhookResource);

    $api = Mockery::mock(ShopifyApiService::class);
    $api->shouldReceive('get')
        ->once()
        ->with('Webhook')
        ->andReturn($existingWebhooks);

    $api->shouldReceive('getClient')
        ->once()
        ->andReturn($sdk);

    $api->shouldReceive('post')
        ->once()
        ->with('Webhook', [
            'topic' => 'orders/create',
            'address' => 'https://example.com/ext/shopify/webhook/orders/created',
            'format' => 'json',
        ]);

    $activity = Mockery::mock(RecordShopifyActivityAction::class);
    $activity->shouldReceive('execute')
        ->once()
        ->with('Subscribe to orders/create webhook');

    $action = new SubscribeWebhookAction($api, $activity);

    $action->execute();
});

it('creates webhook when none exist', function () {
    Cache::shouldReceive('forget')->once();

    Config::set('services.shopify.webhook_url', 'https://example.com');

    $api = Mockery::mock(ShopifyApiService::class);
    $api->shouldReceive('get')
        ->once()
        ->with('Webhook')
        ->andReturn([]);

    $api->shouldReceive('post')
        ->once();

    $activity = Mockery::mock(RecordShopifyActivityAction::class);
    $activity->shouldReceive('execute')->once();

    $action = new SubscribeWebhookAction($api, $activity);

    $action->execute();
});
