<?php

namespace App\Http\Controllers\Admin\Commission;

use Domain\Clinic\Data\ClinicData;
use Domain\Clinic\Models\Clinic;
use Inertia\Inertia;

class CommissionIndexController
{
    public function __invoke()
    {
        $clinics = Clinic::query()
            ->whereHas('commissions', function ($query) {
                $query->whereNull('payout_id'); // only unpaid commissions
            })
            // ->withCount('commissions')
            // ->withSum('commissions', 'amount')
            ->withCount(['commissions as commissions_count' => function ($query) {
                $query->whereNull('payout_id');
            }])
            ->withSum(['commissions as commissions_sum_amount' => function ($query) {
                $query->whereNull('payout_id');
            }], 'amount')
            ->get();

        return Inertia::render('Admin/Commission/Commissions', [
            'clinics' => ClinicData::collect($clinics),
        ]);
    }
}
