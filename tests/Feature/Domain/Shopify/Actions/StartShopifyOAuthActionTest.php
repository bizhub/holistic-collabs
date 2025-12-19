<?php

use Domain\Shopify\Actions\StartShopifyOAuthAction;
use Illuminate\Support\Facades\Config;

it('sets a shopify_oauth_state in session', function () {
    $action = new StartShopifyOAuthAction;

    $action->execute(
        shopUrl: 'test-shop.myshopify.com',
    );

    $state = session('shopify_oauth_state');

    expect($state)->not()->toBeNull();
    expect(strlen($state))->toBe(32);
});

it('returns an Inertia location with correct URL', function () {
    Config::set('services.shopify.client_id', 'test-client-id');
    Config::set('services.shopify.callback', 'https://example.com/callback');

    $action = new StartShopifyOAuthAction;

    $url = $action->execute(
        shopUrl: 'test-shop.myshopify.com',
    );

    $state = session('shopify_oauth_state');

    $expectedUrl = 'https://test-shop.myshopify.com/admin/oauth/authorize?' . http_build_query([
        'client_id' => 'test-client-id',
        'redirect_uri' => 'https://example.com/callback',
        'state' => $state,
    ]);

    expect($url)->toBe($expectedUrl);
});
