@extends('admin.layouts.app')

@section('title', 'Orders | CodeCraft Studio')
@section('page-title', 'Order Management')

@section('content')
    <div class="page-header mb-4">
        <div class="page-title">
            <h1 class="fw-bold"><i class="fas fa-shopping-cart me-2 text-primary"></i>Orders</h1>
            <p class="text-muted">Monitor and manage all customer purchases and fulfillment</p>
        </div>
        <div class="page-actions">
            <!-- No "Create" button for orders usually, but if needed it would go here -->
        </div>
    </div>

    <!-- Quick Stats Summary -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="premium-stat-card">
                <div class="stat-icon bg-soft-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Pending</span>
                    <h2 class="stat-value text-warning m-0">{{ $orders->where('status', 'pending')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="premium-stat-card">
                <div class="stat-icon bg-soft-primary">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-label">In Progress</span>
                    <h2 class="stat-value text-primary m-0">{{ $orders->where('status', 'processing')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="premium-stat-card">
                <div class="stat-icon bg-soft-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Successful</span>
                    <h2 class="stat-value text-success m-0">{{ $orders->where('payment_status', 'paid')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="premium-stat-card">
                <div class="stat-icon bg-soft-info">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Total Volume</span>
                    <h2 class="stat-value text-info m-0">${{ number_format($orders->sum('total_amount'), 2) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="premium-card mb-4 border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small text-uppercase fw-bold text-muted ls-1">Search Records</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-search input-icon"></i>
                        <input type="text" name="search" class="form-input-premium ps-5"
                            placeholder="Order #, name, email..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-uppercase fw-bold text-muted ls-1">Order Status</label>
                    <div class="select-wrapper">
                        <select name="status" class="form-select-premium">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-uppercase fw-bold text-muted ls-1">Payment Status</label>
                    <div class="select-wrapper">
                        <select name="payment_status" class="form-select-premium">
                            <option value="">Status</option>
                            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100 rounded-pill py-2">
                        <i class="fas fa-filter me-2"></i> Filter
                    </button>
                </div>
                @if(request()->hasAny(['search', 'status', 'payment_status']))
                    <div class="col-md-1">
                        <a href="{{ route('admin.orders.index') }}"
                            class="btn btn-link text-muted p-0 py-2 d-block text-center decoration-none">
                            <i class="fas fa-times-circle me-1"></i> Reset
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="premium-card border-0 shadow-sm">
        <div class="card-header-premium bg-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h3 class="m-0 fw-bold"><i class="fas fa-list me-2 text-primary"></i>All Orders ({{ $orders->total() }})</h3>
            <div id="bulk-actions" style="display: none;">
                <div class="d-flex gap-2">
                    <select id="bulk-action-select" class="form-select-premium" style="width: 180px;">
                        <option value="">Bulk Actions</option>
                        <option value="mark_processing">Mark Processing</option>
                        <option value="mark_completed">Mark Completed</option>
                        <option value="mark_paid">Mark as Paid</option>
                        <option value="mark_cancelled">Cancel Orders</option>
                    </select>
                    <button type="button" id="apply-bulk-action" class="btn btn-primary btn-sm rounded-pill px-3">Apply</button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 40px;"><input type="checkbox" id="select-all" class="form-check-input"></th>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Fulfillment</th>
                            <th>Date</th>
                            <th class="pe-4 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr class="align-middle">
                                <td class="ps-4"><input type="checkbox" class="order-checkbox form-check-input" value="{{ $order->id }}"></td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                        class="fw-bold fs-6 text-dark decoration-none hover-primary">
                                        #{{ $order->order_number ?: substr($order->id, 0, 8) }}
                                    </a>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $order->client_name }}</div>
                                    <div class="small text-muted">{{ $order->client_email }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $order->currency }} {{ number_format($order->total_amount, 2) }}</div>
                                </td>
                                <td>
                                    <span class="status-badge order-{{ $order->payment_status }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge order-{{ $order->status }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="small text-muted">{{ $order->created_at->format('M d, Y') }}</div>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light rounded-pill px-3 dropdown-toggle no-caret border" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-cog me-1"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 py-2 mt-2">
                                            <li><a class="dropdown-item py-2" href="{{ route('admin.orders.show', $order) }}"><i class="fas fa-eye me-2 text-info"></i> View Details</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Delete this order?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item py-2 text-danger hover-danger"><i class="fas fa-trash-alt me-2"></i> Delete Order</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="empty-state py-5">
                                        <div class="empty-icon bg-soft-secondary text-muted rounded-circle mx-auto mb-4"
                                            style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-shopping-bag fa-2x opacity-50"></i>
                                        </div>
                                        <h3 class="fw-bold">No Orders Found</h3>
                                        <p class="text-muted mx-auto" style="max-width: 300px;">Orders will appear here once customers checkout.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($orders->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $orders->withQueryString()->links() }}
            </div>
        @endif
    </div>

    <style>
        .ls-1 { letter-spacing: 1px; }
        .bg-soft-primary { background-color: rgba(59, 130, 246, 0.1) !important; color: #3b82f6 !important; }
        .bg-soft-success { background-color: rgba(16, 185, 129, 0.1) !important; color: #10b981 !important; }
        .bg-soft-warning { background-color: rgba(245, 158, 11, 0.1) !important; color: #f59e0b !important; }
        .bg-soft-danger { background-color: rgba(239, 68, 68, 0.1) !important; color: #ef4444 !important; }
        .bg-soft-info { background-color: rgba(6, 182, 212, 0.1) !important; color: #0891b2 !important; }
        .bg-soft-secondary { background-color: #f1f5f9 !important; color: #64748b !important; }
        .hover-primary:hover { color: var(--primary) !important; }
        .decoration-none { text-decoration: none; }
        .premium-card { background: #ffffff; border-radius: 16px; overflow: hidden; }
        body.dark-mode .premium-card { background: var(--dark-card); border: 1px solid var(--dark-border); }
        .card-header-premium { border-bottom: 1px solid #f1f5f9; }
        body.dark-mode .card-header-premium { border-color: var(--dark-border); background: transparent !important; }
        .premium-stat-card { background: #ffffff; border-radius: 16px; padding: 24px; display: flex; align-items: center; gap: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); transition: transform 0.3s ease; }
        .premium-stat-card:hover { transform: translateY(-5px); }
        body.dark-mode .premium-stat-card { background: var(--dark-card); border: 1px solid var(--dark-border); }
        .stat-icon { width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; }
        .stat-label { display: block; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 4px; }
        .stat-value { font-size: 1.75rem; font-weight: 800; line-height: 1; }
        .form-input-premium, .form-select-premium { width: 100%; height: 44px; padding: 10px 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; transition: all 0.2s; outline: none; }
        body.dark-mode .form-input-premium, body.dark-mode .form-select-premium { background: rgba(255, 255, 255, 0.03); border-color: var(--dark-border); color: var(--dark-text); }
        .select-wrapper, .input-icon-wrapper { position: relative; }
        .select-icon, .input-icon { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; opacity: 0.7; }
        .input-icon { left: 16px; right: auto; }
        .premium-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .premium-table thead th { background: #f8fafc; padding: 14px 16px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; border-bottom: 1px solid #f1f5f9; }
        body.dark-mode .premium-table thead th { background: rgba(255, 255, 255, 0.02); color: #94a3b8; border-color: var(--dark-border); }
        .premium-table tbody td { padding: 18px 16px; border-bottom: 1px solid #f1f5f9; }
        body.dark-mode .premium-table tbody td { border-color: var(--dark-border); }
        .status-badge { border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-block; padding: 4px 12px; }
        .order-pending { background: #fef3c7; color: #92400e; }
        .order-processing { background: #e0f2fe; color: #0369a1; }
        .order-completed, .order-paid { background: #dcfce7; color: #166534; }
        .order-cancelled, .order-failed { background: #fee2e2; color: #991b1b; }
        .order-refunded { background: #f3e8ff; color: #6b21a8; }
        .dropdown { position: relative; display: inline-block; }
        .dropdown-menu { display: none; position: absolute; right: 0; top: 100%; z-index: 1000; min-width: 180px; padding: 8px 0; margin: 8px 0 0; background-color: #ffffff; border-radius: 12px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); list-style: none !important; }
        body.dark-mode .dropdown-menu { background-color: var(--dark-card); border: 1px solid var(--dark-border); }
        .dropdown-menu.show { display: block; animation: dropdownFadeIn 0.2s ease-out; }
        @keyframes dropdownFadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .dropdown-item { display: flex !important; align-items: center; width: 100%; padding: 10px 20px; color: #475569; text-decoration: none; transition: all 0.2s; }
        body.dark-mode .dropdown-item { color: var(--dark-text); }
        .dropdown-item:hover { background-color: #f1f5f9; color: var(--primary); }
        body.dark-mode .dropdown-item:hover { background-color: rgba(255, 255, 255, 0.05); }
        .no-caret::after { display: none; }
        .hover-danger:hover { background-color: #fee2e2 !important; color: #dc2626 !important; }
    </style>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dropdown Logic
            const dropdowns = document.querySelectorAll('.dropdown');
            dropdowns.forEach(dropdown => {
                const toggle = dropdown.querySelector('.dropdown-toggle');
                const menu = dropdown.querySelector('.dropdown-menu');
                if (toggle && menu) {
                    toggle.addEventListener('click', function(e) {
                        e.stopPropagation();
                        document.querySelectorAll('.dropdown-menu.show').forEach(m => { if (m !== menu) m.classList.remove('show'); });
                        menu.classList.toggle('show');
                    });
                }
            });
            document.addEventListener('click', function() {
                document.querySelectorAll('.dropdown-menu.show').forEach(menu => menu.classList.remove('show'));
            });

            // Bulk Actions Logic
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.order-checkbox');
            const bulkActions = document.getElementById('bulk-actions');
            const applyBtn = document.getElementById('apply-bulk-action');
            const actionSelect = document.getElementById('bulk-action-select');

            function updateBulkVisibility() {
                const count = document.querySelectorAll('.order-checkbox:checked').length;
                bulkActions.style.display = count > 0 ? 'block' : 'none';
            }

            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = selectAll.checked);
                    updateBulkVisibility();
                });
            }

            checkboxes.forEach(cb => cb.addEventListener('change', updateBulkVisibility));

            if (applyBtn) {
                applyBtn.addEventListener('click', function() {
                    const action = actionSelect.value;
                    const ids = Array.from(document.querySelectorAll('.order-checkbox:checked')).map(cb => cb.value);
                    if (!action || ids.length === 0) return;

                    if (confirm(`Apply ${action.replace('_', ' ')} to ${ids.length} orders?`)) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route('admin.orders.bulk-update') }}';
                        form.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="action" value="${action}">`;
                        ids.forEach(id => {
                            form.innerHTML += `<input type="hidden" name="order_ids[]" value="${id}">`;
                        });
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }
        });
    </script>
    @endpush
@endsection