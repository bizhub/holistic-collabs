<?php

use Domain\Client\Models\Client;
use Domain\Clinic\Models\Clinic;
use Domain\Commission\Enums\CommissionStatus;
use Domain\Commission\Models\Commission;
use Domain\Coupon\Models\Coupon;
use Domain\Order\Models\Order;
use Domain\Shopify\Actions\HandleOrderCreatedWebhookAction;
use Domain\Shopify\Data\OrderCreatedWebhookData;

it('handles first time customer with a known coupon', function () {
    $clinic = Clinic::factory()->create([
        'commission_rate' => 10,
    ]);

    Coupon::factory()->create([
        'code' => 'REF123',
        'clinic_id' => $clinic->id,
    ]);

    $data = OrderCreatedWebhookData::from([
        'id' => 6249589899403,
        'customer' => [
            'id' => 8804926455947,
            'email' => 'lex@bizhub.co.nz',
            'first_name' => 'Lex',
            'last_name' => 'van der Woude',
            'phone' => 1234567890,
        ],
        'order_number' => 1234,
        'order_status_url' => '::order_status_url::',
        'discount_codes' => [
            [
                'code' => 'REF123',
                'type' => 'fixed_amount',
                'amount' => '20.00',
            ],
        ],
        'total_line_items_price' => '1000.00',
    ]);

    app(HandleOrderCreatedWebhookAction::class)->execute($data);

    expect(Client::count())->toBe(1);
    expect(Order::count())->toBe(1);
    expect(Commission::count())->toBe(1);

    $client = Client::first();
    $order = Order::first();
    $commission = Commission::first();

    expect($client)
        ->clinic_id->toBe($clinic->id)
        ->shopify_id->toBe('8804926455947')
        ->name->toBe('Lex van der Woude')
        ->email->toBe('lex@bizhub.co.nz');

    expect($order)
        ->clinic_id->toBe($clinic->id)
        ->client_id->toBe($client->id)
        ->shopify_id->toBe('6249589899403')
        ->coupon_code->toBe('REF123')
        ->subtotal_price->toBe(1000);

    expect($commission)
        ->clinic_id->toBe($clinic->id)
        ->client_id->toBe($client->id)
        ->order_id->toBe($order->id)
        ->status->toBe(CommissionStatus::Pending)
        ->commission_rate->toBe(10)
        ->coupon_amount->toBe(20)
        ->amount->toBe(80);
});

it('handles existing client without coupon', function () {
    $clinic = Clinic::factory()->create([
        'commission_rate' => 10,
    ]);

    Coupon::factory()->create([
        'code' => 'REF123',
        'clinic_id' => $clinic->id,
    ]);

    $client = Client::factory()->create([
        'clinic_id' => $clinic->id,
        'shopify_id' => '8804926455947',
        'name' => 'Lex van der Woude',
        'email' => 'lex@bizhub.co.nz',
    ]);

    $data = OrderCreatedWebhookData::from([
        'id' => 6249589899403,
        'customer' => [
            'id' => 8804926455947,
            'email' => 'lex@bizhub.co.nz',
            'first_name' => 'Lex',
            'last_name' => 'van der Woude',
            'phone' => 1234567890,
        ],
        'order_number' => 1234,
        'order_status_url' => '::order_status_url::',
        'discount_codes' => [],
        'total_line_items_price' => '1000.00',
    ]);

    app(HandleOrderCreatedWebhookAction::class)->execute($data);

    expect(Client::count())->toBe(1);
    expect(Order::count())->toBe(1);
    expect(Commission::count())->toBe(1);

    $client = Client::first();
    $order = Order::first();
    $commission = Commission::first();

    expect($client)
        ->clinic_id->toBe($clinic->id)
        ->shopify_id->toBe('8804926455947')
        ->name->toBe('Lex van der Woude')
        ->email->toBe('lex@bizhub.co.nz');

    expect($order)
        ->clinic_id->toBe($clinic->id)
        ->client_id->toBe($client->id)
        ->shopify_id->toBe('6249589899403')
        ->coupon_code->toBeNull()
        ->subtotal_price->toBe(1000);

    expect($commission)
        ->clinic_id->toBe($clinic->id)
        ->client_id->toBe($client->id)
        ->order_id->toBe($order->id)
        ->status->toBe(CommissionStatus::Pending)
        ->commission_rate->toBe(10)
        ->coupon_amount->toBe(0)
        ->amount->toBe(100);
});

it('handles existing client with known coupon attached a different clinic', function () {
    $clinic = Clinic::factory()->create([
        'commission_rate' => 10,
    ]);

    Coupon::factory()->create([
        'code' => 'REF123',
        'clinic_id' => $clinic->id,
    ]);

    $client = Client::factory()->create([
        'shopify_id' => '8804926455947',
        'name' => 'Lex van der Woude',
        'email' => 'lex@bizhub.co.nz',
    ]);

    $data = OrderCreatedWebhookData::from([
        'id' => 6249589899403,
        'customer' => [
            'id' => 8804926455947,
            'email' => 'lex@bizhub.co.nz',
            'first_name' => 'Lex',
            'last_name' => 'van der Woude',
            'phone' => 1234567890,
        ],
        'order_number' => 1234,
        'order_status_url' => '::order_status_url::',
        'discount_codes' => [
            [
                'code' => 'REF123',
                'type' => 'fixed_amount',
                'amount' => '20.00',
            ],
        ],
        'total_line_items_price' => '1000.00',
    ]);

    app(HandleOrderCreatedWebhookAction::class)->execute($data);

    expect(Client::count())->toBe(1);
    expect(Order::count())->toBe(1);
    expect(Commission::count())->toBe(1);

    $client = Client::first();
    $order = Order::first();
    $commission = Commission::first();

    expect($client)
        ->clinic_id->toBe($clinic->id)
        ->shopify_id->toBe('8804926455947')
        ->name->toBe('Lex van der Woude')
        ->email->toBe('lex@bizhub.co.nz');

    expect($order)
        ->clinic_id->toBe($clinic->id)
        ->client_id->toBe($client->id)
        ->shopify_id->toBe('6249589899403')
        ->coupon_code->toBe('REF123')
        ->subtotal_price->toBe(1000);

    expect($commission)
        ->clinic_id->toBe($clinic->id)
        ->client_id->toBe($client->id)
        ->order_id->toBe($order->id)
        ->status->toBe(CommissionStatus::Pending)
        ->commission_rate->toBe(10)
        ->coupon_amount->toBe(20)
        ->amount->toBe(80);
});

it('does not generate negative commission amount', function () {
    $clinic = Clinic::factory()->create([
        'commission_rate' => 10,
    ]);

    Coupon::factory()->create([
        'code' => 'REF123',
        'clinic_id' => $clinic->id,
    ]);

    $data = OrderCreatedWebhookData::from([
        'id' => 6249589899403,
        'customer' => [
            'id' => 8804926455947,
            'email' => 'lex@bizhub.co.nz',
            'first_name' => 'Lex',
            'last_name' => 'van der Woude',
            'phone' => 1234567890,
        ],
        'order_number' => 1234,
        'order_status_url' => '::order_status_url::',
        'discount_codes' => [
            [
                'code' => 'REF123',
                'type' => 'fixed_amount',
                'amount' => '20.00',
            ],
        ],
        'total_line_items_price' => '50.00',
    ]);

    app(HandleOrderCreatedWebhookAction::class)->execute($data);

    expect(Client::count())->toBe(1);
    expect(Order::count())->toBe(1);
    expect(Commission::count())->toBe(0);
});
