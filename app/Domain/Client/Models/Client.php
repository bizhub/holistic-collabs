<?php

namespace Domain\Client\Models;

use Domain\Clinic\Models\Clinic;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
    ];

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }
}
