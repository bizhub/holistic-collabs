<?php

namespace Domain\Shopify\Actions;

use Domain\Client\Models\Client;
use Domain\Clinic\Models\Clinic;
use Domain\Commission\Actions\CalculateCommissionAction;
use Domain\Commission\Models\Commission;
use Domain\Order\Models\Order;
use Domain\Shopify\Context\CouponContext;

class CreateCommissionFromOrderAction
{
    public function __construct(
        protected CalculateCommissionAction $calculateCommission,
    ) {}

    public function execute(
        Order $order,
        ?Client $client,
        ?Clinic $clinic,
        CouponContext $couponContext,
        float $subtotal,
        bool $firstOrder,
    ): Commission|null {
        $amount = $this->calculateCommission->execute(
            clinic: $clinic,
            subtotal: $subtotal,
            couponAmount: $couponContext->amount,
            firstOrder: $firstOrder,
        );

        if ($amount == 0) {
            return null;
        }

        return Commission::create([
            'clinic_id' => $clinic->id,
            'client_id' => $client->id,
            'order_id' => $order->id,
            'coupon_id' => $couponContext?->coupon?->id,
            'commission_rate' => $clinic->commission_rate,
            'coupon_amount' => $couponContext->amount,
            'amount' => $amount,
        ]);
    }
}
