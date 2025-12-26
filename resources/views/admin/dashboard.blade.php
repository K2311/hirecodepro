@extends('admin.layouts.app')

@section('title', 'Dashboard | CodeCraft Studio')

@section('page-title', 'Dashboard')

@section('content')
    <!-- Overview Cards -->
    <div class="overview-cards">
        <!-- Revenue Card -->
        <div class="overview-card">
            <div class="card-header">
                <div class="card-icon icon-revenue">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    <span>12.5%</span>
                </div>
            </div>
            <div class="card-value">${{ number_format($totalRevenue, 2) }}</div>
            <div class="card-label">Total Revenue</div>
        </div>

        <!-- Orders Card -->
        <div class="overview-card">
            <div class="card-header">
                <div class="card-icon icon-orders">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="card-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    <span>8.2%</span>
                </div>
            </div>
            <div class="card-value">{{ number_format($totalOrders) }}</div>
            <div class="card-label">Total Orders</div>
        </div>

        <!-- Products Card -->
        <div class="overview-card">
            <div class="card-header">
                <div class="card-icon icon-products">
                    <i class="fas fa-box"></i>
                </div>
                <div class="card-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    <span>5.1%</span>
                </div>
            </div>
            <div class="card-value">{{ number_format($totalProducts) }}</div>
            <div class="card-label">Active Products</div>
        </div>

        <!-- Clients Card -->
        <div class="overview-card">
            <div class="card-header">
                <div class="card-icon icon-clients">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    <span>15.3%</span>
                </div>
            </div>
            <div class="card-value">{{ number_format($totalClients) }}</div>
            <div class="card-label">Total Clients</div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-xl-8">
            <div class="table-card">
                <div class="table-header">
                    <h2 class="table-title">Revenue Trend</h2>
                </div>
                <div style="padding: 2rem;">
                    <div style="position: relative; height: 300px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="table-card">
                <div class="table-header">
                    <h2 class="table-title">Order Status</h2>
                </div>
                <div style="padding: 2rem;">
                    <div style="position: relative; height: 300px;">
                        <canvas id="orderStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="table-card">
        <div class="table-header">
            <h2 class="table-title">Recent Orders</h2>
            <div class="table-actions">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">
                    <i class="fas fa-eye"></i>
                    View All
                </a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Client</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                    <tr>
                        <td><strong>#{{ $order->order_number ?? $order->id }}</strong></td>
                        <td>{{ $order->client->full_name ?? 'Guest' }}</td>
                        <td>${{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <span class="status-badge status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary"
                                style="padding: 6px 12px; font-size: 0.75rem;">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 2rem;">
                            <p style="color: #94a3b8;">No recent orders found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Top Products Table -->
    <div class="table-card">
        <div class="table-header">
            <h2 class="table-title">Top Selling Products</h2>
            <div class="table-actions">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-box"></i>
                    Manage Products
                </a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Sales</th>
                    <th>Revenue</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topProducts as $product)
                    <tr>
                        <td><strong>{{ $product->name }}</strong></td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->order_items_count }}</td>
                        <td>${{ number_format($product->price * $product->order_items_count, 2) }}</td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary"
                                style="padding: 6px 12px; font-size: 0.75rem;">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 2rem;">
                            <p style="color: #94a3b8;">No products found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

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
                                borderColor: 'rgb(99, 102, 241)',
                                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function (value) {
                                            return '$' + value.toLocaleString();
                                        }
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
                                    'rgb(251, 191, 36)',
                                    'rgb(34, 197, 94)',
                                    'rgb(239, 68, 68)',
                                    'rgb(59, 130, 246)'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'bottom' }
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection