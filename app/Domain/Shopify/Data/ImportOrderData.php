<?php

namespace Domain\Shopify\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class ImportOrderData extends Data
{
    public function __construct(
        public string $shopify_id,
    ) {}
}
