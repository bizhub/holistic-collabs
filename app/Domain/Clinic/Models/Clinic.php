<?php

namespace Domain\Clinic\Models;

use Database\Factories\ClinicFactory;
use Domain\Client\Models\Client;
use Domain\Commission\Casts\CommissionRateCast;
use Domain\Coupon\Models\Coupon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clinic extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'name',
        'commission_rate',
    ];

    protected function casts(): array
    {
        return [
            'commission_rate' => CommissionRateCast::class,
        ];
    }

    protected static function newFactory(): ClinicFactory
    {
        return ClinicFactory::new();
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }
}
