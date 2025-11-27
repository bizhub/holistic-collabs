<?php

namespace Domain\Shopify\Data;

use Spatie\LaravelData\Data;

class ShopifyWebhookData extends Data
{
    public function __construct(
        public array $payload,
    ) {}

    public static function fromPayload(array $payload): self
    {
        return new self($payload);
    }

    public function email(): ?string
    {
        return $this->payload['email']
            ?? $this->payload['customer']['email']
            ?? null;
    }

    public function coupon(): ?string
    {
        $discounts = $this->payload['discount_codes'] ?? [];

        if (!count($discounts)) {
            return null;
        }

        return $discounts[0]['code'] ?? null;
    }

    public function orderId(): ?string
    {
        return (string) ($this->payload['id'] ?? null);
    }
}
