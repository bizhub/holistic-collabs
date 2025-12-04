<?php

namespace App\Http\Controllers\Commission;

use Domain\Commission\Data\CommissionData;
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
            ->map(function ($group) {
                $clinic = $group->first()->clinic->toArray();
                $commissionData = CommissionData::collect($group)->toArray();

                return new CommissionGroupData(
                    clinic: $clinic,
                    commissions: $commissionData,
                );
            })
            ->values();

        return Inertia::render('Commission/Commissions', [
            'commissions' => $commissions,
        ]);
    }
}
