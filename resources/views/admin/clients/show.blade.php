@extends('admin.layouts.app')

@section('title', 'Client Profile | ' . $client->full_name)
@section('page-title', 'Client Profile')

@section('content')
    <!-- Page Header -->
    <div class="page-header-profile mb-4">
        <div class="d-flex justify-content-between align-items-start">
            <div class="d-flex align-items-center gap-4">
                <div class="client-avatar-lg">
                    {{ strtoupper(substr($client->full_name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="client-name mb-2">{{ $client->full_name }}</h1>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <span class="status-badge-lg client-{{ $client->status }}">
                            {{ strtoupper($client->status) }}
                        </span>
                        <span class="text-muted small">
                            <i class="fas fa-calendar-alt me-1"></i>
                            Member since {{ $client->created_at->format('M Y') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fas fa-edit me-2"></i> Edit Profile
                </a>
                <a href="{{ route('admin.clients.index') }}" class="btn btn-light rounded-pill px-4 border shadow-sm">
                    <i class="fas fa-arrow-left me-2"></i> All Clients
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="row g-4">
        <!-- Left Sidebar: Contact & Business Info -->
        <div class="col-lg-4">
            <!-- Contact Information Card -->
            <div class="premium-card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title-premium mb-4">
                        <i class="fas fa-address-book me-2 text-primary"></i>
                        Contact Information
                    </h5>

                    <div class="contact-item mb-4">
                        <label class="contact-label">Direct Email</label>
                        <a href="mailto:{{ $client->email }}" class="contact-value text-primary">
                            {{ $client->email }}
                            <i class="fas fa-external-link-alt ms-2 small opacity-50"></i>
                        </a>
                    </div>

                    <div class="contact-item mb-4">
                        <label class="contact-label">Phone Line</label>
                        <div class="contact-value">{{ $client->phone ?: 'Not provided' }}</div>
                    </div>

                    <div class="contact-item mb-4">
                        <label class="contact-label">Current Organization</label>
                        <div class="contact-value fw-bold">{{ $client->company ?: 'Independent / Freelancer' }}</div>
                        <div class="text-muted small">{{ $client->position ?: 'N/A' }}</div>
                    </div>

                    <div class="contact-item mb-4">
                        <label class="contact-label">Geographic Context</label>
                        <div class="contact-value">
                            <i class="fas fa-map-marker-alt me-2 text-danger opacity-75"></i>
                            {{ $client->country ?: 'International' }}
                        </div>
                    </div>

                    <div class="contact-item">
                        <label class="contact-label">Digital Presence</label>
                        @if($client->website)
                            <a href="{{ $client->website }}" target="_blank" class="contact-value text-primary">
                                <i class="fas fa-globe me-1"></i>
                                {{ str_replace(['http://', 'https://'], '', $client->website) }}
                            </a>
                        @else
                            <span class="contact-value text-muted">No website linked</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Business Value Card -->
            <div class="business-value-card mb-4">
                <div class="card-body p-4">
                    <h5 class="text-white mb-4 d-flex align-items-center">
                        <i class="fas fa-chart-pie me-2 text-warning"></i>
                        Business Value
                    </h5>
                    <div class="row text-center g-3">
                        <div class="col-6">
                            <div class="value-stat">
                                <div class="stat-number text-warning">{{ $client->orders->count() }}</div>
                                <div class="stat-label">Total Orders</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="value-stat">
                                <div class="stat-number text-warning">
                                    ${{ number_format($client->invoices->where('status', 'paid')->sum('total'), 2) }}</div>
                                <div class="stat-label">Revenue</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Card (if exists) -->
            @if($client->notes)
                <div class="premium-card border-0 shadow-sm p-4 bg-soft-info">
                    <h6 class="fw-bold mb-2">
                        <i class="fas fa-sticky-note me-2 text-info"></i>
                        Internal Notes
                    </h6>
                    <p class="mb-0 text-dark small fst-italic">"{{ $client->notes }}"</p>
                </div>
            @endif
        </div>

        <!-- Right Content: Activity Tabs -->
        <div class="col-lg-8">
            <!-- Tab Navigation -->
            <ul class="nav nav-tabs-premium mb-4" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#orders-tab">
                        <i class="fas fa-shopping-bag me-2"></i>
                        Orders History
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#invoices-tab">
                        <i class="fas fa-file-invoice-dollar me-2"></i>
                        Billing & Invoices
                    </button>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Orders Tab -->
                <div class="tab-pane fade show active" id="orders-tab">
                    <div class="premium-card border-0 shadow-sm overflow-hidden">
                        <div class="table-responsive">
                            <table class="premium-table">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Order Reference</th>
                                        <th>Target Value</th>
                                        <th>Placement Date</th>
                                        <th class="pe-4 text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($client->orders as $order)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bold text-dark">#{{ $order->order_number ?: $order->id }}
                                                </div>
                                                <div class="small text-muted">{{ $order->items->count() }} line items</div>
                                            </td>
                                            <td>
                                                <div class="fw-black text-dark">
                                                    ${{ number_format($order->total_amount, 2) }}</div>
                                            </td>
                                            <td>
                                                <div class="text-dark">{{ $order->created_at->format('M d, Y') }}</div>
                                            </td>
                                            <td class="pe-4 text-end">
                                                <a href="{{ route('admin.orders.show', $order) }}"
                                                    class="btn btn-sm btn-light rounded-pill px-3 border">View Order</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <div class="text-muted py-3">
                                                    <i class="fas fa-shopping-cart fa-3x opacity-25 mb-3 d-block"></i>
                                                    <p class="mb-0">No orders have been placed by this client yet.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Invoices Tab -->
                <div class="tab-pane fade" id="invoices-tab">
                    <div class="premium-card border-0 shadow-sm overflow-hidden">
                        <div class="table-responsive">
                            <table class="premium-table">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Invoice #</th>
                                        <th>Total Balance</th>
                                        <th>Liability Status</th>
                                        <th class="pe-4 text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($client->invoices as $invoice)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bold text-dark">#{{ $invoice->invoice_number }}</div>
                                                <div class="small text-muted">Issued:
                                                    {{ $invoice->issue_date->format('d/m/y') }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-black text-dark">${{ number_format($invoice->total, 2) }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="status-badge inv-{{ $invoice->status }} px-3 py-1">
                                                    {{ strtoupper($invoice->status) }}
                                                </span>
                                            </td>
                                            <td class="pe-4 text-end">
                                                <a href="{{ route('admin.invoices.show', $invoice) }}"
                                                    class="btn btn-sm btn-light rounded-pill px-3 border">View Invoice</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <div class="text-muted py-3">
                                                    <i class="fas fa-file-invoice fa-3x opacity-25 mb-3 d-block"></i>
                                                    <p class="mb-0">No financial records generated for this client profile.
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <style>
        /* Page Header */
        .page-header-profile {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2.5rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px -10px rgba(102, 126, 234, 0.3);
        }

        body.dark-mode .page-header-profile {
            background: linear-gradient(135deg, #4c51bf 0%, #553c9a 100%);
        }

        .client-avatar-lg {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
        }

        .client-name {
            font-size: 2rem;
            font-weight: 800;
            color: white;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .page-header-profile .text-muted {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .page-header-profile .btn-light {
            background: rgba(255, 255, 255, 0.95);
            border-color: rgba(255, 255, 255, 0.3);
            color: #667eea;
            font-weight: 600;
        }

        .page-header-profile .btn-light:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .page-header-profile .btn-primary {
            background: white;
            border-color: white;
            color: #667eea;
            font-weight: 600;
        }

        .page-header-profile .btn-primary:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Status Badges */
        .status-badge-lg {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            border-radius: 50px;
            font-size: 10px;
            font-weight: 800;
            padding: 5px 14px;
            display: inline-block;
            letter-spacing: 0.5px;
        }

        .client-active {
            background: #dcfce7;
            color: #166534;
        }

        .client-lead {
            background: #e0f2fe;
            color: #0369a1;
        }

        .client-inactive {
            background: #f1f5f9;
            color: #475569;
        }

        .inv-paid {
            background: #dcfce7;
            color: #166534;
        }

        .inv-sent {
            background: #e0f2fe;
            color: #0369a1;
        }

        .inv-draft {
            background: #f1f5f9;
            color: #475569;
        }

        .inv-overdue {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Cards */
        .premium-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .premium-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px -8px rgba(0, 0, 0, 0.12) !important;
            border-color: #cbd5e1;
        }

        body.dark-mode .premium-card {
            background: var(--dark-card);
            border-color: var(--dark-border);
        }

        body.dark-mode .text-dark {
            color: #f1f5f9 !important;
        }

        body.dark-mode .bg-dark {
            background-color: #1e293b !important;
        }

        /* Contact Information */
        .contact-item {
            transition: all 0.2s ease;
            padding: 14px;
            margin: -14px -14px 0 -14px;
            border-radius: 12px;
        }

        .contact-item:hover {
            background-color: rgba(59, 130, 246, 0.04);
        }

        .contact-item label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            margin-bottom: 6px;
        }

        /* Business Value Card */
        .business-value-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-radius: 20px;
            box-shadow: 0 8px 20px -6px rgba(0,0,0,0.3);
            border: none;
        }
        
        .value-stat {
            padding: 1rem 0;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 600;
        }
        
        /* Card Titles */
        .card-title-premium {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f1f5f9;
        }
        
        body.dark-mode .card-title-premium {
            color: #f1f5f9;
            border-bottom-color: var(--dark-border);
        }
        
        /* Contact Information */
        .contact-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            margin-bottom: 6px;
            display: block;
        }
        
        .contact-value {
            font-size: 1rem;
            color: #1e293b;
            font-weight: 500;
            text-decoration: none;
            display: block;
        }
        
        body.dark-mode .contact-value {
            color: #f1f5f9;
        }
        
        /* Navigation Tabs - Clean Modern Style */
        .nav-tabs-premium {
            border-bottom: 2px solid #e2e8f0;
            padding: 0;
            gap: 0;
            display: flex;
        }
        
        body.dark-mode .nav-tabs-premium {
            border-bottom-color: var(--dark-border);
        }
        
        .nav-tabs-premium .nav-item {
            margin-bottom: -2px;
        }
        
        .nav-tabs-premium .nav-link {
            color: #64748b;
            background: transparent;
            font-weight: 600;
            font-size: 0.95rem;
            border: none;
            border-bottom: 3px solid transparent;
            border-radius: 0;
            padding: 14px 28px;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }
        
        .nav-tabs-premium .nav-link:hover {
            color: var(--primary);
            background-color: rgba(59, 130, 246, 0.04);
        }
        
        .nav-tabs-premium .nav-link.active {
            color: var(--primary);
            background: transparent;
            border-bottom-color: var(--primary);
        }
        
        .nav-tabs-premium .nav-link i {
            opacity: 0.7;
        }
        
        .nav-tabs-premium .nav-link.active i {
            opacity: 1;
        }

        /* Tab Content */
        .tab-content {
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }

        /* Tables */
        .premium-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .premium-table thead th {
            background: #f8fafc;
            padding: 16px 20px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        body.dark-mode .premium-table thead th {
            background: rgba(255, 255, 255, 0.02);
            border-bottom-color: var(--dark-border);
        }

        .premium-table tbody tr {
            transition: all 0.2s ease;
        }

        .premium-table tbody tr:hover {
            background-color: rgba(59, 130, 246, 0.03);
        }

        body.dark-mode .premium-table tbody tr:hover {
            background-color: rgba(59, 130, 246, 0.08);
        }

        .premium-table tbody td {
            padding: 20px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        body.dark-mode .premium-table tbody td {
            border-color: var(--dark-border);
        }

        /* Empty States */
        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }

        .empty-state i {
            opacity: 0.12;
            margin-bottom: 1.5rem;
        }

        .empty-state p {
            color: #94a3b8;
            font-size: 0.95rem;
        }

        /* Utility Classes */
        .fw-black {
            font-weight: 800;
        }

        .ls-1 {
            letter-spacing: 1px;
        }

        .italic {
            font-style: italic;
        }

        .decoration-none {
            text-decoration: none;
        }

        .bg-soft-info {
            background-color: rgba(6, 182, 212, 0.06);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .page-header-profile {
                padding: 2rem 1.5rem;
            }

            .page-header-profile .d-flex {
                flex-direction: column;
                gap: 1.5rem !important;
            }

            .client-avatar-lg {
                width: 80px;
                height: 80px;
                font-size: 2rem;
            }

            .client-name {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .nav-pills-premium {
                flex-wrap: nowrap;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .nav-pills-premium .nav-link {
                white-space: nowrap;
                padding: 12px 20px;
            }

            .premium-table {
                font-size: 0.9rem;
            }

            .premium-table thead th,
            .premium-table tbody td {
                padding: 12px 16px;
            }
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Tab functionality
                const tabButtons = document.querySelectorAll('[data-bs-toggle="pill"]');

                tabButtons.forEach(button => {
                    button.addEventListener('click', function (e) {
                        e.preventDefault();

                        // Remove active class from all buttons and panes
                        tabButtons.forEach(btn => btn.classList.remove('active'));
                        document.querySelectorAll('.tab-pane').forEach(pane => {
                            pane.classList.remove('show', 'active');
                        });

                        // Add active class to clicked button
                        this.classList.add('active');

                        // Show corresponding tab pane
                        const targetId = this.getAttribute('data-bs-target');
                        const targetPane = document.querySelector(targetId);
                        if (targetPane) {
                            targetPane.classList.add('show', 'active');
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection