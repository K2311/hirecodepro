<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'session_id',
        'page_path',
        'page_title',
        'referrer',
        'device_type',
        'browser',
        'os',
        'country',
        'ip_address',
        'user_agent',
        'is_bot',
    ];

    protected $casts = [
        'is_bot' => 'boolean',
    ];

    // Scopes

    public function scopeRealUsers($query)
    {
        return $query->where('is_bot', false);
    }
}
