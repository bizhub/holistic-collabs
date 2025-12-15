<?php

namespace Domain\Shopify\Context;

use Domain\Client\Models\Client;
use Domain\Clinic\Models\Clinic;
use Spatie\LaravelData\Data;

class ShopifyOrderContext extends Data
{
    public function __construct(
        public ?Client $client,
        public ?Clinic $clinic,
        public CouponContext $couponContext,
        public float $subtotal,
        public bool $firstOrder,
    ) {}
}
