<?php

namespace Domain\Commission\Data;

use Domain\Client\Data\ClientData;
use Domain\Order\Data\OrderData;
use Spatie\LaravelData\Data;

/** @typescript */
class CommissionData extends Data
{
    public function __construct(
        public string $id,

        public float $amount,

        public string $created_at,

        public ?ClientData $client,
        public ?PayoutData $payout,
        public ?OrderData $order,
    ) {}
}
