<?php

namespace Domain\Coupon\Actions;

use Domain\Coupon\Data\AvailableCouponData;
use Domain\Coupon\Models\Coupon;
use Domain\Shopify\Exceptions\ShopifyNotConnectedException;
use Domain\Shopify\Services\ShopifyApiService;
use Illuminate\Support\Facades\Cache;

class GetAvailableCouponsFromShopifyAction
{
    public function __construct(
        protected ShopifyApiService $api,
    ) {}

    public function execute(): array
    {
        $priceRules = Cache::remember(
            key: 'shopify_price_rules',
            ttl: 60,
            callback: fn () => $this->getPriceRulesFromShopify(),
        );

        $existingIds = Coupon::pluck('shopify_id')->all();

        $coupons = [];
        foreach ($priceRules as $priceRule) {
            if ($priceRule['value_type'] != 'fixed_amount') {
                continue;
            }

            if (in_array($priceRule['id'], $existingIds)) {
                continue;
            }

            $coupons[] = [
                'code' => $priceRule['title'],
                'shopify_id' => $priceRule['id'],
            ];

            Cache::forget('shopify_price_rules');
        }

        return AvailableCouponData::collect($coupons);
    }

    protected function getPriceRulesFromShopify(): array
    {
        try {
            return $this
                ->api
                ->getClient()
                ->PriceRule
                ->get();
        } catch (ShopifyNotConnectedException) {
            return [];
        }
    }
}
