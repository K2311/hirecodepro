<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailConversation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'thread_id',
        'client_id',
        'inquiry_id',
        'quote_request_id',
        'order_id',
        'subject',
        'from_email',
        'to_email',
        'cc_emails',
        'bcc_emails',
        'body_text',
        'body_html',
        'direction',
        'status',
        'message_id',
        'references_ids',
        'headers',
    ];

    protected $casts = [
        'cc_emails' => 'array',
        'bcc_emails' => 'array',
        'references_ids' => 'array',
        'headers' => 'array',
    ];

    // Relationships

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function inquiry()
    {
        return $this->belongsTo(ContactInquiry::class, 'inquiry_id');
    }

    public function quoteRequest()
    {
        return $this->belongsTo(QuoteRequest::class, 'quote_request_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Scopes

    public function scopeIncoming($query)
    {
        return $query->where('direction', 'incoming');
    }

    public function scopeOutgoing($query)
    {
        return $query->where('direction', 'outgoing');
    }
}
