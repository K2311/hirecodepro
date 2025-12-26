@extends('admin.layouts.app')

@section('title', 'Invoices | CodeCraft Studio')
@section('page-title', 'Invoices')

@section('content')
    <div class="page-header mb-4">
        <div class="page-title">
            <h1 class="fw-bold"><i class="fas fa-file-invoice-dollar me-2 text-primary"></i>Invoices</h1>
            <p class="text-muted">Manage your billing lifecycle, taxes, and customer payments</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                <i class="fas fa-plus-circle me-2"></i> Create New Invoice
            </a>
        </div>
    </div>

    <!-- Quick Stats Summary -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="premium-stat-card">
                <div class="stat-icon bg-soft-primary">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Sent Invoices</span>
                    <h2 class="stat-value text-primary m-0">{{ $invoices->where('status', 'sent')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="premium-stat-card">
                <div class="stat-icon bg-soft-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Pending/Overdue</span>
                    <h2 class="stat-value text-warning m-0">{{ $invoices->whereIn('status', ['sent', 'overdue'])->count() }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="premium-stat-card">
                <div class="stat-icon bg-soft-success">
                    <i class="fas fa-check-double"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Paid Records</span>
                    <h2 class="stat-value text-success m-0">{{ $invoices->where('status', 'paid')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="premium-stat-card">
                <div class="stat-icon bg-soft-danger">
                    <i class="fas fa-ban"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Cancelled</span>
                    <h2 class="stat-value text-danger m-0">{{ $invoices->where('status', 'cancelled')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="premium-card mb-4 border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.invoices.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small text-uppercase fw-bold text-muted ls-1">Search Records</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-search input-icon"></i>
                        <input type="text" name="search" class="form-input-premium ps-5"
                            placeholder="Invoice #, name, email..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-uppercase fw-bold text-muted ls-1">Payment Status</label>
                    <div class="select-wrapper">
                        <select name="status" class="form-select-premium">
                            <option value="">All Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100 rounded-pill py-2">
                        <i class="fas fa-filter me-2"></i> Filter
                    </button>
                </div>
                @if(request()->hasAny(['search', 'status']))
                    <div class="col-md-1">
                        <a href="{{ route('admin.invoices.index') }}"
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
            <h3 class="m-0"><i class="fas fa-list me-2 font-size-base"></i>All Billing Invoices</h3>
            <span class="badge bg-soft-primary text-primary rounded-pill px-3">{{ $invoices->total() }} Total</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th class="ps-4">Invoice ID</th>
                            <th>Customer & Details</th>
                            <th>Reference</th>
                            <th>Billing Amount</th>
                            <th>Expiry Date</th>
                            <th>Lifecycle</th>
                            <th class="pe-4 text-end">Management</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                            <tr class="align-middle">
                                <td class="ps-4">
                                    <a href="{{ route('admin.invoices.show', $invoice) }}"
                                        class="fw-bold fs-6 text-dark decoration-none hover-primary">
                                        #{{ $invoice->invoice_number }}
                                    </a>
                                    <div class="small text-muted">{{ $invoice->created_at->format('M d, Y') }}</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="avatar-sm me-3 bg-soft-secondary text-secondary rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                            {{ strtoupper(substr($invoice->client->full_name ?? 'N', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $invoice->client->full_name ?? 'N/A' }}</div>
                                            <div class="small text-muted">
                                                {{ $invoice->client->email ?? ($invoice->order->client_email ?? '') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($invoice->order)
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('admin.orders.show', $invoice->order) }}"
                                                class="badge bg-soft-info text-info decoration-none mb-1">
                                                ORD-{{ $invoice->order->order_number ?: substr($invoice->order->id, 0, 8) }}
                                            </a>
                                            <span class="small text-muted">{{ $invoice->order->created_at->format('d/m/y') }}</span>
                                        </div>
                                    @else
                                        <span class="badge bg-soft-light text-muted">Standalone</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark fs-6">{{ $invoice->currency }}
                                        {{ number_format($invoice->total_amount, 2) }}</div>
                                    <div class="small text-muted">Incl. Tax: {{ number_format($invoice->tax_amount, 2) }}</div>
                                </td>
                                <td>
                                    <div
                                        class="d-flex align-items-center {{ $invoice->status !== 'paid' && $invoice->due_date->isPast() ? 'text-danger' : 'text-muted' }}">
                                        <i class="far fa-calendar-alt me-2 small"></i>
                                        <span class="small fw-medium">{{ $invoice->due_date->format('M d, Y') }}</span>
                                    </div>
                                    @if($invoice->status !== 'paid' && $invoice->due_date->isPast())
                                        <span class="badge bg-soft-danger text-danger border-0 tiny-badge mt-1">Overdue</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge inv-{{ $invoice->status }} px-3 py-1">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light rounded-pill px-3 dropdown-toggle no-caret border" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cog me-1"></i> Actions
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 py-2 mt-2">
                                            <li><a class="dropdown-item py-2" href="{{ route('admin.invoices.show', $invoice) }}"><i class="fas fa-eye me-2 text-info opacity-75"></i> View Details</a></li>
                                            <li><a class="dropdown-item py-2" href="{{ route('admin.invoices.edit', $invoice) }}"><i class="fas fa-edit me-2 text-primary opacity-75"></i> Edit Invoice</a></li>
                                            <li><a class="dropdown-item py-2" href="{{ route('admin.invoices.show', $invoice) }}?print=true"><i class="fas fa-print me-2 text-secondary opacity-75"></i> Print PDF</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.invoices.destroy', $invoice) }}" method="POST"
                                                    onsubmit="return confirm('Delete this invoice? This action cannot be undone.');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item py-2 text-danger hover-danger"><i class="fas fa-trash-alt me-2"></i> Delete Records</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="empty-state py-5">
                                        <div class="empty-icon bg-soft-secondary text-muted rounded-circle mx-auto mb-4"
                                            style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-file-invoice-dollar fa-2x opacity-50"></i>
                                        </div>
                                        <h3 class="fw-bold">No Records Found</h3>
                                        <p class="text-muted mx-auto" style="max-width: 300px;">We couldn't find any invoices
                                            matching your search or filters.</p>
                                        <a href="{{ route('admin.invoices.create') }}"
                                            class="btn btn-primary rounded-pill mt-3 px-4">Create First Invoice</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($invoices->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted small">Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }} of
                        {{ $invoices->total() }} results</span>
                    {{ $invoices->withQueryString()->links() }}
                </div>
            </div>
        @endif
    </div>

    <style>
        .ls-1 {
            letter-spacing: 1px;
        }

        .tiny-badge {
            font-size: 10px;
            padding: 2px 6px;
        }

        .bg-soft-primary {
            background-color: rgba(59, 130, 246, 0.1) !important;
            color: #3b82f6 !important;
        }

        .bg-soft-success {
            background-color: rgba(16, 185, 129, 0.1) !important;
            color: #10b981 !important;
        }

        .bg-soft-warning {
            background-color: rgba(245, 158, 11, 0.1) !important;
            color: #f59e0b !important;
        }

        .bg-soft-danger {
            background-color: rgba(239, 68, 68, 0.1) !important;
            color: #ef4444 !important;
        }

        .bg-soft-secondary {
            background-color: #f1f5f9 !important;
            color: #64748b !important;
        }

        .bg-soft-info {
            background-color: rgba(6, 182, 212, 0.1) !important;
            color: #0891b2 !important;
        }

        .bg-soft-light {
            background-color: #f8fafc !important;
            color: #94a3b8 !important;
        }

        .hover-primary:hover {
            color: var(--primary) !important;
        }

        .decoration-none {
            text-decoration: none;
        }

        .avatar-sm {
            width: 40px;
            height: 40px;
            font-size: 14px;
        }

        .btn-icon-only {
            width: 32px;
            height: 32px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
            background: transparent;
            border: 0;
        }

        .btn-icon-only:hover {
            background: #f1f5f9;
            color: #3b82f6 !important;
        }

        /* Premium Components */
        .premium-card {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
        }

        body.dark-mode .premium-card {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
        }

        .card-header-premium {
            border-bottom: 1px solid #f1f5f9;
        }

        body.dark-mode .card-header-premium {
            border-color: var(--dark-border);
            background: transparent !important;
        }

        .card-header-premium h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
        }

        body.dark-mode .card-header-premium h3 {
            color: #f1f5f9;
        }

        /* Premium Stats */
        .premium-stat-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .premium-stat-card:hover {
            transform: translateY(-5px);
        }

        body.dark-mode .premium-stat-card {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .stat-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            line-height: 1;
        }

        /* Premium Form Controls */
        .form-input-premium,
        .form-select-premium {
            width: 100%;
            height: 44px;
            padding: 10px 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.9rem;
            transition: all 0.2s;
            outline: none;
        }

        body.dark-mode .form-input-premium,
        body.dark-mode .form-select-premium {
            background: rgba(255, 255, 255, 0.03);
            border-color: var(--dark-border);
            color: var(--dark-text);
        }

        .form-input-premium:focus,
        .form-select-premium:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background: #ffffff;
        }

        .select-wrapper,
        .input-icon-wrapper {
            position: relative;
        }

        .select-icon,
        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
            opacity: 0.7;
        }

        .input-icon {
            left: 16px;
            right: auto;
        }

        /* Premium Table */
        .premium-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .premium-table thead th {
            background: #f8fafc;
            padding: 14px 16px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom: 1px solid #f1f5f9;
        }

        body.dark-mode .premium-table thead th {
            background: rgba(255, 255, 255, 0.02);
            color: #94a3b8;
            border-color: var(--dark-border);
        }

        .premium-table tbody tr {
            transition: all 0.2s;
        }

        .premium-table tbody tr:hover {
            background-color: #fcfdfe;
        }

        body.dark-mode .premium-table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.01);
        }

        .premium-table tbody td {
            padding: 18px 16px;
            border-bottom: 1px solid #f1f5f9;
        }

        body.dark-mode .premium-table tbody td {
            border-color: var(--dark-border);
        }

        /* Status Badges */
        .status-badge { border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-block; letter-spacing: 0.3px; }
        .inv-draft { background: #f1f5f9; color: #475569; }
        .inv-sent { background: #e0f2fe; color: #0369a1; }
        .inv-paid { background: #dcfce7; color: #166534; }
        .inv-overdue { background: #fee2e2; color: #991b1b; }
        .inv-cancelled { background: #f8fafc; color: #94a3b8; }

        /* Dropdown Fixes for Image Report */
        .dropdown { position: relative; display: inline-block; }
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            z-index: 1000;
            min-width: 180px;
            padding: 8px 0;
            margin: 8px 0 0;
            background-color: #ffffff;
            border: 0;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            list-style: none !important;
        }
        
        body.dark-mode .dropdown-menu {
            background-color: var(--dark-card);
            border: 1px solid var(--dark-border);
        }

        .dropdown-menu.show {
            display: block;
            animation: dropdownFadeIn 0.2s ease-out;
        }

        @keyframes dropdownFadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dropdown-menu li {
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .dropdown-item {
            display: flex !important;
            align-items: center;
            width: 100%;
            padding: 10px 20px;
            clear: both;
            font-weight: 500;
            color: #475569;
            text-align: inherit;
            text-decoration: none;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
            transition: all 0.2s;
        }

        body.dark-mode .dropdown-item {
            color: var(--dark-text);
        }

        .dropdown-item:hover {
            background-color: #f1f5f9;
            color: var(--primary);
        }

        body.dark-mode .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .dropdown-item i { width: 1.25rem; font-size: 0.9rem; margin-right: 12px; }
        .no-caret::after { display: none; }
        .hover-danger:hover { background-color: #fee2e2 !important; color: #dc2626 !important; }
    </style>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dropdown Toggle Logic
            const dropdowns = document.querySelectorAll('.dropdown');
            
            dropdowns.forEach(dropdown => {
                const toggle = dropdown.querySelector('.dropdown-toggle');
                const menu = dropdown.querySelector('.dropdown-menu');
                
                if (toggle && menu) {
                    toggle.addEventListener('click', function(e) {
                        e.stopPropagation();
                        
                        // Close other open dropdowns
                        document.querySelectorAll('.dropdown-menu.show').forEach(openMenu => {
                            if (openMenu !== menu) openMenu.classList.remove('show');
                        });
                        
                        menu.classList.toggle('show');
                    });
                }
            });
            
            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                    menu.classList.remove('show');
                });
            });
        });
    </script>
    @endpush
@endsection