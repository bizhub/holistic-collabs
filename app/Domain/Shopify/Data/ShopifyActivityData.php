<?php

namespace Domain\Shopify\Data;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

/** @typescript */
class ShopifyActivityData extends Data
{
    public function __construct(
        public string $id,
        public string $description,
        public Carbon $created_at,
    ) {}
}
