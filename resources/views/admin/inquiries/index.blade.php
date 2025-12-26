@extends('admin.layouts.app')

@section('title', 'Inquiries | CodeCraft Studio')
@section('page-title', 'Contact Inquiries')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h1>Contact Inquiries</h1>
            <p>Manage and respond to customer inquiries</p>
        </div>
        <div class="page-actions">
            <div class="stats-summary">
                <div class="stat-item">
                    <span class="stat-value">{{ $inquiries->where('status', 'new')->count() }}</span>
                    <span class="stat-label">New</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $inquiries->where('status', 'read')->count() }}</span>
                    <span class="stat-label">Read</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $inquiries->where('status', 'replied')->count() }}</span>
                    <span class="stat-label">Replied</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card" style="margin-bottom: 24px;">
        <div class="card-body">
            <form action="{{ route('admin.inquiries.index') }}" method="GET" class="filters-form">
                <div class="form-group">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by name, email, company, or subject" class="form-control search-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                        <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        <option value="general" {{ request('type') == 'general' ? 'selected' : '' }}>General</option>
                        <option value="service" {{ request('type') == 'service' ? 'selected' : '' }}>Service</option>
                        <option value="support" {{ request('type') == 'support' ? 'selected' : '' }}>Support</option>
                        <option value="partnership" {{ request('type') == 'partnership' ? 'selected' : '' }}>Partnership
                        </option>
                        <option value="product" {{ request('type') == 'product' ? 'selected' : '' }}>Product Inquiry</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Assigned To</label>
                    <select name="assigned_to" class="form-select">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('assigned_to') == $user->id ? 'selected' : '' }}>
                                {{ $user->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        @if(request()->hasAny(['search', 'status', 'type', 'assigned_to']))
                            <a href="{{ route('admin.inquiries.index') }}" class="btn btn-secondary">Reset</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Actions -->
    <form id="bulk-action-form" action="{{ route('admin.inquiries.bulk-update') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="action" id="bulk-action">
        <input type="hidden" name="assigned_to" id="bulk-assigned-to">
    </form>

    <!-- Inquiries Table -->
    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3>Inquiries ({{ $inquiries->total() }})</h3>
                <div id="bulk-actions" style="display: none;">
                    <div class="bulk-actions-container">
                        <select id="bulk-action-select" class="form-select bulk-action-select">
                            <option value="">Bulk Actions</option>
                            <option value="mark_read">Mark as Read</option>
                            <option value="mark_replied">Mark as Replied</option>
                            <option value="mark_closed">Mark as Closed</option>
                            <option value="assign">Assign To</option>
                        </select>
                        <select id="assign-user-select" class="form-select assign-user-select">
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
        </div>
        <div class="card-body">
            @if($inquiries->count() > 0)
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width: 40px;">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th>Contact</th>
                                <th>Subject</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Assigned</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inquiries as $inquiry)
                                <tr class="{{ $inquiry->status === 'new' ? 'unread-row' : '' }}">
                                    <td>
                                        <input type="checkbox" class="inquiry-checkbox" value="{{ $inquiry->id }}">
                                    </td>
                                    <td>
                                        <div class="contact-cell">
                                            <div class="contact-info">
                                                <div class="contact-name">{{ $inquiry->name }}</div>
                                                <div class="contact-email">{{ $inquiry->email }}</div>
                                                @if($inquiry->company)
                                                    <div class="contact-company">{{ $inquiry->company }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="subject-cell">
                                            <div class="subject-text">{{ Str::limit($inquiry->subject, 50) }}</div>
                                            @if($inquiry->status === 'new')
                                                <span class="new-badge">New</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-direction: column; gap: 4px;">
                                            <span class="type-badge type-{{ $inquiry->inquiry_type }}">
                                                {{ ucfirst($inquiry->inquiry_type) }}
                                            </span>
                                            @if($inquiry->product_id && $inquiry->product)
                                                <small class="text-muted">
                                                    <i class="fas fa-box"></i>
                                                    <a href="{{ route('admin.products.edit', $inquiry->product) }}"
                                                        style="color: var(--primary-color);">
                                                        {{ $inquiry->product->name }}
                                                    </a>
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $inquiry->status }}">
                                            {{ ucfirst($inquiry->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($inquiry->assignee)
                                            <div class="assignee-info">
                                                <span class="assignee-name">{{ $inquiry->assignee->full_name }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted">Unassigned</span>
                                        @endif
                                    </td>
                                    <td>{{ $inquiry->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="btn btn-sm btn-primary"
                                                title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($inquiry->status !== 'closed')
                                                <button type="button" class="btn btn-sm btn-success quick-reply-btn"
                                                    data-inquiry-id="{{ $inquiry->id }}" data-email="{{ $inquiry->email }}"
                                                    title="Quick Reply">
                                                    <i class="fas fa-reply"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-container">
                    {{ $inquiries->withQueryString()->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-envelope"></i>
                    <h3>No inquiries found</h3>
                    <p>{{ request()->hasAny(['search', 'status', 'type', 'assigned_to']) ? 'Try adjusting your filters.' : 'Inquiries will appear here when customers contact you.' }}
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Reply Modal -->
    <div id="quick-reply-modal" class="handmade-modal" style="display: none;">
        <div class="handmade-modal-backdrop" onclick="closeQuickReplyModal()"></div>
        <div class="handmade-modal-content">
            <div class="handmade-modal-header">
                <h3>Quick Reply</h3>
                <button type="button" class="handmade-modal-close" onclick="closeQuickReplyModal()">&times;</button>
            </div>
            <form id="quick-reply-form" action="" method="POST">
                @csrf
                <div class="handmade-modal-body">
                    <div class="form-group">
                        <label class="form-label">Reply to: <span id="reply-to-email"></span></label>
                        <textarea name="reply_message" class="form-control" rows="6"
                            placeholder="Enter your reply message..." required></textarea>
                    </div>
                </div>
                <div class="handmade-modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeQuickReplyModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Reply</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Bulk selection
            const selectAllCheckbox = document.getElementById('select-all');
            const inquiryCheckboxes = document.querySelectorAll('.inquiry-checkbox');
            const bulkActions = document.getElementById('bulk-actions');
            const bulkActionSelect = document.getElementById('bulk-action-select');
            const assignUserSelect = document.getElementById('assign-user-select');
            const applyBulkActionBtn = document.getElementById('apply-bulk-action');
            const cancelBulkActionBtn = document.getElementById('cancel-bulk-action');

            selectAllCheckbox.addEventListener('change', function () {
                inquiryCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkActionsVisibility();
            });

            inquiryCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkActionsVisibility);
            });

            function updateBulkActionsVisibility() {
                const checkedBoxes = document.querySelectorAll('.inquiry-checkbox:checked');
                bulkActions.style.display = checkedBoxes.length > 0 ? 'block' : 'none';
            }

            bulkActionSelect.addEventListener('change', function () {
                if (this.value === 'assign') {
                    assignUserSelect.style.display = 'inline-block';
                } else {
                    assignUserSelect.style.display = 'none';
                }
            });

            applyBulkActionBtn.addEventListener('click', function () {
                const action = bulkActionSelect.value;
                if (!action) return;

                const selectedIds = Array.from(document.querySelectorAll('.inquiry-checkbox:checked')).map(cb => cb.value);
                if (selectedIds.length === 0) return;

                document.getElementById('bulk-action').value = action;

                if (action === 'assign') {
                    const assignedTo = assignUserSelect.value;
                    if (!assignedTo) {
                        alert('Please select a user to assign to.');
                        return;
                    }
                    document.getElementById('bulk-assigned-to').value = assignedTo;
                }

                // Add selected IDs to form
                selectedIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'inquiry_ids[]';
                    input.value = id;
                    document.getElementById('bulk-action-form').appendChild(input);
                });

                document.getElementById('bulk-action-form').submit();
            });

            cancelBulkActionBtn.addEventListener('click', function () {
                document.querySelectorAll('.inquiry-checkbox:checked').forEach(cb => cb.checked = false);
                selectAllCheckbox.checked = false;
                updateBulkActionsVisibility();
            });

            // Quick reply functionality
            document.querySelectorAll('.quick-reply-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const inquiryId = this.dataset.inquiryId;
                    const email = this.dataset.email;

                    document.getElementById('reply-to-email').textContent = email;
                    document.getElementById('quick-reply-form').action = `/admin/inquiries/${inquiryId}/reply`;

                    document.getElementById('quick-reply-modal').style.display = 'flex';
                });
            });
        });

        function closeQuickReplyModal() {
            document.getElementById('quick-reply-modal').style.display = 'none';
            document.getElementById('quick-reply-form').reset();
        }
    </script>
@endpush