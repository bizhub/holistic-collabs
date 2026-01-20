<?php

namespace App\Http\Controllers\Admin\Payout;

use Domain\Commission\Data\PayoutData;
use Domain\Commission\Models\Payout;
use Inertia\Inertia;

class PayoutIndexController
{
    public function __invoke()
    {
        $payouts = Payout::query()
            ->with('clinic')
            ->orderByDesc('paid_at')
            ->get();

        return Inertia::render('Admin/Payout/Payouts', [
            'payouts' => PayoutData::collect($payouts),
        ]);
    }
}
