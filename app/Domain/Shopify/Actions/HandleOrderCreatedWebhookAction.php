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

    public function execute(ShopifyWebhookData $data): void
    {
        $email = $data->email();
        $couponCode = $data->coupon();
        $orderTotal = $data->total();

        $client = $this->findClientByEmail($email);
        $coupon = Coupon::query()
            ->with('clinic')
            ->where('code', $couponCode)
            ->first();

        if ($client) {
            if ($coupon) {
                $clinic = $this->findClinicByCoupon($coupon);

                // Client attached to a different clinic?
                if ($clinic && $client->clinic_id !== $clinic->id) {
                    $client->update([
                        'clinic_id' => $clinic->id
                    ]);

                    // TODO: Create order

                    $this->createCommission->execute(
                        clinic: $clinic,
                        coupon: $coupon,
                        orderTotal: $orderTotal,
                        firstTime: true,
                    );

                    return;
                }
            }

            // Client exists without coupon
            $this->createCommission->execute(
                clinic: $clinic,
                coupon: null,
                orderTotal: $orderTotal,
            );

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

        $this->createCommission->execute(
            clinic: $clinic,
            coupon: $coupon,
            orderTotal: $orderTotal,
            firstTime: true,
        );
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
