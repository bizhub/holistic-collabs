<?php

namespace Domain\Invite\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class CreateInviteData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $clinic_id,
    ) {}
}
