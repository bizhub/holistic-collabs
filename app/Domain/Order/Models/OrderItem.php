<?php

namespace Domain\Order\Models;

use Database\Factories\OrderFactory;
use Domain\Client\Models\Client;
use Domain\Clinic\Models\Clinic;
use Domain\Commission\Models\Commission;
use Domain\Shared\Casts\CentsCast;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'shopify_product_id',
        'name',
        'quantity',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'price' => CentsCast::class,
        ];
    }

    // protected static function newFactory(): OrderFactory
    // {
    //     return OrderFactory::new();
    // }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
