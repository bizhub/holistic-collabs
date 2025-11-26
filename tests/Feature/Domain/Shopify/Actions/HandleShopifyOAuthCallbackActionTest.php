<?php

use Illuminate\Support\Facades\Http;
use Domain\Shopify\Actions\HandleShopifyOAuthCallbackAction;
use Domain\Shopify\Data\ShopifyOAuthData;
use Domain\Shopify\Enums\ConnectionStatus;
use Domain\Shopify\Models\ShopifyConnection;

it('creates a Shopify connection from OAuth callback', function () {

    Http::fake([
        '*/admin/oauth/access_token' => Http::response([
            'access_token' => 'test_token',
            'scope' => 'read_orders,write_orders',
        ], 200),
    ]);

    // Fake session for state verification
    session(['shopify_oauth_state' => 'test_state']);

    $data = new ShopifyOAuthData(
        shop: 'test-shop.myshopify.com',
        code: 'test_code',
        state: 'test_state',
        hmac: hash_hmac(
            'sha256',
            http_build_query([
                'code' => 'test_code',
                'shop' => 'test-shop.myshopify.com',
                'state' => 'test_state'
            ]),
            config('services.shopify.client_secret'),
        )
    );

    $action = new HandleShopifyOAuthCallbackAction;

    $connection = $action->execute($data);

    expect($connection)
        ->toBeInstanceOf(ShopifyConnection::class)
        ->and($connection->access_token)->toEqual('test_token')
        ->and($connection->scope)->toEqual('read_orders,write_orders')
        ->and($connection->status)->toEqual(ConnectionStatus::Active);
});

it('throws exception if OAuth state is invalid', function () {

    session(['shopify_oauth_state' => 'wrong_state']);

    $data = new ShopifyOAuthData(
        shop: 'test-shop.myshopify.com',
        code: 'test_code',
        state: 'test_state',
        hmac: 'fake_hmac'
    );

    $action = new HandleShopifyOAuthCallbackAction;

    $action->execute($data);
})->throws(\Symfony\Component\HttpKernel\Exception\HttpException::class, 'Invalid OAuth state');

it('throws exception if HMAC signature is invalid', function () {

    session(['shopify_oauth_state' => 'test_state']);

    $data = new ShopifyOAuthData(
        shop: 'test-shop.myshopify.com',
        code: 'test_code',
        state: 'test_state',
        hmac: 'invalid_hmac'
    );

    $action = new HandleShopifyOAuthCallbackAction;

    $action->execute($data);
})->throws(\Symfony\Component\HttpKernel\Exception\HttpException::class, 'Invalid HMAC signature');
