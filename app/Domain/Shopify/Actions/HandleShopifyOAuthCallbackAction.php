<?php

namespace Domain\Shopify\Actions;

use Domain\Shopify\Data\ShopifyOAuthData;
use Domain\Shopify\Enums\ConnectionStatus;
use Domain\Shopify\Models\ShopifyConnection;
use Illuminate\Support\Facades\Http;

class HandleShopifyOAuthCallbackAction
{
    public function execute(ShopifyOAuthData $data): ShopifyConnection
    {
        $this
            ->verifyState($data)
            ->verifyHmac($data);

        $tokenData = $this->exchangeCodeForAccessToken($data);

        return ShopifyConnection::updateOrCreate([
            'url' => $data->shop,
        ], [
            'status'       => ConnectionStatus::Active,
            'access_token' => $tokenData['access_token'],
            'scope'        => $tokenData['scope'] ?? null,
        ]);
    }

    protected function verifyState(ShopifyOAuthData $data): self
    {
        $state = session('shopify_oauth_state');
        if ($state !== $data->state) {
            abort(403, 'Invalid OAuth state');
        }

        return $this;
    }

    protected function verifyHmac(ShopifyOAuthData $data): self
    {
        $params = [
            'code'  => $data->code,
            'shop'  => $data->shop,
            'state' => $data->state,
        ];

        ksort($params);
        $computed = hash_hmac(
            'sha256',
            http_build_query($params),
            config('services.shopify.client_secret'),
        );

        if (!hash_equals($data->hmac, $computed)) {
            abort(403, 'Invalid HMAC signature');
        }

        return $this;
    }

    protected function exchangeCodeForAccessToken(ShopifyOAuthData $data): array
    {
        $response = Http::asForm()->post("https://{$data->shop}/admin/oauth/access_token", [
            'client_id'     => config('services.shopify.client_id'),
            'client_secret' => config('services.shopify.client_secret'),
            'code'          => $data->code,
        ]);

        if (!$response->successful()) {
            abort(500, 'Failed to exchange access token');
        }

        return $response->json();
    }
}
