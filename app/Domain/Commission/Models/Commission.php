<?php

namespace Domain\Commission\Models;

use Database\Factories\CommissionFactory;
use Domain\Client\Models\Client;
use Domain\Clinic\Models\Clinic;
use Domain\Commission\Casts\CommissionRateCast;
use Domain\Commission\Enums\CommissionStatus;
use Domain\Coupon\Models\Coupon;
use Domain\Order\Models\Order;
use Domain\Shared\Casts\CentsCast;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Commission extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'client_id',
        'order_id',
        'coupon_id',
        'payout_id',
        'status',
        'commission_rate',
        'coupon_amount',
        'amount',
    ];

    protected function casts(): array
    {
        return [
            'status' => CommissionStatus::class,
            'commission_rate' => CommissionRateCast::class,
            'coupon_amount' => CentsCast::class,
            'amount' => CentsCast::class,
        ];
    }

    protected static function newFactory(): CommissionFactory
    {
        return CommissionFactory::new();
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }
}
