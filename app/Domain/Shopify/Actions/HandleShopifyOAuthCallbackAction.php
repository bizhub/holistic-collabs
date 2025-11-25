<?php

namespace Domain\Shopify\Actions;

use Domain\Integration\Enums\ConnectionStatus;
use Domain\Integration\Enums\Provider;
use Domain\Integration\Models\IntegrationConnection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HandleShopifyOAuthCallbackAction
{
    public function execute(Request $request): IntegrationConnection
    {
        $requestData = $request->all();

        $token = $this
            ->verifyState($requestData)
            ->verifyHmac($requestData)
            ->exchangeCodeForAccessToken($requestData);

        return $this->createConnection($requestData, $token);
    }

    protected function verifyState(array $requestData): self
    {
        $state = session('shopify_oauth_state');
        if ($state !== $requestData['state']) {
            abort(403, 'Invalid OAuth state');
        }

        return $this;
    }

    protected function verifyHmac(array $requestData)
    {
        $params = $requestData;

        $hmac = $params['hmac'];
        unset($params['signature'], $params['hmac']);
        ksort($params);
        $computed = hash_hmac('sha256', urldecode(http_build_query($params)), config('services.shopify.client_secret'));
        if (!hash_equals($hmac, $computed)) {
            abort(403, 'Invalid HMAC signature');
        }

        return $this;
    }

    protected function exchangeCodeForAccessToken(array $requestData): mixed
    {
        $response = Http::asForm()->post("https://{$requestData['shop']}/admin/oauth/access_token", [
            'client_id' => config('services.shopify.client_id'),
            'client_secret' => config('services.shopify.client_secret'),
            'code' => $requestData['code'],
        ]);

        return $response->json();
    }

    protected function createConnection(array $requestData, array $token): IntegrationConnection
    {
        return IntegrationConnection::updateOrCreate(
            [
                'account_id' => $this->accountContext->currentAccountId(),
                'provider' => Provider::Shopify,
                'credentials->shop' => $requestData['shop'],
            ],
            [
                'credentials' => [
                    'shop' => $requestData['shop'],
                    'access_token' => $token['access_token'],
                    'scope' => $token['scope'] ?? null,
                ],
                'status' => ConnectionStatus::Active,
                'connected_at' => now(),
            ]
        );
    }
}
