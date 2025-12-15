<?php

namespace Domain\Shopify\Actions;

use Illuminate\Http\Request;

class VerifyShopifyWebhookAction
{
    public function __construct(
        protected Request $request,
    ) {}

    public function execute(): bool
    {
        $hmacHeader = $this->request->header('X-Shopify-Hmac-Sha256');
        $data = $this->request->getContent();

        $calculatedHmac = base64_encode(
            hash_hmac('sha256', $data, config('services.shopify.client_secret'), true)
        );

        return hash_equals($hmacHeader, $calculatedHmac);
    }
}
