<?php

namespace Domain\Coupon\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class AvailableCouponData extends Data
{
    public function __construct(
        public string $code,
        public string $shopify_id,
    ) {}
}
