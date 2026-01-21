<?php

namespace App\Http\Controllers\Clinic\Dashboard;

use Domain\Client\Models\Client;
use Domain\Clinic\Support\ClinicContext;
use Domain\Commission\Data\CommissionData;
use Domain\Commission\Data\PayoutData;
use Domain\Commission\Models\Commission;
use Domain\Commission\Models\Payout;
use Domain\Coupon\Models\Coupon;
use Inertia\Inertia;

class DashboardIndexController
{
    public function __invoke(ClinicContext $clinicContext)
    {
        $clinicId = $clinicContext->id();

        $lastPayout = Payout::query()
            ->where('clinic_id', $clinicId)
            ->orderByDesc('paid_at')
            ->first();

        $lastPaidAt = $lastPayout?->paid_at;

        $clientCount = Client::query()
            ->where('clinic_id', $clinicId)
            ->count();

        $clientCountSinceLast = $lastPaidAt
            ? Client::query()
                ->where('clinic_id', $clinicId)
                ->where('created_at', '>', $lastPaidAt)
                ->count()
            : $clientCount;

        $clientPercentageChange = $lastPayout
            ? $clientCountSinceLast / max($clientCount - $clientCountSinceLast, 1) * 100
            : null;

        $commissionCount = Commission::query()
            ->where('clinic_id', $clinicId)
            ->count();

        $commissionCountSinceLast = $lastPaidAt
            ? Commission::query()
                ->where('clinic_id', $clinicId)
                ->where('created_at', '>', $lastPaidAt)
                ->count()
            : $commissionCount;

        $commissionPercentageChange = $lastPayout
            ? $commissionCountSinceLast / max($commissionCount - $commissionCountSinceLast, 1) * 100
            : null;

        $commissionEarned = Commission::query()
            ->where('clinic_id', $clinicId)
            ->sum('amount');

        $payouts = Payout::query()
            ->where('clinic_id', $clinicId)
            ->orderByDesc('paid_at')
            ->get();

        $upcomingPayoutAmount = Commission::query()
            ->where('clinic_id', $clinicId)
            ->whereNull('payout_id')
            ->sum('amount');

        $upcomingSinceLast = $lastPaidAt
            ? Commission::query()
                ->where('clinic_id', $clinicId)
                ->whereNull('payout_id')
                ->where('created_at', '>', $lastPaidAt)
                ->sum('amount')
            : $upcomingPayoutAmount;

        $upcomingPayoutPercentageChange = $lastPayout
            ? $upcomingSinceLast / max($upcomingPayoutAmount - $upcomingSinceLast, 1) * 100
            : null;

        $coupon = Coupon::query()
            ->where('clinic_id', $clinicId)
            ->first();

        return Inertia::render('Clinic/Dashboard/Dashboard', [
            'client_count' => $clientCount,
            'client_percentage_change' => $clientPercentageChange,

            'commission_count' => $commissionCount,
            'commission_percentage_change' => $commissionPercentageChange,

            'commission_earned' => (int)$commissionEarned / 100,

            'payouts' => PayoutData::collect($payouts),

            'upcoming_payout_amount' => (int)$upcomingPayoutAmount / 100,
            'upcoming_payout_percentage_change' => $upcomingPayoutPercentageChange,

            'coupon_code' => $coupon ? $coupon->code : null,
        ]);
    }
}
