<?php

namespace Domain\Order\Models;

use Domain\Client\Models\Client;
use Domain\Clinic\Models\Clinic;
use Domain\Commission\Models\Commission;
use Domain\Shared\Casts\CentsCast;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'client_id',
        'shopify_id',
        'order_number',
        'coupon_code',
        'subtotal_price',
    ];

    protected function casts(): array
    {
        return [
            'subtotal_price' => CentsCast::class,
        ];
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function commission(): HasOne
    {
        return $this->hasOne(Commission::class);
    }
}
