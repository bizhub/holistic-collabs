<?php

namespace Domain\Commission\Data;

use Domain\Commission\Enums\CommissionStatus;
use Spatie\LaravelData\Data;

/** @typescript */
class CommissionData extends Data
{
    public function __construct(
        public string $id,

        public CommissionStatus $status,
        public float $amount,

        public string $created_at,
    ) {}
}
