<?php

namespace Domain\User\Data;

use Domain\Clinic\Data\ClinicData;
use Spatie\LaravelData\Data;

/** @typescript */
class UserData extends Data
{
    public function __construct(
        public string $id,

        public bool $is_admin,
        public ?string $clinic_id,

        public string $name,
        public string $email,

        public ?ClinicData $clinic,
    ) {}
}
