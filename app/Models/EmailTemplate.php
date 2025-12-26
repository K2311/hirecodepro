<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'template_key',
        'name',
        'subject',
        'body_html',
        'body_text',
        'variables',
        'category',
        'is_active',
    ];

    protected $casts = [
        'variables' => 'array',
        'is_active' => 'boolean',
    ];

    // Scopes

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
