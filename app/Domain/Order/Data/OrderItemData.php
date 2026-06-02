<?php

namespace Domain\Order\Data;

use Domain\Client\Data\ClientData;
use Domain\Clinic\Data\ClinicData;
use Spatie\LaravelData\Data;

/** @typescript */
class OrderItemData extends Data
{
    public function __construct(
        public string $id,
        public string $name,
        public int $quantity,
        public float $price,
    ) {}
}
