<?php

namespace Domain\Clinic\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class ClinicFormData extends Data
{
    public function __construct(
        public string $name,
    ) {}
}
