@extends('admin.layouts.app')

@section('title', 'Quote Requests | CodeCraft Studio')
@section('page-title', 'Quote Requests')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h1>Quote Requests</h1>
            <p>Manage project inquiries and price quotes</p>
        </div>
        <div class="page-actions">
            <div class="stats-summary">
                <div class="stat-item">
                    <span class="stat-value text-primary">{{ $quotes->where('status', 'new')->count() }}</span>
                    <span class="stat-label">New</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value text-warning">{{ $quotes->where('status', 'quoted')->count() }}</span>
                    <span class="stat-label">Quoted</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value text-success">{{ $quotes->where('status', 'accepted')->count() }}</span>
                    <span class="stat-label">Accepted</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.quotes.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <div class="search-input">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" class="form-control"
                            placeholder="Search by name, email, project..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                        <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                        <option value="quoted" {{ request('status') == 'quoted' ? 'selected' : '' }}>Quoted</option>
                        <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="assigned_to" class="form-select">
                        <option value="">All Assignees</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('assigned_to') == $user->id ? 'selected' : '' }}>
                                {{ $user->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-secondary">Filter</button>
                </div>
                @if(request()->hasAny(['search', 'status', 'assigned_to']))
                    <div class="col-md-1 d-grid">
                        <a href="{{ route('admin.quotes.index') }}" class="btn btn-link text-muted">Reset</a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Bulk Actions Form -->
    <form id="bulk-action-form" action="{{ route('admin.quotes.bulk-update') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="action" id="bulk-action">
        <input type="hidden" name="assigned_to" id="bulk-assigned-to">
    </form>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Quotes List ({{ $quotes->total() }})</h3>
            <div id="bulk-actions" style="display: none;">
                <div class="d-flex gap-2">
                    <select id="bulk-action-select" class="form-select form-select-sm" style="width: 150px;">
                        <option value="">Bulk Actions</option>
                        <option value="mark_contacted">Mark Contacted</option>
                        <option value="mark_quoted">Mark Quoted</option>
                        <option value="mark_archived">Mark Archived</option>
                        <option value="assign">Assign To</option>
                    </select>
                    <select id="assign-user-select" class="form-select form-select-sm" style="width: 150px; display: none;">
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                        @endforeach
                    </select>
                    <button type="button" id="apply-bulk-action" class="btn btn-primary btn-sm">Apply</button>
                    <button type="button" id="cancel-bulk-action" class="btn btn-secondary btn-sm">Cancel</button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;"><input type="checkbox" id="select-all"></th>
                            <th>Client Info</th>
                            <th>Project Details</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Assigned</th>
                            <th>Date</th>
                            <th style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quotes as $quote)
                            <tr class="{{ $quote->status === 'new' ? 'unread-row' : '' }}">
                                <td><input type="checkbox" class="quote-checkbox" value="{{ $quote->id }}"></td>
                                <td>
                                    <div class="fw-bold">{{ $quote->name }}</div>
                                    <div class="small text-muted">{{ $quote->email }}</div>
                                    @if($quote->company)
                                    <div class="small text-muted">{{ $quote->company }}</div> @endif
                                </td>
                                <td>
                                    <div class="fw-medium">{{ $quote->project_type }}</div>
                                    <div class="small text-truncate" style="max-width: 200px;">{{ $quote->description }}</div>
                                </td>
                                <td>
                                    @if($quote->quoted_amount)
                                        <div class="fw-bold text-success">${{ number_format($quote->quoted_amount, 2) }}</div>
                                    @else
                                        <span class="text-muted">--</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $quote->status }}">
                                        {{ ucfirst($quote->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($quote->assignee)
                                        <div class="small fw-medium">{{ $quote->assignee->full_name }}</div>
                                    @else
                                        <span class="text-muted small">Unassigned</span>
                                    @endif
                                </td>
                                <td>{{ $quote->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.quotes.show', $quote) }}" class="btn-action"
                                            title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.quotes.destroy', $quote) }}" method="POST"
                                            onsubmit="return confirm('Delete this quote request?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-action delete" title="Delete"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-file-invoice-dollar fa-3x mb-3"></i>
                                        <h3>No quote requests found</h3>
                                        <p>Project inquiries from the website will appear here.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($quotes->hasPages())
            <div class="card-footer">
                {{ $quotes->withQueryString()->links() }}
            </div>
        @endif
    </div>

    <style>
        .unread-row {
            background-color: rgba(59, 130, 246, 0.05);
        }

        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .status-new {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-contacted {
            background: #fef3c7;
            color: #92400e;
        }

        .status-quoted {
            background: #ede9fe;
            color: #5b21b6;
        }

        .status-accepted {
            background: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-archived {
            background: #f1f5f9;
            color: #475569;
        }

        .btn-action {
            color: var(--light-muted);
            padding: 5px 8px;
            border-radius: 4px;
            transition: all 0.2s;
            background: none;
            border: none;
        }

        .btn-action:hover {
            background: rgba(0, 0, 0, 0.05);
            color: var(--primary);
        }

        .btn-action.delete:hover {
            color: var(--danger);
        }

        .stats-summary {
            display: flex;
            gap: 24px;
        }

        .stat-item {
            text-align: right;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            display: block;
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--light-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.quote-checkbox');
            const bulkActions = document.getElementById('bulk-actions');
            const bulkActionSelect = document.getElementById('bulk-action-select');
            const assignUserSelect = document.getElementById('assign-user-select');

            selectAll.onchange = function () {
                checkboxes.forEach(cb => cb.checked = this.checked);
                toggleBulkActions();
            };

            checkboxes.forEach(cb => {
                cb.onchange = toggleBulkActions;
            });

            function toggleBulkActions() {
                const checkedCount = document.querySelectorAll('.quote-checkbox:checked').length;
                bulkActions.style.display = checkedCount > 0 ? 'block' : 'none';
            }

            bulkActionSelect.onchange = function () {
                assignUserSelect.style.display = this.value === 'assign' ? 'inline-block' : 'none';
            };

            document.getElementById('apply-bulk-action').onclick = function () {
                const action = bulkActionSelect.value;
                if (!action) return;

                const selectedIds = Array.from(document.querySelectorAll('.quote-checkbox:checked')).map(cb => cb.value);
                const form = document.getElementById('bulk-action-form');

                document.getElementById('bulk-action').value = action;
                if (action === 'assign') {
                    const userId = assignUserSelect.value;
                    if (!userId) { alert('Select a user'); return; }
                    document.getElementById('bulk-assigned-to').value = userId;
                }

                selectedIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden'; input.name = 'quote_ids[]'; input.value = id;
                    form.appendChild(input);
                });

                form.submit();
            };

            document.getElementById('cancel-bulk-action').onclick = function () {
                checkboxes.forEach(cb => cb.checked = false);
                selectAll.checked = false;
                toggleBulkActions();
            };
        });
    </script>
@endpush