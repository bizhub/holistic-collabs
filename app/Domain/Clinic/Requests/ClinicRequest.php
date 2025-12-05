<?php

namespace Domain\Clinic\Requests;

use Spatie\LaravelData\Data;

/** @typescript */
class ClinicRequest extends Data
{
    public function __construct(
        public string $name,
    ) {}
}
