<?php

namespace Domain\Clinic\Models;

use Domain\Client\Models\Client;
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
    ];

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }
}
