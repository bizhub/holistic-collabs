<?php

namespace Domain\Shopify\Actions;

use Domain\Client\Models\Client;
use Domain\Clinic\Models\Clinic;
use Domain\Commission\Actions\CreateCommissionAction;
use Domain\Coupon\Models\Coupon;
use Domain\Shopify\Data\ShopifyWebhookData;

class HandleOrderCreatedWebhookAction
{
    public function __construct(
        protected CreateCommissionAction $createCommission,
    ) {}

    public function execute(ShopifyWebhookData $data)
    {
        $email = $data->email();
        $couponCode = $data->coupon();
        $orderTotal = $data->total(); // in cents or main unit

        $client = $this->findClientByEmail($email);
        $coupon = Coupon::query()
            ->with('clinic')
            ->where('code', $couponCode)
            ->first();

        if ($client) {
            // Client exists
            if ($coupon) {
                $clinic = $this->findClinicByCoupon($coupon);
                if ($clinic && $client->clinic_id !== $clinic->id) {
                    // Client switching clinics via coupon
                    $client->update(['clinic_id' => $clinic->id]);
                    $this->createCommission->execute($clinic, $orderTotal, $coupon, firstTime: true);
                    return;
                }
            }

            $clinic = $client->clinic;
            $this->createCommission->execute($clinic, $orderTotal, null, firstTime: false);
            return;
        }

        // No client exists
        if (! $coupon) {
            // No referral, skip everything
            return;
        }

        // Client referred via coupon
        $clinic = $this->findClinicByCoupon($coupon);
        if (! $clinic) {
            return;
        }

        $client = $this->createClient($email, $clinic);
        $this->createCommission->execute($clinic, $orderTotal, $coupon, firstTime: true);
    }

    protected function findClientByEmail(?string $email): ?Client
    {
        return $email
            ? Client::where('email', $email)->first()
            : null;
    }

    protected function findClinicByCoupon(?string $code): ?Clinic
    {
        if (! $code) {
            return null;
        }

        return Clinic::whereHas('coupons', function ($query) use ($code) {
            $query->where('code', $code);
        })->first();
    }

    protected function createClient(?string $email, Clinic $clinic): Client
    {
        return Client::create([
            'email' => $email,
            'clinic_id' => $clinic->id,
        ]);
    }
}
