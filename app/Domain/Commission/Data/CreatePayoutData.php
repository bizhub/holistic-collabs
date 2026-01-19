<?php

namespace Domain\Commission\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class CreatePayoutData extends Data
{
    public function __construct(
        public string $paid_until,
    ) {}
}
