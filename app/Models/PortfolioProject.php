<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioProject extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'slug',
        'client_name',
        'client_logo_url',
        'project_type',
        'challenge',
        'solution',
        'result',
        'tech_stack',
        'project_url',
        'demo_url',
        'github_url',
        'cover_image_url',
        'images',
        'video_url',
        'is_featured',
        'is_published',
        'sort_order',
        'meta_title',
        'meta_description',
        'view_count',
        'published_at',
    ];

    protected $casts = [
        'tech_stack' => 'array',
        'images' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'sort_order' => 'integer',
        'view_count' => 'integer',
        'published_at' => 'datetime',
    ];

    // Relationships

    public function testimonials()
    {
        return $this->hasMany(ProjectTestimonial::class, 'project_id');
    }

    // Scopes

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
