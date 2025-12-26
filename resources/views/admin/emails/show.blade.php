@extends('admin.layouts.app')

@section('title', 'Email Details | CodeCraft Studio')
@section('page-title', 'Email Message Details')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <a href="{{ route('admin.emails.index') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to Logs</a>
            <h1>Email Message Details</h1>
        </div>
        <div class="page-actions">
            @if($email->inquiry_id)
                <a href="{{ route('admin.inquiries.show', $email->inquiry_id) }}" class="btn btn-outline-primary">
                    <i class="fas fa-external-link-alt me-2"></i> View Related Inquiry
                </a>
            @endif
            @if($email->order_id)
                <a href="{{ route('admin.orders.show', $email->order_id) }}" class="btn btn-outline-primary">
                    <i class="fas fa-external-link-alt me-2"></i> View Related Order
                </a>
            @endif
        </div>
    </div>

    <div class="email-detail-container">
        <div class="email-sidebar">
            <div class="card">
                <div class="card-header">
                    <h3>Metadata</h3>
                </div>
                <div class="card-body">
                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">Status</span>
                            <span class="info-value">
                                @switch($email->status)
                                    @case('sent') <span class="badge bg-primary">Sent</span> @break
                                    @case('delivered') <span class="badge bg-success">Delivered</span> @break
                                    @case('read') <span class="badge bg-info">Read</span> @break
                                    @case('failed') <span class="badge bg-danger">Failed</span> @break
                                    @default <span class="badge bg-secondary">{{ ucfirst($email->status) }}</span>
                                @endswitch
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Direction</span>
                            <span class="info-value">{{ ucfirst($email->direction) }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date/Time</span>
                            <span class="info-value">{{ $email->created_at->format('M d, Y H:i:s') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Message ID</span>
                            <span class="info-value small text-muted text-break">{{ $email->message_id ?? 'N/A' }}</span>
                        </div>
                    </div>

                    @if($email->headers)
                        <div class="mt-4">
                            <button class="btn btn-sm btn-outline-secondary w-100" type="button" onclick="document.getElementById('headers-block').classList.toggle('hidden')">
                                Toggle Technical Headers
                            </button>
                            <div id="headers-block" class="hidden mt-2 p-2 bg-light rounded small text-break" style="font-family: monospace; max-height: 200px; overflow-y: auto;">
                                <pre>{{ json_encode($email->headers, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="email-main">
            <div class="card hero-card">
                <div class="card-body">
                    <div class="email-header-info">
                        <h2>{{ $email->subject }}</h2>
                        <div class="email-participants">
                            <div class="participant">
                                <span class="label">From:</span>
                                <span class="value fw-bold text-primary">{{ $email->from_email }}</span>
                            </div>
                            <div class="participant">
                                <span class="label">To:</span>
                                <span class="value fw-bold text-primary">{{ $email->to_email }}</span>
                            </div>
                            @if(!empty($email->cc_emails))
                                <div class="participant">
                                    <span class="label">CC:</span>
                                    <span class="value">{{ implode(', ', $email->cc_emails) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="email-body">
                        @if($email->body_html)
                            <div class="html-content-wrapper p-4 border rounded bg-white">
                                {!! $email->body_html !!}
                            </div>
                        @else
                            <div class="text-content-wrapper p-4 border rounded bg-light whitespace-pre-wrap">
                                {{ $email->body_text }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .email-detail-container {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 24px;
            align-items: start;
        }

        @media (max-width: 992px) {
            .email-detail-container {
                grid-template-columns: 1fr;
            }
        }

        .email-header-info {
            border-bottom: 1px solid var(--light-border);
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .email-participants {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 15px;
        }

        .participant .label {
            display: inline-block;
            width: 60px;
            color: var(--light-muted);
            font-size: 0.875rem;
        }

        .whitespace-pre-wrap {
            white-space: pre-wrap;
        }

        .html-content-wrapper {
            min-height: 300px;
            overflow-x: auto;
        }
        
        body.dark-mode .html-content-wrapper {
            background: #fff; /* Most emails are designed for white background */
            color: #000;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 8px;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }

        .info-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .info-item .info-label {
            display: block;
            font-size: 0.75rem;
            color: var(--light-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-item .info-value {
            display: block;
            font-weight: 500;
        }

        .hidden {
            display: none;
        }
    </style>
@endsection
