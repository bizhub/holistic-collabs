<?php

namespace App\Http\Controllers\Clinic\Dashboard;

use Domain\Client\Models\Client;
use Domain\Clinic\Support\ClinicContext;
use Domain\Commission\Data\CommissionData;
use Domain\Commission\Models\Commission;
use Inertia\Inertia;

class DashboardIndexController
{
    public function __invoke(ClinicContext $clinicContext)
    {
        $clientCount = Client::query()
            ->where('clinic_id', $clinicContext->id())
            ->count();

        $commissionCount = Commission::query()
            ->where('clinic_id', $clinicContext->id())
            ->count();

        $commissionEarned = Commission::query()
            ->where('clinic_id', $clinicContext->id())
            ->sum('amount');

        $commissions = Commission::query()
            ->where('clinic_id', $clinicContext->id())
            ->orderBy('created_at')
            ->get();

        return Inertia::render('Clinic/Dashboard/Dashboard', [
            'client_count' => $clientCount,
            'commission_count' => $commissionCount,
            'commission_earned' => $commissionEarned,
            'commissions' => CommissionData::collect($commissions),
        ]);
    }
}
