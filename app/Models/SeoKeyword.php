<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoKeyword extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'keyword',
        'target_page',
        'current_rank',
        'best_rank',
        'search_volume',
        'difficulty',
        'is_tracking',
        'last_checked',
    ];

    protected $casts = [
        'current_rank' => 'integer',
        'best_rank' => 'integer',
        'search_volume' => 'integer',
        'difficulty' => 'integer',
        'is_tracking' => 'boolean',
        'last_checked' => 'date',
    ];

    // Scopes

    public function scopeTracking($query)
    {
        return $query->where('is_tracking', true);
    }
}
