<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'full_description',
        'category_id',
        'product_type',
        'base_price',
        'sale_price',
        'cost_price',
        'is_featured',
        'is_on_sale',
        'status',
        'tech_stack',
        'dependencies',
        'requirements',
        'version',
        'changelog',
        'cover_image_url',
        'demo_url',
        'documentation_url',
        'github_url',
        'preview_images',
        'license_type',
        'license_terms',
        'view_count',
        'download_count',
        'purchase_count',
        'average_rating',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'created_by',
        'published_at',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_on_sale' => 'boolean',
        'tech_stack' => 'array',
        'preview_images' => 'array',
        'view_count' => 'integer',
        'download_count' => 'integer',
        'purchase_count' => 'integer',
        'average_rating' => 'decimal:2',
        'published_at' => 'datetime',
    ];

    // Relationships

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function files()
    {
        return $this->hasMany(ProductFile::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOnSale($query)
    {
        return $query->where('is_on_sale', true);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'active')
            ->whereNotNull('published_at');
    }

    // Accessors

    public function getCurrentPriceAttribute()
    {
        return $this->is_on_sale && $this->sale_price
            ? $this->sale_price
            : $this->base_price;
    }
}
