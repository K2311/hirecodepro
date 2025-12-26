<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'product_id',
        'name',
        'description',
        'price',
        'license_type',
        'features',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'features' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Relationships

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function files()
    {
        return $this->hasMany(ProductFile::class, 'variation_id');
    }

    // Scopes

    public function scopeActive($query)
    {
        return $this->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
