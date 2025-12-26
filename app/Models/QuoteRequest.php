<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'client_id',
        'name',
        'email',
        'company',
        'project_type',
        'description',
        'budget_range',
        'timeline',
        'services_needed',
        'status',
        'assigned_to',
        'quoted_amount',
        'notes',
    ];

    protected $casts = [
        'services_needed' => 'array',
        'quoted_amount' => 'decimal:2',
    ];

    // Relationships

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function emailConversations()
    {
        return $this->hasMany(EmailConversation::class, 'quote_request_id');
    }

    // Scopes

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
