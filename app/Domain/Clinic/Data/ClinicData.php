<?php

namespace Domain\Clinic\Data;

use Domain\Coupon\Data\CouponData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/** @typescript */
class ClinicData extends Data
{
    public function __construct(
        public string $id,
        public string $name,

        #[DataCollectionOf(CouponData::class)]
        public ?DataCollection $coupons,

        public ?int $commissions_count,
        public ?int $clients_count,
    ) {}
}
