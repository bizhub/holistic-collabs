<?php

namespace Domain\Shopify\Actions;

use Domain\Client\Models\Client;
use Domain\Shopify\Data\OrderCreatedWebhookData;
use Domain\Shopify\Context\CouponContext;

class ResolveWebhookOrderClientAction
{
    public function execute(
        OrderCreatedWebhookData $data,
        CouponContext $couponContext,
    ): ?Client {
        $client = Client::query()
            ->with('clinic')
            ->where('shopify_id', $data->customer->id)
            ->first();

        $coupon = $couponContext->coupon;

        if (!$client && $coupon?->clinic) {
            return Client::create([
                'shopify_id' => $data->customer->id,
                'clinic_id' => $coupon->clinic->id,
                'name' => $data->customer->first_name . ' ' . $data->customer->last_name,
                'email' => $data->customer->email,
            ]);
        }

        if ($client && $coupon && $client->clinic_id !== $coupon->clinic_id) {
            $client->update([
                'clinic_id' => $coupon->clinic_id,
            ]);
        }

        return $client;
    }
}
