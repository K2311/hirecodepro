<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'email',
        'full_name',
        'company',
        'position',
        'phone',
        'country',
        'website',
        'source',
        'status',
        'tags',
        'notes',
        'metadata',
        'is_subscribed',
    ];

    protected $casts = [
        'tags' => 'array',
        'metadata' => 'array',
        'is_subscribed' => 'boolean',
    ];

    // Relationships

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function quoteRequests()
    {
        return $this->hasMany(QuoteRequest::class);
    }

    public function emailConversations()
    {
        return $this->hasMany(EmailConversation::class);
    }

    public function conversionEvents()
    {
        return $this->hasMany(ConversionEvent::class);
    }

    // Scopes

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeSubscribed($query)
    {
        return $query->where('is_subscribed', true);
    }
}
