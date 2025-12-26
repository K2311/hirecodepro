@extends('admin.layouts.app')

@section('title', 'Edit Service | CodeCraft Admin')
@section('page-title', 'Services')

@section('content')
    <!-- Header -->
    <div class="table-card mb-4" style="border-radius: 16px; overflow: visible;">
        <div class="table-header" style="padding: 2rem;">
            <div>
                <h2 class="table-title mb-1" style="font-size: 1.75rem;">Edit Service</h2>
                <p style="color: #64748b; margin: 0;">Update "{{ $service->name }}" details</p>
            </div>
            <div class="table-actions">
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Back to Services
                </a>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.services.update', $service) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row g-4">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="table-card mb-4">
                    <div class="table-header">
                        <h2 class="table-title"><i class="fas fa-info-circle me-2"></i> Basic Information</h2>
                    </div>
                    <div style="padding: 2rem;">
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">Service Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', $service->name) }}" 
                                required
                                style="border-radius: 12px; border: 1.5px solid #e2e8f0;">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" 
                                name="description" 
                                rows="5" 
                                required
                                style="border-radius: 12px; border: 1.5px solid #e2e8f0;">{{ old('description', $service->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label for="icon" class="form-label fw-semibold">Icon <small class="text-muted">(FontAwesome class)</small></label>
                            <input type="text" 
                                class="form-control @error('icon') is-invalid @enderror" 
                                id="icon" 
                                name="icon" 
                                value="{{ old('icon', $service->icon) }}"
                                placeholder="e.g., fas fa-laptop-code"
                                style="border-radius: 12px; border: 1.5px solid #e2e8f0;">
                            <small class="text-muted">Browse icons at <a href="https://fontawesome.com/icons" target="_blank">FontAwesome</a></small>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing Details -->
                <div class="table-card mb-4">
                    <div class="table-header">
                        <h2 class="table-title"><i class="fas fa-dollar-sign me-2"></i> Pricing Details</h2>
                    </div>
                    <div style="padding: 2rem;">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="pricing_model" class="form-label fw-semibold">Pricing Model <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg @error('pricing_model') is-invalid @enderror" 
                                    id="pricing_model" 
                                    name="pricing_model" 
                                    required
                                    style="border-radius: 12px; border: 1.5px solid #e2e8f0;">
                                    <option value="">Select Model</option>
                                    <option value="fixed" {{ old('pricing_model', $service->pricing_model) == 'fixed' ? 'selected' : '' }}>Fixed Price</option>
                                    <option value="hourly" {{ old('pricing_model', $service->pricing_model) == 'hourly' ? 'selected' : '' }}>Hourly Rate</option>
                                    <option value="custom" {{ old('pricing_model', $service->pricing_model) == 'custom' ? 'selected' : '' }}>Custom Quote</option>
                                </select>
                                @error('pricing_model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="base_rate" class="form-label fw-semibold">Base Rate <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text" style="border-radius: 12px 0 0 12px; border: 1.5px solid #e2e8f0; background: #f8fafc;">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                    <input type="number" 
                                        class="form-control @error('base_rate') is-invalid @enderror" 
                                        id="base_rate" 
                                        name="base_rate" 
                                        step="0.01" 
                                        min="0"
                                        value="{{ old('base_rate', $service->base_rate) }}" 
                                        required
                                        style="border-radius: 0 12px 12px 0; border: 1.5px solid #e2e8f0; border-left: none;">
                                </div>
                                @error('base_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="estimated_hours" class="form-label fw-semibold">Estimated Hours <small class="text-muted">(Optional)</small></label>
                            <input type="number" 
                                class="form-control @error('estimated_hours') is-invalid @enderror" 
                                id="estimated_hours" 
                                name="estimated_hours" 
                                min="0"
                                value="{{ old('estimated_hours', $service->estimated_hours) }}"
                                style="border-radius: 12px; border: 1.5px solid #e2e8f0;">
                            @error('estimated_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Features -->
                <div class="table-card mb-4">
                    <div class="table-header">
                        <h2 class="table-title"><i class="fas fa-check-circle me-2"></i> Service Features</h2>
                    </div>
                    <div style="padding: 2rem;">
                        <label for="features_input" class="form-label fw-semibold">Features <small class="text-muted">(One per line)</small></label>
                        <textarea class="form-control @error('features_input') is-invalid @enderror" 
                            id="features_input" 
                            name="features_input" 
                            rows="8" 
                            placeholder="Custom design&#10;Responsive layout&#10;SEO optimization&#10;Free support for 30 days"
                            style="border-radius: 12px; border: 1.5px solid #e2e8f0; font-family: 'Courier New', monospace;">{{ old('features_input', is_array($service->features) ? implode("\n", $service->features) : '') }}</textarea>
                        <small class="text-muted">Enter each feature on a new line</small>
                        @error('features_input')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- SEO -->
                <div class="table-card">
                    <div class="table-header">
                        <h2 class="table-title"><i class="fas fa-search me-2"></i> SEO Settings</h2>
                    </div>
                    <div style="padding: 2rem;">
                        <div class="mb-4">
                            <label for="meta_title" class="form-label fw-semibold">Meta Title</label>
                            <input type="text" 
                                class="form-control @error('meta_title') is-invalid @enderror" 
                                id="meta_title" 
                                name="meta_title" 
                                value="{{ old('meta_title', $service->meta_title) }}"
                                style="border-radius: 12px; border: 1.5px solid #e2e8f0;">
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label for="meta_description" class="form-label fw-semibold">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                id="meta_description" 
                                name="meta_description" 
                                rows="3"
                                style="border-radius: 12px; border: 1.5px solid #e2e8f0;">{{ old('meta_description', $service->meta_description) }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Publish Settings -->
                <div class="table-card mb-4">
                    <div class="table-header">
                        <h2 class="table-title">Publish Settings</h2>
                    </div>
                    <div style="padding: 1.5rem;">
                        <div class="mb-4">
                            <div class="form-check form-switch" style="padding-left: 3rem;">
                                <input class="form-check-input" 
                                    type="checkbox" 
                                    id="is_active" 
                                    name="is_active" 
                                    value="1"
                                    {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                                    style="width: 3rem; height: 1.5rem; cursor: pointer;">
                                <label class="form-check-label fw-semibold" for="is_active" style="margin-left: 0.5rem;">
                                    Active Status
                                    <small class="d-block text-muted fw-normal">Make service visible to clients</small>
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch" style="padding-left: 3rem;">
                                <input class="form-check-input" 
                                    type="checkbox" 
                                    id="is_featured" 
                                    name="is_featured" 
                                    value="1"
                                    {{ old('is_featured', $service->is_featured) ? 'checked' : '' }}
                                    style="width: 3rem; height: 1.5rem; cursor: pointer;">
                                <label class="form-check-label fw-semibold" for="is_featured" style="margin-left: 0.5rem;">
                                    Featured Service
                                    <small class="d-block text-muted fw-normal">Highlight this service</small>
                                </label>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label for="sort_order" class="form-label fw-semibold">Sort Order</label>
                            <input type="number" 
                                class="form-control @error('sort_order') is-invalid @enderror" 
                                id="sort_order" 
                                name="sort_order" 
                                min="0"
                                value="{{ old('sort_order', $service->sort_order) }}"
                                style="border-radius: 12px; border: 1.5px solid #e2e8f0;">
                            <small class="text-muted">Lower numbers appear first</small>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="table-card">
                    <div style="padding: 1.5rem;">
                        <button type="submit" class="btn btn-primary w-100 mb-3" style="padding: 0.75rem; font-size: 1rem;">
                            <i class="fas fa-save me-2"></i> Update Service
                        </button>
                        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary w-100" style="padding: 0.75rem;">
                            <i class="fas fa-times me-2"></i> Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
