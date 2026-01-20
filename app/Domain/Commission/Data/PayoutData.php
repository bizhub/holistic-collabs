<?php

namespace Domain\Commission\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class PayoutData extends Data
{
    public function __construct(
        public string $id,
        public int $total_amount,
        public string $paid_at,
    ) {}
}
