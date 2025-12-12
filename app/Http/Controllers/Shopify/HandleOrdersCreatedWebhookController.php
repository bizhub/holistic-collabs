<?php

namespace App\Http\Controllers\Shopify;

use Domain\Shopify\Actions\HandleOrderCreatedWebhookAction;
use Domain\Shopify\Actions\VerifyShopifyWebhookAction;
use Domain\Shopify\Data\OrderCreatedWebhookData;
use Illuminate\Http\Response;

class HandleOrdersCreatedWebhookController
{
    public function __invoke(
        OrderCreatedWebhookData $data,
        VerifyShopifyWebhookAction $verifyShopifyWebhook,
        HandleOrderCreatedWebhookAction $handleOrderCreatedWebhook,
    ) {
        abort_if(!$verifyShopifyWebhook->execute(), Response::HTTP_UNAUTHORIZED, 'Invalid HMAC');

        $handleOrderCreatedWebhook->execute($data);

        return response('Webhook processed', Response::HTTP_OK);
    }
}
