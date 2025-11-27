<?php

namespace Domain\Commission\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class CommissionData extends Data
{
    public function __construct(
        public string $id,
    ) {}
}
