<?php

namespace App\Http\Controllers\Admin\Payout;

use Domain\Clinic\Models\Clinic;
use Domain\Commission\Actions\AttachPayoutToCommissionsAction;
use Domain\Commission\Actions\CreatePayoutAction;
use Domain\Commission\Data\CreatePayoutData;

class StorePayoutController
{
    public function __invoke(
        Clinic $clinic,
        CreatePayoutData $data,
        CreatePayoutAction $createPayout,
        AttachPayoutToCommissionsAction $attachPayoutToCommissions,
    ) {
        $attachPayoutToCommissions->execute(
            payout: $createPayout->execute($clinic, $data),
        );

        return redirect('commissions');
    }
}
