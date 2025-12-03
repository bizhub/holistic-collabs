<?php

namespace Domain\Clinic\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class ClinicData extends Data
{
    public function __construct(
        public string $id,
        public string $name,
    ) {}
}
