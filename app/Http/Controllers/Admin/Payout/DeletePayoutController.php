<?php

namespace App\Http\Controllers\Admin\Payout;

use Domain\Commission\Models\Payout;
use Inertia\Inertia;

class DeletePayoutController
{
    public function __invoke(Payout $payout)
    {
        $payout->delete();

        Inertia::flash('success', 'Payout deleted');

        return back();
    }
}
