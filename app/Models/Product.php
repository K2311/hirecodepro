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
        'features',
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
        'view_count' => 'integer',
        'download_count' => 'integer',
        'purchase_count' => 'integer',
        'average_rating' => 'decimal:2',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Remove tech_stack and preview_images from casts
    // We'll handle them with custom accessors/mutators

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

    // ACCESSORS
    public function getTechStackAttribute($value)
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) && !empty($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $decoded;
            }
            return array_values(array_filter(array_map('trim', explode("\n", str_replace(',', "\n", $value)))));
        }

        return [];
    }

    public function getPreviewImagesAttribute($value)
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) && !empty($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    // MUTATORS
    public function setTechStackAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['tech_stack'] = json_encode(array_values($value));
        } elseif (is_string($value) && !empty($value)) {
            // If it's already JSON, keep it; otherwise parse it
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                $this->attributes['tech_stack'] = $value;
            } else {
                $parsed = array_values(array_filter(array_map('trim', explode("\n", str_replace(',', "\n", $value)))));
                $this->attributes['tech_stack'] = json_encode($parsed);
            }
        } else {
            $this->attributes['tech_stack'] = json_encode([]);
        }
    }

    public function setPreviewImagesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['preview_images'] = json_encode(array_values($value));
        } elseif (is_string($value)) {
            $this->attributes['preview_images'] = $value;
        } else {
            $this->attributes['preview_images'] = json_encode([]);
        }
    }

    public function getFeaturesAttribute($value)
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) && !empty($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $decoded;
            }
            // Fallback for raw strings (either newline or comma separated)
            return array_values(array_filter(array_map('trim', explode("\n", str_replace(',', "\n", $value)))));
        }

        return [];
    }

    public function getDependenciesAttribute($value)
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) && !empty($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $decoded;
            }
            return array_values(array_filter(array_map('trim', explode("\n", str_replace(',', "\n", $value)))));
        }

        return [];
    }

    public function setFeaturesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['features'] = json_encode(array_values($value));
        } elseif (is_string($value) && !empty($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                $this->attributes['features'] = $value;
            } else {
                $parsed = array_values(array_filter(array_map('trim', explode("\n", str_replace(',', "\n", $value)))));
                $this->attributes['features'] = json_encode($parsed);
            }
        } else {
            $this->attributes['features'] = json_encode([]);
        }
    }

    public function setDependenciesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['dependencies'] = json_encode(array_values($value));
        } elseif (is_string($value) && !empty($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                $this->attributes['dependencies'] = $value;
            } else {
                $parsed = array_values(array_filter(array_map('trim', explode("\n", str_replace(',', "\n", $value)))));
                $this->attributes['dependencies'] = json_encode($parsed);
            }
        } else {
            $this->attributes['dependencies'] = json_encode([]);
        }
    }

    // Additional computed attributes
    public function getGalleryCountAttribute()
    {
        return count($this->preview_images);
    }

    public function getTechStackCountAttribute()
    {
        return count($this->tech_stack);
    }

    // Current price accessor
    public function getCurrentPriceAttribute()
    {
        return $this->is_on_sale && $this->sale_price
            ? $this->sale_price
            : $this->base_price;
    }

    // Scopes remain the same...
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
}