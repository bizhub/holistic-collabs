<?php

namespace Domain\Client\Data;

use Domain\Clinic\Data\ClinicData;
use Spatie\LaravelData\Data;

/** @typescript */
class ClientData extends Data
{
    public function __construct(
        public string $id,

        public string $name,
        public string $email,

        public ?ClinicData $clinic,

        public ?int $commissions_count,
    ) {}
}
