<?php

namespace Domain\Shopify\Actions;

use Domain\Client\Models\Client;
use Domain\Clinic\Models\Clinic;
use Domain\Commission\Actions\CreateCommissionAction;
use Domain\Shopify\Data\ShopifyWebhookData;

class HandleOrderCreatedWebhookAction
{
    public function __construct(
        protected CreateCommissionAction $createCommission,
    ) {
    }

    public function execute(ShopifyWebhookData $data)
    {
        $email = $data->email();
        $coupon = $data->coupon();

        $client = $this->findClientByEmail($email);

        if ($client) {
            return $this->createCommission->execute($client->clinic, $data);
        }

        $clinic = $this->findClinicByCoupon($coupon);

        if (! $clinic) {
            return;
        }

        $client = $this->createClient($email, $clinic);

        return $this->createCommission->execute($clinic, $data);
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
