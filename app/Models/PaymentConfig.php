<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentConfig extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'provider',
        'is_active',
        'config_data',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'config_data' => 'array',
        'provider' => 'string',
    ];

    /**
     * Get the payment provider name.
     */
    public function getProviderNameAttribute()
    {
        return ucfirst($this->provider);
    }
}
