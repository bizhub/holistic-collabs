<?php

namespace Domain\Shopify\Actions;

use Domain\Coupon\Models\Coupon;
use Domain\Shopify\Context\CouponContext;
use Domain\Shopify\Data\OrderCreatedWebhookData;

class ResolveWebhookOrderCouponAction
{
    public function execute(OrderCreatedWebhookData $data): CouponContext
    {
        foreach ($data->discount_codes as $discount) {
            if ($discount['type'] !== 'fixed_amount') {
                continue;
            }

            return CouponContext::from([
                'coupon' => Coupon::query()
                    ->with('clinic')
                    ->where('code', $discount['code'])
                    ->first(),
                'amount' => (float) $discount['amount'],
            ]);
        }

        return CouponContext::from([
            'coupon' => null,
            'amount' => 0,
        ]);
    }
}
