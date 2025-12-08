<?php

namespace Domain\Shopify\Data;

use Domain\Shopify\Enums\ConnectionStatus;
use Spatie\LaravelData\Data;

/** @typescript */
class ShopifyData extends Data
{
    public function __construct(
        public ConnectionStatus $status,
    ) {}
}
