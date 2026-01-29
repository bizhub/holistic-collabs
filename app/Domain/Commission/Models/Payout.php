<?php

namespace Domain\Commission\Models;

use Database\Factories\PayoutFactory;
use Domain\Clinic\Models\Clinic;
use Domain\Shared\Casts\CentsCast;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payout extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'paid_until',
        'paid_at',
        'total_amount',
    ];

    protected function casts(): array
    {
        return [
            'paid_until' => 'datetime',
            'paid_at' => 'datetime',
            'total_amount' => CentsCast::class,
        ];
    }

    protected static function newFactory(): PayoutFactory
    {
        return PayoutFactory::new();
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }
}
