<?php

namespace Domain\Order\Models;

use Domain\Clinic\Models\Clinic;
use Domain\Shared\Casts\CentsCast;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'shopify_id',
        'total_price',
    ];

    protected function casts(): array
    {
        return [
            'total_price' => CentsCast::class,
        ];
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }
}
