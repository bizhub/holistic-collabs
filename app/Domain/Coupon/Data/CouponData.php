<?php

namespace Domain\Coupon\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class CouponData extends Data
{
    public function __construct(
        public string $id,
        public string $code,
    ) {}
}
