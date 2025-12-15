<?php

namespace Domain\Shopify\Context;

use Domain\Coupon\Models\Coupon;
use Spatie\LaravelData\Data;

/** @typescript */
class CouponContext extends Data
{
    public function __construct(
        public ?Coupon $coupon,
        public float $amount,
    ) {}
}
