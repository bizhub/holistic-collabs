<?php

namespace Domain\Shopify\Actions;

use Domain\Commission\Actions\CalculateCommissionAction;
use Domain\Commission\Models\Commission;
use Domain\Order\Models\Order;
use Domain\Shopify\Context\ShopifyOrderContext;

class CreateCommissionFromOrderAction
{
    public function __construct(
        protected CalculateCommissionAction $calculateCommission,
    ) {}

    public function execute(
        ShopifyOrderContext $context,
        Order $order,
    ): Commission {
        return Commission::create([
            'clinic_id' => $context->clinic->id,
            'client_id' => $context->client->id,
            'order_id' => $order->id,
            'commission_rate' => $context->clinic->commission_rate,
            'coupon_amount' => $context->couponContext->amount,
            'amount' => $this->calculateCommission->execute(
                clinic: $context->clinic,
                subtotal: $context->subtotal,
                couponAmount: $context->couponContext->amount,
                firstOrder: $context->firstOrder,
            ),
        ]);
    }
}
