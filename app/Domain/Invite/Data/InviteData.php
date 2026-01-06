<?php

namespace Domain\Invite\Data;

use Domain\Clinic\Data\ClinicData;
use Spatie\LaravelData\Data;

/** @typescript */
class InviteData extends Data
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,

        public ?ClinicData $clinic,
    ) {}
}
