<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversionEvent extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'session_id',
        'event_type',
        'event_data',
        'page_path',
        'client_id',
    ];

    protected $casts = [
        'event_data' => 'array',
    ];

    // Relationships

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
