@extends('admin.layouts.app')

@section('title', 'Clients | CodeCraft Admin')
@section('page-title', 'Client Management')

@section('content')
    <div class="page-header mb-4">
        <div class="page-title">
            <h1 class="fw-bold"><i class="fas fa-users me-2 text-primary"></i>Clients</h1>
            <p class="text-muted">Manage your customer database, relationships, and history</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.clients.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                <i class="fas fa-plus-circle me-2"></i> Add New Client
            </a>
        </div>
    </div>

    <!-- Quick Stats Summary -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="premium-stat-card">
                <div class="stat-icon bg-soft-primary">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Active Clients</span>
                    <h2 class="stat-value text-primary m-0">{{ \App\Models\Client::where('status', 'active')->count() }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="premium-stat-card">
                <div class="stat-icon bg-soft-warning">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Total Leads</span>
                    <h2 class="stat-value text-warning m-0">{{ \App\Models\Client::where('status', 'lead')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="premium-stat-card">
                <div class="stat-icon bg-soft-success">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Subscribed</span>
                    <h2 class="stat-value text-success m-0">{{ \App\Models\Client::where('is_subscribed', true)->count() }}
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="premium-card mb-4 border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.clients.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label small text-uppercase fw-bold text-muted ls-1">Search Clients</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-search input-icon"></i>
                        <input type="text" name="search" class="form-input-premium ps-5"
                            placeholder="Name, email, or company..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-uppercase fw-bold text-muted ls-1">Relationship Status</label>
                    <div class="select-wrapper">
                        <select name="status" class="form-select-premium">
                            <option value="">All Relationships</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active Client
                            </option>
                            <option value="lead" {{ request('status') == 'lead' ? 'selected' : '' }}>Hot Lead</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                    <div class="col-md-2">
                        <a href="{{ route('admin.clients.index') }}"
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
            <h3 class="m-0 fw-bold"><i class="fas fa-address-book me-2 text-primary"></i>Customer Directory</h3>
            <span class="badge bg-soft-primary text-primary rounded-pill px-3">{{ $clients->total() }} Members</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th class="ps-4">Profile</th>
                            <th>Organization</th>
                            <th>Contact Context</th>
                            <th>Relationship</th>
                            <th>Market Activity</th>
                            <th class="pe-4 text-end">Management</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                            <tr class="align-middle">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="avatar-md me-3 bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold fs-5">
                                            {{ strtoupper(substr($client->full_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.clients.show', $client) }}"
                                                class="fw-bold text-dark decoration-none hover-primary d-block">
                                                {{ $client->full_name }}
                                            </a>
                                            <span class="small text-muted mb-0"><i
                                                    class="fas fa-envelope me-1 opacity-50"></i>{{ $client->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $client->company ?: 'Freelancer' }}</div>
                                    <div class="small text-muted">{{ $client->position ?: 'Private Individual' }}</div>
                                </td>
                                <td>
                                    <div class="small text-dark mb-1"><i
                                            class="fas fa-phone me-1 text-muted opacity-50"></i>{{ $client->phone ?: 'N/A' }}
                                    </div>
                                    <div class="small text-muted"><i
                                            class="fas fa-map-marker-alt me-1 opacity-50"></i>{{ $client->country ?: 'Global' }}
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge client-{{ $client->status }} px-3 py-1">
                                        {{ strtoupper($client->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <div class="small fw-bold text-dark mb-1">
                                            <i class="fas fa-shopping-cart me-1 text-primary opacity-50"></i>
                                            {{ $client->orders_count ?? $client->orders()->count() }} Orders
                                        </div>
                                        <div class="small text-muted">
                                            Registered: {{ $client->created_at->format('M Y') }}
                                        </div>
                                    </div>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light rounded-pill px-3 dropdown-toggle no-caret border"
                                            type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-cog me-1"></i> Actions
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 py-2 mt-2">
                                            <li><a class="dropdown-item py-2"
                                                    href="{{ route('admin.clients.show', $client) }}"><i
                                                        class="fas fa-eye me-2 text-info opacity-75"></i> View Profile</a></li>
                                            <li><a class="dropdown-item py-2"
                                                    href="{{ route('admin.clients.edit', $client) }}"><i
                                                        class="fas fa-edit me-2 text-primary opacity-75"></i> Edit Profile</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.clients.destroy', $client) }}" method="POST"
                                                    onsubmit="return confirm('Archive this client? Linked orders will be preserved.');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item py-2 text-danger hover-danger"><i
                                                            class="fas fa-archive me-2"></i> Archive Record</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state py-5">
                                        <div class="empty-icon bg-soft-secondary text-muted rounded-circle mx-auto mb-4"
                                            style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-users-slash fa-2x opacity-50"></i>
                                        </div>
                                        <h3 class="fw-bold">No Records Found</h3>
                                        <p class="text-muted mx-auto" style="max-width: 300px;">We couldn't find any clients
                                            matching your current search criteria.</p>
                                        <a href="{{ route('admin.clients.create') }}"
                                            class="btn btn-primary rounded-pill mt-3 px-4">Add Your First Client</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($clients->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted small">Displaying {{ $clients->firstItem() }}-{{ $clients->lastItem() }} of
                        {{ $clients->total() }} customers</span>
                    {{ $clients->withQueryString()->links() }}
                </div>
            </div>
        @endif
    </div>

    <style>
        .ls-1 {
            letter-spacing: 1px;
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

        .bg-soft-secondary {
            background-color: #f1f5f9 !important;
            color: #64748b !important;
        }

        .hover-primary:hover {
            color: var(--primary) !important;
        }

        .decoration-none {
            text-decoration: none;
        }

        .avatar-md {
            width: 48px;
            height: 48px;
        }

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

        .premium-table tbody td {
            padding: 18px 16px;
            border-bottom: 1px solid #f1f5f9;
        }

        body.dark-mode .premium-table tbody td {
            border-color: var(--dark-border);
        }

        .status-badge {
            border-radius: 20px;
            font-size: 10px;
            font-weight: 800;
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

        .dropdown {
            position: relative;
            display: inline-block;
        }

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
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
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
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            display: flex !important;
            align-items: center;
            width: 100%;
            padding: 10px 20px;
            color: #475569;
            text-decoration: none;
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

        .dropdown-item i {
            width: 1.25rem;
            font-size: 0.9rem;
            margin-right: 12px;
        }

        .no-caret::after {
            display: none;
        }

        .hover-danger:hover {
            background-color: #fee2e2 !important;
            color: #dc2626 !important;
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const dropdowns = document.querySelectorAll('.dropdown');
                dropdowns.forEach(dropdown => {
                    const toggle = dropdown.querySelector('.dropdown-toggle');
                    const menu = dropdown.querySelector('.dropdown-menu');
                    if (toggle && menu) {
                        toggle.addEventListener('click', function (e) {
                            e.stopPropagation();
                            document.querySelectorAll('.dropdown-menu.show').forEach(m => { if (m !== menu) m.classList.remove('show'); });
                            menu.classList.toggle('show');
                        });
                    }
                });
                document.addEventListener('click', function () {
                    document.querySelectorAll('.dropdown-menu.show').forEach(menu => menu.classList.remove('show'));
                });
            });
        </script>
    @endpush
@endsection