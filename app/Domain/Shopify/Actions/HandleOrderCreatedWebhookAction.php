<?php

namespace Domain\Shopify\Actions;

use Domain\Client\Models\Client;
use Domain\Commission\Actions\CalculateCommissionAction;
use Domain\Commission\Models\Commission;
use Domain\Coupon\Models\Coupon;
use Domain\Order\Models\Order;
use Domain\Shopify\Data\OrderCreatedWebhookData;

class HandleOrderCreatedWebhookAction
{
    public function __construct(
        protected CalculateCommissionAction $calculateCommission,
        protected RecordShopifyActivityAction $recordShopifyActivity,
    ) {}

    public function execute(OrderCreatedWebhookData $data): void
    {
        $client = Client::query()
            ->with('clinic')
            ->where('shopify_id', $data->customer->id)
            ->first();

        $code = '';
        $shopifyDiscountAmount = 0;
        foreach ($data->discount_codes as $discount) {
            if ($discount['type'] != 'fixed_amount') {
                continue;
            }

            $code = $discount['code'];
            $shopifyDiscountAmount = (float) $discount['amount'];
        }

        $coupon = $code
            ? Coupon::query()
                ->with('clinic')
                ->where('code', $code)
                ->first()
            : null;

        if ($client) {
            if ($coupon) {
                $clinicFromCoupon = $coupon->clinic;

                // ** Client attached to a different clinic **
                if ($client->clinic_id !== $clinicFromCoupon->id) {
                    $client->update([
                        'clinic_id' => $clinicFromCoupon->id
                    ]);

                    $order = Order::create([
                        'clinic_id' => $clinicFromCoupon->id,
                        'shopify_id' => $data->id,
                        'subtotal_price' => $data->total_line_items_price,
                    ]);

                    $commissionAmount = $this->calculateCommission->execute(
                        clinic: $clinicFromCoupon,
                        subtotal: $data->total_line_items_price,
                        couponAmount: $shopifyDiscountAmount,
                        firstOrder: true,
                    );

                    Commission::create([
                        'clinic_id' => $clinicFromCoupon->id,
                        'client_id' => $client->id,
                        'order_id' => $order->id,
                        'commission_rate' => $clinicFromCoupon->commission_rate,
                        'coupon_amount' => $shopifyDiscountAmount,
                        'amount' => $commissionAmount,
                    ]);

                    $this->recordShopifyActivity->execute('Webhook (orders.created) ' . $data->id . ' - Coupon found but client is connected with a different clinic. Moving.');

                    return;
                }
            }

            // ** Client exists without coupon **

            $order = Order::create([
                'clinic_id' => $client->clinic->id,
                'shopify_id' => $data->id,
                'subtotal_price' => $data->total_line_items_price,
            ]);

            $commissionAmount = $this->calculateCommission->execute(
                clinic: $client->clinic,
                subtotal: $data->total_line_items_price,
            );

            Commission::create([
                'clinic_id' => $client->clinic->id,
                'client_id' => $client->id,
                'order_id' => $order->id,
                'commission_rate' => $client->clinic->commission_rate,
                'coupon_amount' => 0,
                'amount' => $commissionAmount,
            ]);

            $this->recordShopifyActivity->execute('Webhook (orders.created) ' . $data->id . ' - Client exists. No coupon found on order.');

            return;
        }

        // No client exists
        if (!$coupon) {
            $this->recordShopifyActivity->execute('Webhook (orders.created) ' . $data->id . ' - Client and coupon doesn\'t exist ... skipping');

            return;
        }

        // Client referred via coupon
        $clinicFromCoupon = $coupon->clinic;

        if (!$clinicFromCoupon) {
            return;
        }

        $client = Client::create([
            'shopify_id' => $data->customer->id,
            'clinic_id' => $clinicFromCoupon->id,

            'name' => $data->customer->first_name,
            'email' => $data->customer->email,
        ]);

        $order = Order::create([
            'clinic_id' => $clinicFromCoupon->id,
            'shopify_id' => $data->id,
            'subtotal_price' => $data->total_line_items_price,
        ]);

        $commissionAmount = $this->calculateCommission->execute(
            clinic: $clinicFromCoupon,
            subtotal: $data->total_line_items_price,
            couponAmount: $shopifyDiscountAmount,
            firstOrder: true,
        );

        Commission::create([
            'clinic_id' => $clinicFromCoupon->id,
            'client_id' => $client->id,
            'order_id' => $order->id,
            'commission_rate' => $clinicFromCoupon->commission_rate,
            'coupon_amount' => $shopifyDiscountAmount,
            'amount' => $commissionAmount,
        ]);

        $this->recordShopifyActivity->execute('Webhook (orders.created) ' . $data->id . ' - New client referral');
    }
}
