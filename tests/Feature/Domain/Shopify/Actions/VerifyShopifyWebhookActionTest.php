<?php

use Domain\Shopify\Actions\VerifyShopifyWebhookAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

it('returns true when hmac is valid', function () {
    Config::set('services.shopify.client_secret', 'test-secret');

    $payload = '{"id":123}';

    $hmac = base64_encode(
        hash_hmac('sha256', $payload, 'test-secret', true)
    );

    $request = Request::create(
        '/webhook',
        'POST',
        [],
        [],
        [],
        ['HTTP_X_SHOPIFY_HMAC_SHA256' => $hmac],
        $payload,
    );

    $action = new VerifyShopifyWebhookAction($request);

    expect($action->execute())->toBeTrue();
});

it('returns false when hmac is invalid', function () {
    Config::set('services.shopify.client_secret', 'test-secret');

    $payload = '{"id":123}';

    $request = Request::create(
        '/webhook',
        'POST',
        [],
        [],
        [],
        ['HTTP_X_SHOPIFY_HMAC_SHA256' => 'invalid-hmac'],
        $payload,
    );

    $action = new VerifyShopifyWebhookAction($request);

    expect($action->execute())->toBeFalse();
});
