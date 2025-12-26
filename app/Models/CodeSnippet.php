<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeSnippet extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'code',
        'language',
        'tags',
        'meta_title',
        'meta_description',
        'view_count',
        'download_count',
        'is_published',
    ];

    protected $casts = [
        'tags' => 'array',
        'view_count' => 'integer',
        'download_count' => 'integer',
        'is_published' => 'boolean',
    ];

    // Scopes

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
