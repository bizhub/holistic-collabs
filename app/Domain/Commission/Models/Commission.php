<?php

namespace Domain\Commission\Models;

use Database\Factories\CommissionFactory;
use Domain\Client\Models\Client;
use Domain\Clinic\Models\Clinic;
use Domain\Commission\Enums\CommissionStatus;
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
        'status',
        'amount',
    ];

    protected function casts(): array
    {
        return [
            'status' => CommissionStatus::class,
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
}
