<?php

namespace Domain\Client\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class ClientData extends Data
{
    public function __construct(
        public string $id,
    ) {}
}
