@extends('admin.layouts.app')

@section('title', 'Add New Client | CodeCraft Admin')
@section('page-title', 'Create Client Profile')

@section('content')
    <div class="container-fluid p-0">
        <div class="page-header mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="fw-bold"><i class="fas fa-user-plus me-2 text-primary"></i>New Client</h1>
                <p class="text-muted">Register a new customer or organization in the system</p>
            </div>
            <a href="{{ route('admin.clients.index') }}" class="btn btn-light rounded-pill px-4 border shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Back to Directory
            </a>
        </div>

        <form action="{{ route('admin.clients.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                <!-- Left Side: Basic Info -->
                <div class="col-lg-8">
                    <div class="premium-card border-0 shadow-sm mb-4">
                        <div class="card-header-premium bg-white py-3 px-4 border-bottom">
                            <h5 class="m-0 fw-bold"><i class="fas fa-id-card me-2 text-primary"></i>Identity & Organization
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label-premium">Full Name <span class="text-danger">*</span></label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-user input-icon"></i>
                                        <input type="text" name="full_name"
                                            class="form-input-premium ps-5 @error('full_name') is-invalid @enderror"
                                            placeholder="John Doe" value="{{ old('full_name') }}" required>
                                    </div>
                                    @error('full_name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label-premium">Email Address <span
                                            class="text-danger">*</span></label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-envelope input-icon"></i>
                                        <input type="email" name="email"
                                            class="form-input-premium ps-5 @error('email') is-invalid @enderror"
                                            placeholder="john@example.com" value="{{ old('email') }}" required>
                                    </div>
                                    @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label-premium">Company / Agency Name</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-building input-icon"></i>
                                        <input type="text" name="company" class="form-input-premium ps-5"
                                            placeholder="Acme Corp" value="{{ old('company') }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label-premium">Position / Job Title</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-briefcase input-icon"></i>
                                        <input type="text" name="position" class="form-input-premium ps-5"
                                            placeholder="Project Manager" value="{{ old('position') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="premium-card border-0 shadow-sm">
                        <div class="card-header-premium bg-white py-3 px-4 border-bottom">
                            <h5 class="m-0 fw-bold"><i class="fas fa-info-circle me-2 text-primary"></i>Additional Context
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label class="form-label-premium">Internal Professional Notes</label>
                                    <textarea name="notes" class="form-input-premium min-h-120"
                                        placeholder="Background information, special requirements, or specific context about this client...">{{ old('notes') }}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check form-switch-premium">
                                        <input class="form-check-input-premium" type="checkbox" name="is_subscribed"
                                            id="is_subscribed" value="1" {{ old('is_subscribed') ? 'checked' : '' }}>
                                        <label class="form-check-label ms-2 py-1" for="is_subscribed">
                                            <span class="fw-bold d-block">Enable Marketing Communications</span>
                                            <span class="text-muted small">Client will receive automated newsletters and
                                                platform updates.</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Logistics & Status -->
                <div class="col-lg-4">
                    <div class="premium-card border-0 shadow-sm mb-4">
                        <div class="card-header-premium bg-white py-3 px-4 border-bottom">
                            <h5 class="m-0 fw-bold"><i class="fas fa-phone-alt me-2 text-primary"></i>Connectivity</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label-premium">Phone Number</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-phone input-icon"></i>
                                        <input type="text" name="phone" class="form-input-premium ps-5"
                                            placeholder="+1 (555) 000-0000" value="{{ old('phone') }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label-premium">Country / Region</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-globe input-icon"></i>
                                        <input type="text" name="country" class="form-input-premium ps-5"
                                            placeholder="United States" value="{{ old('country') }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label-premium">Website URL</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-link input-icon"></i>
                                        <input type="url" name="website" class="form-input-premium ps-5"
                                            placeholder="https://example.com" value="{{ old('website') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="premium-card border-0 shadow-sm mb-4 bg-light-gradient">
                        <div class="card-body p-4 text-center">
                            <label class="form-label-premium mb-3 d-block">Lifecycle Status</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="status" id="status_lead" value="lead" {{ old('status') == 'lead' ? 'checked' : 'checked' }}>
                                <label class="btn btn-outline-warning rounded-pill-start py-2"
                                    for="status_lead">LEAD</label>

                                <input type="radio" class="btn-check" name="status" id="status_active" value="active" {{ old('status') == 'active' ? 'checked' : '' }}>
                                <label class="btn btn-outline-success py-2" for="status_active">ACTIVE</label>

                                <input type="radio" class="btn-check" name="status" id="status_inactive" value="inactive" {{ old('status') == 'inactive' ? 'checked' : '' }}>
                                <label class="btn btn-outline-secondary rounded-pill-end py-2"
                                    for="status_inactive">ARCHIVE</label>
                            </div>
                            <p class="small text-muted mt-3 mb-0">Setting a status helps in automated funnel tracking and
                                reporting.</p>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill shadow-lg fw-bold fs-5">
                        <i class="fas fa-save me-2"></i> Register Client Profile
                    </button>
                </div>
            </div>
        </form>
    </div>

    <style>
        .rounded-pill-start {
            border-top-left-radius: 50px !important;
            border-bottom-left-radius: 50px !important;
        }

        .rounded-pill-end {
            border-top-right-radius: 50px !important;
            border-bottom-right-radius: 50px !important;
        }

        .bg-light-gradient {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .form-label-premium {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-bottom: 8px;
        }

        .form-input-premium {
            width: 100%;
            padding: 12px 16px;
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-input-premium:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .min-h-120 {
            min-height: 120px;
        }

        .input-icon-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
            opacity: 0.7;
        }

        .premium-card {
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
        }

        body.dark-mode .premium-card {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
        }

        body.dark-mode .form-input-premium {
            background: rgba(255, 255, 255, 0.03);
            border-color: var(--dark-border);
            color: #f1f5f9;
        }

        body.dark-mode .btn-light {
            background: #1e293b;
            color: #fff;
            border-color: #334155;
        }

        body.dark-mode .bg-light-gradient {
            background: rgba(255, 255, 255, 0.02);
        }

        .form-switch-premium {
            display: flex;
            align-items: flex-start;
        }

        .form-check-input-premium {
            width: 44px;
            height: 22px;
            cursor: pointer;
        }
    </style>
@endsection