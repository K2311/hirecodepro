<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'features',
        'pricing_model',
        'base_rate',
        'estimated_hours',
        'meta_title',
        'meta_description',
        'sort_order',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'base_rate' => 'decimal:2',
        'estimated_hours' => 'integer',
        'sort_order' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getIconClassAttribute()
    {
        $icon = $this->icon ?? 'cog';
        if (str_contains($icon, ' ')) {
            return $icon;
        }

        // List of brand icons that require 'fab' prefix
        $brandIcons = ['wordpress', 'react', 'node', 'js', 'facebook', 'twitter', 'linkedin', 'github', 'laravel', 'python', 'aws', 'docker', 'apple', 'google'];

        $prefix = in_array(strtolower($icon), $brandIcons) ? 'fab' : 'fas';
        return "$prefix fa-$icon";
    }

    // Relationships

    public function packages()
    {
        return $this->hasMany(ServicePackage::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
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
