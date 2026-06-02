<?php

namespace Domain\Shopify\Data;

use Spatie\LaravelData\Data;

class OrderLineItemWebhookData extends Data
{
    public function __construct(
        public int $id,
        public int $product_id,
        public string $name,
        public int $quantity,
        public string $price,
    ) {}
}
