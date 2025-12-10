<?php

namespace Domain\Coupon\Data;

use Domain\Clinic\Data\ClinicData;
use Spatie\LaravelData\Data;

/** @typescript */
class CouponData extends Data
{
    public function __construct(
        public string $id,
        public string $code,

        public ?ClinicData $clinic,
    ) {}
}
