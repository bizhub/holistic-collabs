<?php

namespace Domain\Shopify\Data;

use Spatie\LaravelData\Data;

class ShopifyOAuthData extends Data
{
    public function __construct(
        public string $shop,
        public string $code,
        public string $state,
        public string $hmac,
    ) {}
}
