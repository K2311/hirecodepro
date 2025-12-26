<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFile extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'product_id',
        'variation_id',
        'file_name',
        'file_path',
        'file_size',
        'file_type',
        'version',
        'is_main_file',
        'download_count',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'is_main_file' => 'boolean',
        'download_count' => 'integer',
    ];

    // Relationships

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    // Methods

    public function incrementDownloadCount()
    {
        $this->increment('download_count');
    }
}
