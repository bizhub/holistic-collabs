<?php

namespace Domain\Clinic\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class ClinicFormData extends Data
{
    public function __construct(
        public string $name,
        public ?string $coupon_shopify_id,
        public float $commission_rate,
    ) {}
}
