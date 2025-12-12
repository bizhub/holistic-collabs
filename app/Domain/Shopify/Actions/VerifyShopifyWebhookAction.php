<?php

namespace Domain\Shopify\Actions;

class VerifyShopifyWebhookAction
{
    public function execute(): bool
    {
        $request = request();

        ds($request->headers);

        $hmacHeader = $request->header('X-Shopify-Hmac-Sha256');
        $data = $request->getContent();

        $calculatedHmac = base64_encode(
            hash_hmac('sha256', $data, config('services.shopify.client_secret'), true)
        );

        return hash_equals($hmacHeader, $calculatedHmac);
    }
}
