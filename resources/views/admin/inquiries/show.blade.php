@extends('admin.layouts.app')

@section('title', 'Inquiry Details | CodeCraft Studio')
@section('page-title', 'Inquiry Details')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h1>Inquiry Details</h1>
            <p>From {{ $inquiry->name }} - {{ $inquiry->subject }}</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.inquiries.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Inquiries
            </a>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="col-span-2">
            <!-- Inquiry Details -->
            <div class="card">
                <div class="card-header">
                    <div class="card-header-content">
                        <h3>Inquiry Details</h3>
                        <div class="status-badges">
                            <span class="status-badge status-{{ $inquiry->inquiry_type }}">
                                {{ ucfirst($inquiry->inquiry_type) }}
                            </span>
                            <span class="status-badge status-{{ $inquiry->status }}">
                                {{ ucfirst($inquiry->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="inquiry-content">
                        <div class="inquiry-header">
                            <h4 class="inquiry-subject">{{ $inquiry->subject }}</h4>
                            <div class="inquiry-meta">
                                <span class="meta-item">
                                    <i class="fas fa-calendar"></i>
                                    {{ $inquiry->created_at->format('F d, Y \a\t g:i A') }}
                                </span>
                                @if($inquiry->source_page)
                                    <span class="meta-item">
                                        <i class="fas fa-globe"></i>
                                        {{ $inquiry->source_page }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="inquiry-message">
                            <h5>Message:</h5>
                            <div class="message-content">
                                {!! nl2br(e($inquiry->message)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email Conversations -->
            @if($inquiry->emailConversations->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h3>Email Conversation History</h3>
                    </div>
                    <div class="card-body">
                        <div class="conversation-thread">
                            @foreach($inquiry->emailConversations->sortBy('created_at') as $conversation)
                                <div class="conversation-item {{ $conversation->direction }}">
                                    <div class="conversation-header">
                                        <div class="conversation-sender">
                                            @if($conversation->direction === 'inbound')
                                                <i class="fas fa-inbox"></i>
                                                From: {{ $conversation->from_email }}
                                            @else
                                                <i class="fas fa-paper-plane"></i>
                                                To: {{ $conversation->to_email }}
                                            @endif
                                        </div>
                                        <div class="conversation-date">
                                            {{ $conversation->created_at->format('M d, Y g:i A') }}
                                        </div>
                                    </div>
                                    <div class="conversation-content">
                                        {!! nl2br(e($conversation->message)) !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Reply Form -->
            @if($inquiry->status !== 'closed')
                <div class="card">
                    <div class="card-header">
                        <h3>Send Reply</h3>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.inquiries.reply', $inquiry) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">Reply Message</label>
                                <textarea name="reply_message" class="form-control" rows="6"
                                    placeholder="Enter your reply to {{ $inquiry->name }}..." required></textarea>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Send Reply</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-span-1">
            <!-- Related Product -->
            @if($inquiry->product_id && $inquiry->product)
                <div class="card">
                    <div class="card-header">
                        <h3>Related Product</h3>
                    </div>
                    <div class="card-body">
                        <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                            <div
                                style="width: 80px; height: 60px; border-radius: 8px; overflow: hidden; border: 1px solid var(--border-color);">
                                <img src="{{ $inquiry->product->cover_image_url }}"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div>
                                <h4 style="margin: 0; font-size: 1rem;">{{ $inquiry->product->name }}</h4>
                                <small class="text-muted">{{ ucfirst($inquiry->product->product_type) }}</small>
                            </div>
                        </div>
                        <div class="contact-details">
                            <div class="contact-detail">
                                <label>Price:</label>
                                <span>${{ number_format($inquiry->product->current_price, 2) }}</span>
                            </div>
                            <div class="contact-detail">
                                <label>Total Sales:</label>
                                <span>{{ $inquiry->product->purchase_count }}</span>
                            </div>
                        </div>
                        <div style="margin-top: 20px;">
                            <a href="{{ route('admin.products.edit', $inquiry->product) }}" class="btn btn-secondary btn-sm"
                                style="width: 100%;">
                                <i class="fas fa-edit"></i> Edit Product
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Contact Information -->
            <div class="card">
                <div class="card-header">
                    <h3>Contact Information</h3>
                </div>
                <div class="card-body">
                    <div class="contact-details">
                        <div class="contact-detail">
                            <label>Name:</label>
                            <span>{{ $inquiry->name }}</span>
                        </div>
                        <div class="contact-detail">
                            <label>Email:</label>
                            <span>{{ $inquiry->email }}</span>
                        </div>
                        @if($inquiry->company)
                            <div class="contact-detail">
                                <label>Company:</label>
                                <span>{{ $inquiry->company }}</span>
                            </div>
                        @endif
                        @if($inquiry->phone)
                            <div class="contact-detail">
                                <label>Phone:</label>
                                <span>{{ $inquiry->phone }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Assignment & Status -->
            <div class="card">
                <div class="card-header">
                    <h3>Assignment & Status</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.inquiries.update', $inquiry) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="new" {{ $inquiry->status == 'new' ? 'selected' : '' }}>New</option>
                                <option value="read" {{ $inquiry->status == 'read' ? 'selected' : '' }}>Read</option>
                                <option value="replied" {{ $inquiry->status == 'replied' ? 'selected' : '' }}>Replied</option>
                                <option value="closed" {{ $inquiry->status == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Assigned To</label>
                            <select name="assigned_to" class="form-select">
                                <option value="">Unassigned</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $inquiry->assigned_to == $user->id ? 'selected' : '' }}>
                                        {{ $user->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Internal Notes</label>
                            <textarea name="notes" class="form-control" rows="3"
                                placeholder="Add internal notes...">{{ $inquiry->notes ?? '' }}</textarea>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h3>Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div class="quick-actions">
                        @if($inquiry->status === 'new')
                            <form action="{{ route('admin.inquiries.update', $inquiry) }}" method="POST"
                                class="quick-action-form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="read">
                                <button type="submit" class="btn btn-success btn-sm quick-action-btn">
                                    <i class="fas fa-check"></i>
                                    Mark as Read
                                </button>
                            </form>
                        @endif

                        @if($inquiry->status !== 'closed')
                            <form action="{{ route('admin.inquiries.update', $inquiry) }}" method="POST"
                                class="quick-action-form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="closed">
                                <button type="submit" class="btn btn-warning btn-sm quick-action-btn">
                                    <i class="fas fa-times"></i>
                                    Close Inquiry
                                </button>
                            </form>
                        @endif

                        <button type="button" class="btn btn-info btn-sm quick-action-btn"
                            onclick="window.open('mailto:{{ $inquiry->email }}?subject=Re: {{ urlencode($inquiry->subject) }}')">
                            <i class="fas fa-envelope"></i>
                            Open in Email Client
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .inquiry-content {
            line-height: 1.6;
        }

        .inquiry-subject {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--light-text);
            margin-bottom: 12px;
        }

        .inquiry-meta {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
            font-size: 0.875rem;
            color: var(--light-muted);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .inquiry-message h5 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--light-text);
        }

        .message-content {
            background-color: rgba(0, 0, 0, 0.02);
            padding: 16px;
            border-radius: var(--border-radius);
            border-left: 4px solid var(--primary);
            white-space: pre-wrap;
        }

        .conversation-thread {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .conversation-item {
            border: 1px solid var(--light-border);
            border-radius: var(--border-radius);
            padding: 16px;
        }

        .conversation-item.inbound {
            background-color: rgba(59, 130, 246, 0.05);
            border-color: rgba(59, 130, 246, 0.2);
        }

        .conversation-item.outbound {
            background-color: rgba(16, 185, 129, 0.05);
            border-color: rgba(16, 185, 129, 0.2);
        }

        .conversation-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 0.875rem;
        }

        .conversation-sender {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
        }

        .conversation-date {
            color: var(--light-muted);
        }

        .conversation-content {
            white-space: pre-wrap;
            line-height: 1.5;
        }

        .contact-details {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .contact-detail {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .contact-detail label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--light-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .contact-detail span {
            font-size: 0.875rem;
            color: var(--light-text);
        }

        .quick-actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .quick-action-form {
            display: block;
        }

        .quick-action-btn {
            width: 100%;
            margin-bottom: 8px;
        }

        .quick-action-btn:last-child {
            margin-bottom: 0;
        }

        .unread-row {
            background-color: rgba(59, 130, 246, 0.05);
        }

        .new-badge {
            background-color: var(--danger);
            color: white;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-left: 8px;
        }

        .subject-cell {
            display: flex;
            align-items: center;
        }

        .subject-text {
            flex: 1;
        }

        .type-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .type-general {
            background-color: rgba(156, 163, 175, 0.1);
            color: #6b7280;
        }

        .type-service {
            background-color: rgba(59, 130, 246, 0.1);
            color: var(--primary);
        }

        .type-support {
            background-color: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .type-partnership {
            background-color: rgba(139, 92, 246, 0.1);
            color: var(--secondary);
        }

        .contact-cell {
            display: flex;
            align-items: center;
        }

        .contact-info {
            line-height: 1.4;
        }

        .contact-name {
            font-weight: 600;
            color: var(--light-text);
        }

        .contact-email {
            font-size: 0.8rem;
            color: var(--light-muted);
        }

        .contact-company {
            font-size: 0.8rem;
            color: #6b7280;
        }

        .assignee-info {
            font-size: 0.8rem;
        }

        .assignee-name {
            font-weight: 500;
        }

        .stats-summary {
            display: flex;
            gap: 16px;
        }

        .stat-item {
            text-align: center;
            padding: 8px 12px;
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: var(--border-radius);
        }

        .stat-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
            display: block;
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--light-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Modal Styles */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
        }

        .modal-backdrop {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: var(--light-card);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow: hidden;
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--light-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 1.125rem;
            font-weight: 600;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--light-muted);
        }

        .modal-body {
            padding: 24px;
            max-height: 400px;
            overflow-y: auto;
        }

        .modal-footer {
            padding: 20px 24px;
            border-top: 1px solid var(--light-border);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
    </style>
@endpush