<?php

namespace Domain\Shopify\Actions;

use Domain\Coupon\Models\Coupon;
use Domain\Shopify\Context\CouponContext;
use Domain\Shopify\Data\OrderCreatedWebhookData;

class ResolveWebhookOrderCouponAction
{
    public function execute(OrderCreatedWebhookData $data): CouponContext
    {
        $matchedCoupon = null;
        $matchedAmount = 0;
        $unrelatedDiscountTotal = 0;

        foreach ($data->discount_codes as $discount) {
            if ($discount['type'] !== 'fixed_amount') {
                continue;
            }

            $coupon = Coupon::query()
                ->with('clinic')
                ->where('code', $discount['code'])
                ->first();

            if ($coupon) {
                $matchedCoupon = $coupon;
                $matchedAmount = (float) $discount['amount'];
            } else {
                $unrelatedDiscountTotal += (float) $discount['amount'];
            }
        }

        return CouponContext::from([
            'coupon' => $matchedCoupon,
            'amount' => $matchedAmount,
            'totalUnrelated' => $unrelatedDiscountTotal,
        ]);
    }
}
