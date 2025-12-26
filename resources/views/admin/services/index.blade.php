@extends('admin.layouts.app')

@section('title', 'Services Management | CodeCraft Admin')
@section('page-title', 'Services')

@section('content')
    <!-- Header Section -->
    <div class="table-card mb-4" style="border-radius: 16px; overflow: visible;">
        <div class="table-header" style="padding: 2rem;">
            <div>
                <h2 class="table-title mb-1" style="font-size: 1.75rem;">Services Management</h2>
                <p style="color: #64748b; margin: 0;">Manage your service offerings and packages</p>
            </div>
            <div class="table-actions">
                <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Add New Service
                </a>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="table-card mb-4">
        <div style="padding: 1.5rem;">
            <form action="{{ route('admin.services.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search services..." 
                        value="{{ request('search') }}"
                        style="border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 0.625rem 1rem;">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select" style="border-radius: 12px; border: 1.5px solid #e2e8f0;">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="featured" class="form-select" style="border-radius: 12px; border: 1.5px solid #e2e8f0;">
                        <option value="">All Services</option>
                        <option value="yes" {{ request('featured') == 'yes' ? 'selected' : '' }}>Featured Only</option>
                        <option value="no" {{ request('featured') == 'no' ? 'selected' : '' }}>Not Featured</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Services Table -->
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Pricing Model</th>
                    <th>Base Rate</th>
                    <th style="text-align: center;">Featured</th>
                    <th style="text-align: center;">Status</th>
                    <th style="text-align: center;">Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                @if($service->icon)
                                    <div class="service-icon">
                                        <i class="{{ $service->icon }}"></i>
                                    </div>
                                @endif
                                <div>
                                    <div style="font-weight: 600; color: #1e293b; margin-bottom: 4px;">
                                        {{ $service->name }}
                                    </div>
                                    <div style="font-size: 0.875rem; color: #64748b;">
                                        {{ Str::limit($service->description, 50) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="status-badge status-{{ $service->pricing_model }}">
                                {{ ucfirst($service->pricing_model) }}
                            </span>
                        </td>
                        <td>
                            <strong style="font-size: 1.1rem; color: #10b981;">
                                ${{ number_format($service->base_rate, 2) }}
                            </strong>
                            @if($service->pricing_model === 'hourly')
                                <small style="color: #64748b;">/hr</small>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <button type="button" 
                                class="toggle-btn {{ $service->is_featured ? 'toggle-active' : '' }}"
                                onclick="toggleFeatured('{{ $service->id }}', this)"
                                title="{{ $service->is_featured ? 'Remove from Featured' : 'Make Featured' }}">
                                <i class="fas fa-star"></i>
                            </button>
                        </td>
                        <td style="text-align: center;">
                            <button type="button"
                                class="status-toggle {{ $service->is_active ? 'active' : '' }}"
                                onclick="toggleActive('{{ $service->id }}', this)">
                                <span class="status-text">{{ $service->is_active ? 'Active' : 'Inactive' }}</span>
                            </button>
                        </td>
                        <td style="text-align: center;">
                            <span style="background: #f1f5f9; padding: 4px 12px; border-radius: 8px; font-weight: 600; font-size: 0.875rem;">
                                {{ $service->sort_order ?? 0 }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('admin.services.show', $service) }}" 
                                    class="btn btn-secondary" 
                                    style="padding: 6px 12px; font-size: 0.75rem;">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.services.edit', $service) }}" 
                                    class="btn btn-primary" 
                                    style="padding: 6px 12px; font-size: 0.75rem;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.services.destroy', $service) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('Are you sure you want to delete this service?');"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="btn" 
                                        style="padding: 6px 12px; font-size: 0.75rem; background: #fee2e2; color: #991b1b; border: none;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 4rem 2rem;">
                            <i class="fas fa-briefcase" style="font-size: 4rem; color: #cbd5e1; margin-bottom: 1rem; display: block;"></i>
                            <p style="color: #64748b; font-size: 1.1rem; margin-bottom: 1rem;">No services found</p>
                            <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i> Add Your First Service
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if($services->hasPages())
            <div style="padding: 1.5rem; border-top: 1px solid #e2e8f0;">
                {{ $services->links() }}
            </div>
        @endif
    </div>

    <style>
        .service-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .toggle-btn {
            background: #f1f5f9;
            border: 2px solid #e2e8f0;
            color: #64748b;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }

        .toggle-btn:hover {
            background: #e2e8f0;
            transform: scale(1.05);
        }

        .toggle-btn.toggle-active {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            border-color: #f59e0b;
            color: white;
        }

        .status-toggle {
            padding: 8px 20px;
            border-radius: 20px;
            border: 2px solid #e2e8f0;
            background: #f1f5f9;
            color: #64748b;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .status-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .status-toggle.active {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-color: #10b981;
            color: white;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-fixed {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-hourly {
            background: #fef3c7;
            color: #92400e;
        }

        .status-custom {
            background: #e9d5ff;
            color: #6b21a8;
        }

        body.dark-mode .service-icon {
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
        }

        body.dark-mode .toggle-btn {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--dark-border);
            color: #94a3b8;
        }

        body.dark-mode .toggle-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        body.dark-mode .status-toggle {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--dark-border);
        }
    </style>

    <script>
        function toggleFeatured(serviceId, button) {
            fetch(`/admin/services/${serviceId}/toggle-featured`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.classList.toggle('toggle-active');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function toggleActive(serviceId, button) {
            fetch(`/admin/services/${serviceId}/toggle-active`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.classList.toggle('active');
                    const statusText = button.querySelector('.status-text');
                    statusText.textContent = data.is_active ? 'Active' : 'Inactive';
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
@endsection