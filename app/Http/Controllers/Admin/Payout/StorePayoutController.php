<?php

namespace App\Http\Controllers\Admin\Payout;

use Domain\Clinic\Models\Clinic;
use Domain\Commission\Actions\AttachPayoutToCommissionsAction;
use Domain\Commission\Actions\CreatePayoutAction;
use Domain\Commission\Data\CreatePayoutData;
use Illuminate\Support\MessageBag;
use Inertia\Inertia;

class StorePayoutController
{
    public function __invoke(
        Clinic $clinic,
        CreatePayoutData $data,
        CreatePayoutAction $createPayout,
        AttachPayoutToCommissionsAction $attachPayoutToCommissions,
    ) {
        $payout = $createPayout->execute($clinic, $data);

        if (! $payout) {
            return back()->withErrors(
                new MessageBag([
                    'payout' => 'Unable to create payout. Please try again.',
                ])
            );
        }

        $attachPayoutToCommissions->execute($payout);

        Inertia::flash('success', 'Payout created for ' . $clinic->name);

        return redirect('commissions');
    }
}
