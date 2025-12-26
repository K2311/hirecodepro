<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'product_id',
        'name',
        'email',
        'company',
        'phone',
        'subject',
        'message',
        'inquiry_type',
        'status',
        'assigned_to',
        'source_page',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    // Relationships

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function emailConversations()
    {
        return $this->hasMany(EmailConversation::class, 'inquiry_id');
    }

    // Scopes

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeUnread($query)
    {
        return $query->where('status', 'new');
    }
}
