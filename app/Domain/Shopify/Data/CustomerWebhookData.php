<?php

namespace Domain\Shopify\Data;

use Spatie\LaravelData\Data;

class CustomerWebhookData extends Data
{
    public function __construct(
        public int $id,
        public string $email,
        public string $first_name,
        public ?string $last_name,
        public ?string $phone,
    ) {}
}
