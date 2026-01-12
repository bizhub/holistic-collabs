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

        public float $commission_rate,

        #[DataCollectionOf(CouponData::class)]
        public ?DataCollection $coupons,

        public ?int $clients_count,
        public ?int $users_count,

        public ?int $commissions_count,
        public ?int $commissions_sum_amount,
    ) {}
}
