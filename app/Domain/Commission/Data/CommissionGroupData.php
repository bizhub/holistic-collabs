<?php

namespace Domain\Commission\Data;

use Domain\Clinic\Data\ClinicData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/** @typescript */
class CommissionGroupData extends Data
{
    public function __construct(
        public ClinicData $clinic,

        /** @var CommissionData[] */
        public DataCollection $commissions,
    ) {}
}
