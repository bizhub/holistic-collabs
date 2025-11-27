<?php

namespace Domain\User\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class UserData extends Data
{
    public function __construct(
        public string $id,
    ) {}
}
