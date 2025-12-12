<?php

namespace Domain\Shopify\Data;

use Spatie\LaravelData\Data;

class OrderCreatedWebhookData extends Data
{
    public function __construct(
        public int $id,
        public CustomerWebhookData $customer,
        public string $order_status_url,
        public array $discount_codes,
        public float $total_price,
    ) {}
}
