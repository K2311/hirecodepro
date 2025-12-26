@extends('admin.layouts.app')

@section('title', 'Analytics & Reports | CodeCraft Admin')
@section('page-title', 'Analytics Dashboard')

@section('content')
    <!-- Page Header -->
    <div class="analytics-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title mb-2">
                    <i class="fas fa-chart-line me-2 text-primary"></i>
                    Business Analytics
                </h1>
                <p class="text-muted mb-0">Comprehensive insights and performance metrics</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-light rounded-pill px-4 border">
                    <i class="fas fa-download me-2"></i> Export Report
                </button>
                <button class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-calendar-alt me-2"></i> Date Range
                </button>
            </div>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="metric-card metric-revenue">
                <div class="metric-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="metric-content">
                    <div class="metric-label">Total Revenue</div>
                    <div class="metric-value">${{ number_format($totalRevenue, 2) }}</div>
                    <div class="metric-trend trend-up">
                        <i class="fas fa-arrow-up me-1"></i> 12.5% from last month
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="metric-card metric-orders">
                <div class="metric-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="metric-content">
                    <div class="metric-label">Total Orders</div>
                    <div class="metric-value">{{ number_format($totalOrders) }}</div>
                    <div class="metric-trend trend-up">
                        <i class="fas fa-arrow-up me-1"></i> 8.2% from last month
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="metric-card metric-clients">
                <div class="metric-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="metric-content">
                    <div class="metric-label">Total Clients</div>
                    <div class="metric-value">{{ number_format($totalClients) }}</div>
                    <div class="metric-trend trend-up">
                        <i class="fas fa-arrow-up me-1"></i> 15.3% from last month
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="metric-card metric-quotes">
                <div class="metric-icon" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div class="metric-content">
                    <div class="metric-label">Quote Requests</div>
                    <div class="metric-value">{{ number_format($quoteStats['total']) }}</div>
                    <div class="metric-trend trend-up">
                        <i class="fas fa-check me-1"></i> {{ $quoteStats['converted'] }} Converted
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Revenue Chart -->
        <div class="col-xl-8">
            <div class="analytics-card">
                <div class="card-header-analytics">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-area me-2 text-primary"></i>
                        Revenue Trend
                    </h5>
                    <div class="card-actions">
                        <button class="btn btn-sm btn-light">Monthly</button>
                        <button class="btn btn-sm btn-light">Quarterly</button>
                        <button class="btn btn-sm btn-primary">Yearly</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Status Distribution -->
        <div class="col-xl-4">
            <div class="analytics-card">
                <div class="card-header-analytics">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2 text-primary"></i>
                        Order Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 250px;">
                        <canvas id="orderStatusChart"></canvas>
                    </div>
                    <div class="status-legend mt-4">
                        @foreach($ordersByStatus as $status)
                            <div class="legend-item">
                                <span class="legend-dot status-{{ $status->status }}"></span>
                                <span class="legend-label">{{ ucfirst($status->status) }}</span>
                                <span class="legend-value">{{ $status->count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Tables Row -->
    <div class="row g-4 mb-4">
        <!-- Top Products -->
        <div class="col-xl-6">
            <div class="analytics-card">
                <div class="card-header-analytics">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-star me-2 text-warning"></i>
                        Top Performing Products
                    </h5>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-light">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="analytics-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Orders</th>
                                    <th class="text-end">Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="product-avatar">
                                                    {{ strtoupper(substr($product->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $product->name }}</div>
                                                    <div class="small text-muted">SKU: {{ $product->sku ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-soft-primary text-primary">{{ $product->order_items_count }}</span>
                                        </td>
                                        <td class="text-end fw-bold">
                                            ${{ number_format($product->price * $product->order_items_count, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">No data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Clients -->
        <div class="col-xl-6">
            <div class="analytics-card">
                <div class="card-header-analytics">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-crown me-2 text-warning"></i>
                        Top Clients by Revenue
                    </h5>
                    <a href="{{ route('admin.clients.index') }}" class="btn btn-sm btn-light">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="analytics-table">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th class="text-center">Orders</th>
                                    <th class="text-end">Total Spent</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topClients as $client)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="client-avatar">
                                                    {{ strtoupper(substr($client->full_name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $client->full_name }}</div>
                                                    <div class="small text-muted">{{ $client->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge bg-soft-success text-success">{{ $client->orders->count() }}</span>
                                        </td>
                                        <td class="text-end fw-bold">
                                            ${{ number_format($client->orders_sum_total_amount ?? 0, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">No data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Statistics -->
    <div class="row g-4">
        <div class="col-xl-12">
            <div class="analytics-card">
                <div class="card-header-analytics">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-invoice-dollar me-2 text-primary"></i>
                        Invoice Overview
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="invoice-stat">
                                <div class="stat-icon bg-soft-primary">
                                    <i class="fas fa-file-invoice text-primary"></i>
                                </div>
                                <div class="stat-details">
                                    <div class="stat-value">{{ $invoiceStats['total'] }}</div>
                                    <div class="stat-label">Total Invoices</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="invoice-stat">
                                <div class="stat-icon bg-soft-success">
                                    <i class="fas fa-check-circle text-success"></i>
                                </div>
                                <div class="stat-details">
                                    <div class="stat-value">{{ $invoiceStats['paid'] }}</div>
                                    <div class="stat-label">Paid Invoices</div>
                                    <div class="stat-amount">${{ number_format($invoiceStats['total_paid_amount'], 2) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="invoice-stat">
                                <div class="stat-icon bg-soft-warning">
                                    <i class="fas fa-clock text-warning"></i>
                                </div>
                                <div class="stat-details">
                                    <div class="stat-value">{{ $invoiceStats['pending'] }}</div>
                                    <div class="stat-label">Pending Payment</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="invoice-stat">
                                <div class="stat-icon bg-soft-danger">
                                    <i class="fas fa-exclamation-triangle text-danger"></i>
                                </div>
                                <div class="stat-details">
                                    <div class="stat-value">{{ $invoiceStats['overdue'] }}</div>
                                    <div class="stat-label">Overdue</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Quotes and Services Row -->
        <div class="row g-4 mb-4">
            <div class="col-xl-6">
                <div class="analytics-card">
                    <div class="card-header-analytics">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-quote-right me-2 text-primary"></i>
                            Popular Categories
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="position: relative; height: 300px;">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="analytics-card">
                    <div class="card-header-analytics">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bullseye me-2 text-success"></i>
                            Quote Conversion Status
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4 text-center mt-2">
                            <div class="col-4">
                                <h3 class="fw-bold text-warning">{{ $quoteStats['pending'] }}</h3>
                                <p class="text-muted small">Pending</p>
                            </div>
                            <div class="col-4">
                                <h3 class="fw-bold text-success">{{ $quoteStats['converted'] }}</h3>
                                <p class="text-muted small">Converted</p>
                            </div>
                            <div class="col-4">
                                <h3 class="fw-bold text-danger">{{ $quoteStats['rejected'] }}</h3>
                                <p class="text-muted small">Rejected</p>
                            </div>
                        </div>
                        <div class="mt-4 p-3 rounded" style="background: var(--bg-secondary);">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small">Conversion Rate</span>
                                <span
                                    class="fw-bold text-primary">{{ $quoteStats['total'] > 0 ? round(($quoteStats['converted'] / $quoteStats['total']) * 100, 1) : 0 }}%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar"
                                    style="width: {{ $quoteStats['total'] > 0 ? ($quoteStats['converted'] / $quoteStats['total']) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Geo and Service Breakdown Row -->
        <div class="row g-4 mb-4">
            <!-- Geographical Spread -->
            <div class="col-xl-6">
                <div class="analytics-card">
                    <div class="card-header-analytics">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-globe-americas me-2 text-info"></i>
                            Top Geographical Markets
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="analytics-table">
                                <thead>
                                    <tr>
                                        <th>Country</th>
                                        <th class="text-center">Clients</th>
                                        <th class="text-end">Revenue contribution</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clientsByCountry as $geo)
                                        <tr>
                                            <td class="fw-bold">{{ $geo->country }}</td>
                                            <td class="text-center">{{ $geo->count }}</td>
                                            <td class="text-end">
                                                @php
                                                    $countryRev = $revenueByCountry->firstWhere('country', $geo->country);
                                                @endphp
                                                <span class="text-success fw-bold">
                                                    ${{ number_format($countryRev ? $countryRev->total_revenue : 0, 0) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Requested Individual Services -->
            <div class="col-xl-6">
                <div class="analytics-card">
                    <div class="card-header-analytics">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-tasks me-2 text-primary"></i>
                            Most Requested Service Add-ons
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="service-popularity-list">
                            @foreach($topAddonServices as $svcName => $svcCount)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="fw-bold small">{{ $svcName }}</span>
                                        <span class="text-muted small">{{ $svcCount }} inquiries</span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: {{ $quoteStats['total'] > 0 ? ($svcCount / $quoteStats['total']) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            /* Page Header */
            .analytics-header {
                padding: 1.5rem 0;
            }

            .page-title {
                font-size: 2rem;
                font-weight: 800;
                color: #1e293b;
            }

            body.dark-mode .page-title {
                color: #f1f5f9;
            }

            /* Metric Cards */
            .metric-card {
                background: white;
                border-radius: 20px;
                padding: 1.75rem;
                display: flex;
                align-items: center;
                gap: 1.5rem;
                border: 1px solid #e2e8f0;
                transition: all 0.3s ease;
                height: 100%;
            }

            .metric-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 28px -8px rgba(0, 0, 0, 0.12);
            }

            body.dark-mode .metric-card {
                background: var(--dark-card);
                border-color: var(--dark-border);
            }

            .metric-icon {
                width: 70px;
                height: 70px;
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.75rem;
                flex-shrink: 0;
            }

            .metric-revenue .metric-icon {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
            }

            .metric-orders .metric-icon {
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                color: white;
            }

            .metric-clients .metric-icon {
                background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
                color: white;
            }

            .metric-products .metric-icon {
                background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
                color: white;
            }

            .metric-content {
                flex: 1;
            }

            .metric-label {
                font-size: 0.85rem;
                color: #64748b;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin-bottom: 0.5rem;
            }

            .metric-value {
                font-size: 2rem;
                font-weight: 800;
                color: #1e293b;
                line-height: 1;
                margin-bottom: 0.5rem;
            }

            body.dark-mode .metric-value {
                color: #f1f5f9;
            }

            .metric-trend {
                font-size: 0.8rem;
                font-weight: 600;
            }

            .trend-up {
                color: #10b981;
            }

            .trend-down {
                color: #ef4444;
            }

            .trend-neutral {
                color: #94a3b8;
            }

            /* Analytics Cards */
            .analytics-card {
                background: white;
                border-radius: 20px;
                border: 1px solid #e2e8f0;
                overflow: hidden;
                height: 100%;
                display: flex;
                flex-direction: column;
            }

            body.dark-mode .analytics-card {
                background: var(--dark-card);
                border-color: var(--dark-border);
            }

            .analytics-card .card-body {
                flex: 1;
                overflow: hidden;
            }

            /* Chart Container */
            .chart-container {
                position: relative;
                width: 100%;
            }

            .chart-container canvas {
                max-height: 100%;
                width: 100% !important;
                height: 100% !important;
            }

            .card-header-analytics {
                padding: 1.5rem;
                border-bottom: 2px solid #f1f5f9;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            body.dark-mode .card-header-analytics {
                border-bottom-color: var(--dark-border);
            }

            .card-title {
                font-size: 1.1rem;
                font-weight: 700;
                color: #1e293b;
            }

            body.dark-mode .card-title {
                color: #f1f5f9;
            }

            .card-actions {
                display: flex;
                gap: 0.5rem;
            }

            /* Tables */
            .analytics-table {
                width: 100%;
                border-collapse: collapse;
            }

            .analytics-table thead th {
                background: #f8fafc;
                padding: 1rem 1.5rem;
                font-size: 0.75rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 1px;
                color: #64748b;
                border-bottom: 2px solid #e2e8f0;
            }

            body.dark-mode .analytics-table thead th {
                background: rgba(255, 255, 255, 0.02);
                border-bottom-color: var(--dark-border);
            }

            .analytics-table tbody tr {
                transition: background-color 0.2s ease;
            }

            .analytics-table tbody tr:hover {
                background-color: rgba(59, 130, 246, 0.03);
            }

            .analytics-table tbody td {
                padding: 1.25rem 1.5rem;
                border-bottom: 1px solid #f1f5f9;
            }

            body.dark-mode .analytics-table tbody td {
                border-bottom-color: var(--dark-border);
            }

            .product-avatar,
            .client-avatar {
                width: 40px;
                height: 40px;
                border-radius: 10px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                margin-right: 1rem;
                flex-shrink: 0;
            }

            /* Status Legend */
            .status-legend {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .legend-item {
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .legend-dot {
                width: 12px;
                height: 12px;
                border-radius: 50%;
            }

            .legend-label {
                flex: 1;
                font-size: 0.9rem;
                color: #64748b;
            }

            .legend-value {
                font-weight: 700;
                color: #1e293b;
            }

            body.dark-mode .legend-value {
                color: #f1f5f9;
            }

            .status-pending {
                background: #f59e0b;
            }

            .status-completed {
                background: #10b981;
            }

            .status-cancelled {
                background: #ef4444;
            }

            .status-processing {
                background: #3b82f6;
            }

            /* Invoice Stats */
            .invoice-stat {
                display: flex;
                align-items: center;
                gap: 1.25rem;
                padding: 1.5rem;
                background: #f8fafc;
                border-radius: 16px;
            }

            body.dark-mode .invoice-stat {
                background: rgba(255, 255, 255, 0.02);
            }

            .invoice-stat .stat-icon {
                width: 56px;
                height: 56px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
            }

            .stat-details {
                flex: 1;
            }

            .stat-value {
                font-size: 1.75rem;
                font-weight: 800;
                color: #1e293b;
                line-height: 1;
                margin-bottom: 0.25rem;
            }

            body.dark-mode .stat-value {
                color: #f1f5f9;
            }

            .stat-label {
                font-size: 0.8rem;
                color: #64748b;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .stat-amount {
                font-size: 0.9rem;
                color: #10b981;
                font-weight: 700;
                margin-top: 0.25rem;
            }

            /* Utility Classes */
            .bg-soft-primary {
                background-color: rgba(59, 130, 246, 0.1);
            }

            .bg-soft-success {
                background-color: rgba(16, 185, 129, 0.1);
            }

            .bg-soft-warning {
                background-color: rgba(245, 158, 11, 0.1);
            }

            .bg-soft-danger {
                background-color: rgba(239, 68, 68, 0.1);
            }

            /* Responsive */
            @media (max-width: 768px) {
                .page-title {
                    font-size: 1.5rem;
                }

                .metric-card {
                    flex-direction: column;
                    text-align: center;
                }

                .metric-icon {
                    width: 60px;
                    height: 60px;
                    font-size: 1.5rem;
                }

                .metric-value {
                    font-size: 1.5rem;
                }

                .card-header-analytics {
                    flex-direction: column;
                    gap: 1rem;
                    align-items: flex-start;
                }
            }
        </style>

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Revenue Chart
                    const revenueCtx = document.getElementById('revenueChart');
                    if (revenueCtx) {
                        new Chart(revenueCtx, {
                            type: 'line',
                            data: {
                                labels: {!! json_encode($revenueByMonth->pluck('month')) !!},
                                datasets: [{
                                    label: 'Revenue',
                                    data: {!! json_encode($revenueByMonth->pluck('revenue')) !!},
                                    borderColor: '#667eea',
                                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                                    borderWidth: 3,
                                    fill: true,
                                    tension: 0.4,
                                    pointRadius: 5,
                                    pointBackgroundColor: '#667eea',
                                    pointBorderColor: '#fff',
                                    pointBorderWidth: 2
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        backgroundColor: '#1e293b',
                                        padding: 12,
                                        titleColor: '#fff',
                                        bodyColor: '#fff',
                                        borderColor: '#667eea',
                                        borderWidth: 1,
                                        displayColors: false,
                                        callbacks: {
                                            label: function (context) {
                                                return '$' + context.parsed.y.toLocaleString();
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.05)'
                                        },
                                        ticks: {
                                            callback: function (value) {
                                                return '$' + value.toLocaleString();
                                            }
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        }
                                    }
                                }
                            }
                        });
                    }

                    // Order Status Chart
                    const statusCtx = document.getElementById('orderStatusChart');
                    if (statusCtx) {
                        const statusData = {!! json_encode($ordersByStatus) !!};
                        new Chart(statusCtx, {
                            type: 'doughnut',
                            data: {
                                labels: statusData.map(s => s.status.charAt(0).toUpperCase() + s.status.slice(1)),
                                datasets: [{
                                    data: statusData.map(s => s.count),
                                    backgroundColor: [
                                        '#f59e0b',
                                        '#10b981',
                                        '#ef4444',
                                        '#3b82f6'
                                    ],
                                    borderWidth: 0
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        backgroundColor: '#1e293b',
                                        padding: 12,
                                        titleColor: '#fff',
                                        bodyColor: '#fff',
                                        borderColor: '#667eea',
                                        borderWidth: 1
                                    }
                                },
                                cutout: '70%'
                            }
                        });
                    }

                    // Project Category Chart
                    const categoryCtx = document.getElementById('categoryChart');
                    if (categoryCtx) {
                        const categoryData = {!! json_encode($servicesRequested) !!};
                        new Chart(categoryCtx, {
                            type: 'bar',
                            data: {
                                labels: categoryData.map(s => s.project_type || 'Other'),
                                datasets: [{
                                    label: 'Requests',
                                    data: categoryData.map(s => s.count),
                                    backgroundColor: '#667eea',
                                    borderRadius: 8,
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false }
                                },
                                scales: {
                                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                                    x: { grid: { display: false } }
                                }
                            }
                        });
                    }
                });
            </script>
        @endpush
@endsection