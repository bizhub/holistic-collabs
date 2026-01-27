<?php

namespace Domain\Order\Data;

use Domain\Client\Data\ClientData;
use Domain\Clinic\Data\ClinicData;
use Spatie\LaravelData\Data;

/** @typescript */
class OrderData extends Data
{
    public function __construct(
        public string $id,
        public string $order_number,
        public ?string $coupon_code,
        public float $subtotal_price,

        public ?ClinicData $clinic,
        public ?ClientData $client,

        public string $created_at,
    ) {}
}
