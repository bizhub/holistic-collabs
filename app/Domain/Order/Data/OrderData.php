<?php

namespace Domain\Order\Data;

use Domain\Clinic\Data\ClinicData;
use Spatie\LaravelData\Data;

/** @typescript */
class OrderData extends Data
{
    public function __construct(
        public string $id,
        public ?string $coupon_code,
        public float $subtotal_price,

        public ?ClinicData $clinic,
    ) {}
}
