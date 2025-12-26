@extends('admin.layouts.app')

@section('title', $service->name . ' | CodeCraft Admin')
@section('page-title', 'Service Details')

@section('content')
    <!-- Header -->
    <div class="table-card mb-4" style="border-radius: 16px; overflow: visible;">
        <div class="table-header" style="padding: 2rem;">
            <div>
                <h2 class="table-title mb-1" style="font-size: 1.75rem;">{{ $service->name }}</h2>
                <p style="color: #64748b; margin: 0;">Service Details & Statistics</p>
            </div>
            <div class="table-actions" style="display: flex; gap: 0.75rem;">
                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Service
                </a>
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Service Overview -->
            <div class="table-card mb-4">
                <div class="table-header">
                    <h2 class="table-title"><i class="fas fa-info-circle me-2"></i> Service Overview</h2>
                </div>
                <div style="padding: 2rem;">
                    @if($service->icon)
                        <div class="service-icon-large mb-4">
                            <i class="{{ $service->icon }}"></i>
                        </div>
                    @endif

                    <h3 class="mb-3" style="color: #1e293b; font-weight: 700;">{{ $service->name }}</h3>
                    <p style="color: #64748b; font-size: 1.05rem; line-height: 1.7; margin-bottom: 2rem;">
                        {{ $service->description }}
                    </p>

                    @if($service->features && count($service->features) > 0)
                        <div
                            style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); padding: 1.5rem; border-radius: 16px; border-left: 4px solid #10b981;">
                            <h6 class="mb-3" style="color: #065f46; font-weight: 700;">
                                <i class="fas fa-check-circle me-2"></i> Key Features
                            </h6>
                            <ul style="list-style: none; padding: 0; margin: 0;">
                                @foreach($service->features as $feature)
                                    <li style="padding: 0.5rem 0; color: #047857; display: flex; align-items: start;">
                                        <i class="fas fa-check-circle"
                                            style="color: #10b981; margin-right: 0.75rem; margin-top: 0.25rem;"></i>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pricing Information -->
            <div class="table-card mb-4">
                <div class="table-header">
                    <h2 class="table-title"><i class="fas fa-dollar-sign me-2"></i> Pricing Information</h2>
                </div>
                <div style="padding: 2rem;">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="pricing-stat">
                                <div class="stat-icon"
                                    style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                                    <i class="fas fa-tag"></i>
                                </div>
                                <div class="stat-label">Pricing Model</div>
                                <div class="stat-value">{{ ucfirst($service->pricing_model) }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="pricing-stat">
                                <div class="stat-icon"
                                    style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <div class="stat-label">Base Rate</div>
                                <div class="stat-value" style="color: #10b981;">
                                    ${{ number_format($service->base_rate, 2) }}
                                    @if($service->pricing_model === 'hourly')
                                        <small style="font-size: 0.7rem; color: #64748b;">/hr</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if($service->estimated_hours)
                            <div class="col-md-4">
                                <div class="pricing-stat">
                                    <div class="stat-icon"
                                        style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="stat-label">Est. Hours</div>
                                    <div class="stat-value">{{ $service->estimated_hours }}h</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            @if($service->meta_title || $service->meta_description)
                <div class="table-card">
                    <div class="table-header">
                        <h2 class="table-title"><i class="fas fa-search me-2"></i> SEO Information</h2>
                    </div>
                    <div style="padding: 2rem;">
                        @if($service->meta_title)
                            <div class="mb-3">
                                <label
                                    style="font-weight: 600; color: #475569; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">Meta
                                    Title</label>
                                <p style="color: #1e293b; margin: 0; padding: 1rem; background: #f8fafc; border-radius: 8px;">
                                    {{ $service->meta_title }}
                                </p>
                            </div>
                        @endif
                        @if($service->meta_description)
                            <div>
                                <label
                                    style="font-weight: 600; color: #475569; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.5rem;">Meta
                                    Description</label>
                                <p style="color: #1e293b; margin: 0; padding: 1rem; background: #f8fafc; border-radius: 8px;">
                                    {{ $service->meta_description }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Status & Settings -->
            <div class="table-card mb-4">
                <div class="table-header">
                    <h2 class="table-title">Status & Settings</h2>
                </div>
                <div style="padding: 1.5rem;">
                    <div class="status-item mb-4">
                        <div class="status-item-header">
                            <i class="fas fa-power-off"></i>
                            <span>Status</span>
                        </div>
                        <span class="badge-large {{ $service->is_active ? 'badge-success' : 'badge-inactive' }}">
                            {{ $service->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="status-item mb-4">
                        <div class="status-item-header">
                            <i class="fas fa-star"></i>
                            <span>Featured</span>
                        </div>
                        <span class="badge-large {{ $service->is_featured ? 'badge-warning' : 'badge-inactive' }}">
                            {{ $service->is_featured ? 'Yes' : 'No' }}
                        </span>
                    </div>

                    <div class="status-item mb-4">
                        <div class="status-item-header">
                            <i class="fas fa-sort-numeric-down"></i>
                            <span>Sort Order</span>
                        </div>
                        <span class="badge-large badge-neutral">{{ $service->sort_order ?? 0 }}</span>
                    </div>

                    <div class="status-item">
                        <div class="status-item-header">
                            <i class="fas fa-link"></i>
                            <span>Slug</span>
                        </div>
                        <code
                            style="background: #f1f5f9; padding: 8px 12px; border-radius: 8px; display: inline-block; color: #6366f1; font-size: 0.875rem;">
                                {{ $service->slug }}
                            </code>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="table-card mb-4">
                <div class="table-header">
                    <h2 class="table-title">Statistics</h2>
                </div>
                <div style="padding: 1.5rem;">
                    <div class="stat-box mb-3">
                        <div class="stat-box-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="stat-box-content">
                            <div class="stat-box-value">{{ $service->orderItems->count() }}</div>
                            <div class="stat-box-label">Total Orders</div>
                        </div>
                    </div>

                    <div class="stat-box mb-3">
                        <div class="stat-box-icon" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-box-content">
                            <div class="stat-box-value">{{ $service->packages->count() }}</div>
                            <div class="stat-box-label">Service Packages</div>
                        </div>
                    </div>

                    <div class="stat-box">
                        <div class="stat-box-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="stat-box-content">
                            <div class="stat-box-value" style="font-size: 1rem;">
                                {{ $service->created_at->format('M d, Y') }}</div>
                            <div class="stat-box-label">Created Date</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="table-card">
                <div style="padding: 1.5rem;">
                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-primary w-100 mb-3"
                        style="padding: 0.875rem;">
                        <i class="fas fa-edit me-2"></i> Edit Service
                    </a>
                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this service? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn w-100"
                            style="padding: 0.875rem; background: #fee2e2; color: #991b1b; border: none; border-radius: 12px; font-weight: 600;">
                            <i class="fas fa-trash me-2"></i> Delete Service
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .service-icon-large {
            width: 96px;
            height: 96px;
            border-radius: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .pricing-stat {
            text-align: center;
            padding: 1.5rem;
            background: #f8fafc;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
        }

        body.dark-mode .pricing-stat {
            background: rgba(255, 255, 255, 0.03);
            border-color: var(--dark-border);
        }

        .pricing-stat .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
        }

        .pricing-stat .stat-label {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .pricing-stat .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e293b;
        }

        body.dark-mode .pricing-stat .stat-value {
            color: #f1f5f9;
        }

        .status-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .status-item-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: #475569;
            font-size: 0.875rem;
        }

        .status-item-header i {
            color: #94a3b8;
        }

        .badge-large {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.875rem;
        }

        .badge-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .badge-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .badge-inactive {
            background: #e2e8f0;
            color: #64748b;
        }

        .badge-neutral {
            background: #f1f5f9;
            color: #1e293b;
            font-weight: 800;
        }

        .stat-box {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem;
            background: #f8fafc;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
        }

        body.dark-mode .stat-box {
            background: rgba(255, 255, 255, 0.03);
            border-color: var(--dark-border);
        }

        .stat-box-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .stat-box-content {
            flex: 1;
        }

        .stat-box-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: #1e293b;
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        body.dark-mode .stat-box-value {
            color: #f1f5f9;
        }

        .stat-box-label {
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
@endsection