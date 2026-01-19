<?php

namespace Domain\Commission\Actions;

use Domain\Commission\Models\Commission;
use Domain\Commission\Models\Payout;
use Illuminate\Support\Facades\DB;

class AttachPayoutToCommissionsAction
{
    public function execute(Payout $payout)
    {
        return DB::transaction(function () use ($payout) {
            $commissions = Commission::query()
                ->where('clinic_id', $payout->clinic_id)
                ->whereNull('payout_id')
                ->where('created_at', '<=', $payout->paid_until)
                ->get();

            $commissions->each(fn ($c) => $c->update([
                'payout_id' => $payout->id,
            ]));

            return $commissions;
        });
    }
}
