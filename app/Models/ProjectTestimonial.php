<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTestimonial extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'project_id',
        'client_name',
        'client_position',
        'client_company',
        'client_avatar_url',
        'content',
        'rating',
        'is_featured',
        'is_published',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    // Relationships

    public function project()
    {
        return $this->belongsTo(PortfolioProject::class, 'project_id');
    }

    // Scopes

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
