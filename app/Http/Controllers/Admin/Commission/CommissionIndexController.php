<?php

namespace App\Http\Controllers\Admin\Commission;

use Domain\Commission\Data\CommissionGroupData;
use Domain\Commission\Models\Commission;
use Inertia\Inertia;

class CommissionIndexController
{
    public function __invoke()
    {
        $commissions = Commission::query()
            ->with('clinic')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('clinic_id')
            ->map(function ($commissions) {
                return CommissionGroupData::from([
                    'clinic' => $commissions->first()->clinic,
                    'commissions' => $commissions,
                ]);
            })
            ->values();

        return Inertia::render('Admin/Commission/Commissions', [
            'commissions' => $commissions,
        ]);
    }
}
