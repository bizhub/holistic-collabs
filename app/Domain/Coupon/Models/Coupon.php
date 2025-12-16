<?php

namespace Domain\Coupon\Models;

use Database\Factories\CouponFactory;
use Domain\Clinic\Models\Clinic;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coupon extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'code',
        'shopify_id',
    ];

    protected static function newFactory(): CouponFactory
    {
        return CouponFactory::new();
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }
}
