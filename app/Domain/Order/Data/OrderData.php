<?php

namespace Domain\Order\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class OrderData extends Data
{
    public function __construct(
        public string $id,
    ) {}
}
