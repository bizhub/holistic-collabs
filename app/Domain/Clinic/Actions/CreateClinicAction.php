<?php

namespace Domain\Clinic\Actions;

use Domain\Clinic\Data\ClinicFormData;
use Domain\Clinic\Models\Clinic;
use Domain\Coupon\Actions\GetAvailableCouponsFromShopifyAction;

class CreateClinicAction
{
    public function __construct(
        protected GetAvailableCouponsFromShopifyAction $getAvailableCouponsFromShopifyAction,
    ) {}

    public function execute(ClinicFormData $data): Clinic
    {
        $clinic = Clinic::create([
            'name' => $data->name,
        ]);

        if (!empty($data->coupon_shopify_id)) {
            $availableCoupons = $this->getAvailableCouponsFromShopifyAction->execute();

            foreach ($availableCoupons as $availableCoupon) {
                if ($availableCoupon->shopify_id != $data->coupon_shopify_id) {
                    continue;
                }

                $clinic->coupons()->create([
                    'code' => $availableCoupon->code,
                    'shopify_id' => $availableCoupon->shopify_id,
                ]);
            }
        }

        return $clinic;
    }
}
