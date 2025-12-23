<?php

namespace Domain\User\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class SharedUserData extends Data
{
    public function __construct(
        public bool $is_admin,

        public string $name,
        public string $email,
    ) {}
}
