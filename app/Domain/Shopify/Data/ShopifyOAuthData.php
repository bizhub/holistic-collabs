<?php

namespace Domain\Shopify\Data;

use Spatie\LaravelData\Data;

class ShopifyOAuthData extends Data
{
    public function __construct(
        public string $shop,
        public string $hmac,
        public string $host,
        public string $state,
        public int $timestamp,
    ) {}
}
