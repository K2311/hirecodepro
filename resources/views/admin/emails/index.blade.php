@extends('admin.layouts.app')

@section('title', 'Email Logs | CodeCraft Studio')
@section('page-title', 'Email Communications')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h1>Email Communications</h1>
            <p>View and manage all outbound and inbound email logs</p>
        </div>
        <div class="page-actions">
            <div class="stats-summary">
                <div class="stat-item">
                    <span class="stat-value text-primary">{{ $emails->where('direction', 'outgoing')->count() }}</span>
                    <span class="stat-label">Outgoing</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value text-success">{{ $emails->where('direction', 'incoming')->count() }}</span>
                    <span class="stat-label">Incoming</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-bottom: 24px;">
        <div class="card-body">
            <div class="tabs-container">
                <a href="{{ route('admin.emails.index') }}" class="tab-link active">Email History</a>
                <a href="{{ route('admin.emails.templates') }}" class="tab-link">Email Templates</a>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card" style="margin-bottom: 24px;">
        <div class="card-body">
            <form action="{{ route('admin.emails.index') }}" method="GET" class="filters-form">
                <div class="form-group" style="flex: 2;">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by subject, email, or content" class="form-control search-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Direction</label>
                    <select name="direction" class="form-select">
                        <option value="">All Directions</option>
                        <option value="outgoing" {{ request('direction') == 'outgoing' ? 'selected' : '' }}>Outgoing</option>
                        <option value="incoming" {{ request('direction') == 'incoming' ? 'selected' : '' }}>Incoming</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="filter-actions" style="margin-top: 25px;">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        @if(request()->hasAny(['search', 'direction', 'status']))
                            <a href="{{ route('admin.emails.index') }}" class="btn btn-secondary">Reset</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Emails Table -->
    <div class="card">
        <div class="card-header">
            <h3>Email History ({{ $emails->total() }})</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Direction</th>
                        <th>Contact</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($emails as $email)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $email->created_at->format('M d, Y') }}</div>
                                <div class="small text-muted">{{ $email->created_at->format('H:i A') }}</div>
                            </td>
                            <td>
                                @if($email->direction === 'outgoing')
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        <i class="fas fa-paper-plane me-1"></i> Outgoing
                                    </span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success">
                                        <i class="fas fa-inbox me-1"></i> Incoming
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-info">
                                        <div class="user-name">
                                            @if($email->direction === 'outgoing')
                                                To: {{ $email->to_email }}
                                            @else
                                                From: {{ $email->from_email }}
                                            @endif
                                        </div>
                                        @if($email->client)
                                            <div class="user-email small text-primary">
                                                <i class="fas fa-user-circle me-1"></i> {{ $email->client->full_name }}
                                            </div>
                                        @elseif($email->inquiry)
                                            <div class="user-email small text-info">
                                                <i class="fas fa-info-circle me-1"></i> Inquiry #{{ substr($email->inquiry_id, 0, 8) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 300px;">
                                    {{ $email->subject }}
                                </div>
                            </td>
                            <td>
                                @switch($email->status)
                                    @case('sent')
                                        <span class="status-badge status-active">Sent</span>
                                        @break
                                    @case('delivered')
                                        <span class="status-badge status-published">Delivered</span>
                                        @break
                                    @case('read')
                                        <span class="badge bg-info bg-opacity-10 text-info">Read</span>
                                        @break
                                    @case('failed')
                                        <span class="status-badge status-failed">Failed</span>
                                        @break
                                    @default
                                        <span class="status-badge">{{ ucfirst($email->status) }}</span>
                                @endswitch
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.emails.show', $email) }}" class="btn btn-sm btn-outline-primary" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.emails.destroy', $email) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this log entry?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Log">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <i class="fas fa-envelope-open-text"></i>
                                <h3>No email logs found</h3>
                                <p>There are no email communications matching your criteria.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($emails->hasPages())
            <div class="card-footer">
                {{ $emails->links() }}
            </div>
        @endif
    </div>

    <style>
        .stats-summary {
            display: flex;
            gap: 20px;
        }
        .stat-item {
            text-align: center;
            background: rgba(0,0,0,0.02);
            padding: 10px 20px;
            border-radius: 12px;
            min-width: 100px;
        }
        body.dark-mode .stat-item {
            background: rgba(255,255,255,0.02);
        }
        .stat-value {
            display: block;
            font-size: 1.5rem;
            font-weight: 800;
        }
        .stat-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.7;
        }
        .filters-form {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: flex-end;
        }
        .filters-form .form-group {
            flex: 1;
            min-width: 150px;
        }

        .tabs-container {
            display: flex;
            gap: 20px;
            border-bottom: 1px solid var(--light-border);
            padding-bottom: 10px;
        }
        .tab-link {
            text-decoration: none;
            color: var(--light-muted);
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .tab-link:hover {
            color: var(--primary-color);
            background: rgba(99, 102, 241, 0.05);
        }
        .tab-link.active {
            color: var(--primary-color);
            background: rgba(99, 102, 241, 0.1);
        }
    </style>
@endsection
