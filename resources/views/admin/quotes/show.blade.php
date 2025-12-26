@extends('admin.layouts.app')

@section('title', 'Quote Request Details | CodeCraft Studio')
@section('page-title', 'Quote Request Details')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <a href="{{ route('admin.quotes.index') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to
                Quotes</a>
            <h1>Quote Details</h1>
            <p>From {{ $quote->name }} for {{ $quote->project_type }}</p>
        </div>
        <div class="page-actions">
            @if($quote->status === 'new')
                <form action="{{ route('admin.quotes.update', $quote) }}" method="POST" class="d-inline">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="contacted">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check me-2"></i> Mark Contacted</button>
                </form>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Project Details Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Project Information</h3>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold d-block mb-1">Project Type</label>
                        <div class="fs-5 fw-bold text-primary">{{ $quote->project_type }}</div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small text-uppercase fw-bold d-block mb-1">Description</label>
                        <div class="p-3 bg-light rounded text-dark" style="white-space: pre-wrap;">{{ $quote->description }}
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase fw-bold d-block mb-1">Budget Range</label>
                            <div class="fw-medium italic text-muted">{{ $quote->budget_range ?: 'Not specified' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase fw-bold d-block mb-1">Expected Timeline</label>
                            <div class="fw-medium italic text-muted">{{ $quote->timeline ?: 'Not specified' }}</div>
                        </div>
                    </div>

                    @if($quote->services_needed && count($quote->services_needed) > 0)
                        <div>
                            <label class="text-muted small text-uppercase fw-bold d-block mb-2">Services Needed</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($quote->services_needed as $service)
                                    <span
                                        class="badge bg-primary-soft text-primary border border-primary px-3 py-2">{{ $service }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Client Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Client Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase fw-bold d-block mb-1">Full Name</label>
                            <div class="fw-bold">{{ $quote->name }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase fw-bold d-block mb-1">Email Address</label>
                            <div><a href="mailto:{{ $quote->email }}" class="text-decoration-none">{{ $quote->email }}</a>
                            </div>
                        </div>
                        @if($quote->company)
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small text-uppercase fw-bold d-block mb-1">Company</label>
                                <div>{{ $quote->company }}</div>
                            </div>
                        @endif
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase fw-bold d-block mb-1">Submission Date</label>
                            <div class="text-muted italic">{{ $quote->created_at->format('F d, Y \a\t g:i A') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Management Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Management</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="show" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.quotes.update', $quote) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="new" {{ $quote->status == 'new' ? 'selected' : '' }}>New</option>
                                <option value="contacted" {{ $quote->status == 'contacted' ? 'selected' : '' }}>Contacted
                                </option>
                                <option value="quoted" {{ $quote->status == 'quoted' ? 'selected' : '' }}>Quoted</option>
                                <option value="accepted" {{ $quote->status == 'accepted' ? 'selected' : '' }}>Accepted
                                </option>
                                <option value="rejected" {{ $quote->status == 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                                <option value="archived" {{ $quote->status == 'archived' ? 'selected' : '' }}>Archived
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quoted Amount ($)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="quoted_amount" step="0.01" class="form-control"
                                    value="{{ $quote->quoted_amount }}" placeholder="0.00">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Assign To</label>
                            <select name="assigned_to" class="form-select">
                                <option value="">Unassigned</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $quote->assigned_to == $user->id ? 'selected' : '' }}>
                                        {{ $user->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Internal Notes</label>
                            <textarea name="notes" class="form-control" rows="4"
                                placeholder="Add internal notes for your team...">{{ $quote->notes }}</textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h3>Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="mailto:{{ $quote->email }}?subject=Re: Quote Request - {{ $quote->project_type }}"
                            class="btn btn-outline-info">
                            <i class="fas fa-envelope me-2"></i> Send Email
                        </a>
                        <form action="{{ route('admin.quotes.destroy', $quote) }}" method="POST"
                            onsubmit="return confirm('Archive/Delete this quote request?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash-alt me-2"></i> Delete Request
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .bg-primary-soft {
            background-color: rgba(59, 130, 246, 0.1);
        }
    </style>
@endsection