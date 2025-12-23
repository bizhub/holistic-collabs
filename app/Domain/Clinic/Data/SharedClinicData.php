<?php

namespace Domain\Clinic\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class SharedClinicData extends Data
{
    public function __construct(
        public string $name,
    ) {}
}
