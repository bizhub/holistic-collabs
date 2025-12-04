<?php

namespace Domain\Commission\Data;

use Domain\Clinic\Data\ClinicData;
use Spatie\LaravelData\Data;

/** @typescript */
class CommissionGroupData extends Data
{
    public function __construct(
        public ClinicData $clinic,

        /** @var CommissionData[] */
        public array $commissions,
    ) {}
}
