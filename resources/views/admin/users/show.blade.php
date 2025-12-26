@extends('admin.layouts.app')

@section('title', 'User Details | CodeCraft Studio')
@section('page-title', 'User Details')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h1>User Details</h1>
            <p>View detailed information about {{ $user->full_name }}</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i>
                Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Users
            </a>
        </div>
    </div>

    <!-- User Profile Card -->
    <div class="card" style="margin-bottom: 24px;">
        <div class="card-body">
            <div class="user-profile">
                <div class="user-avatar-large">
                    @if($user->avatar_url)
                        <img src="{{ $user->avatar_url }}" alt="Avatar">
                    @else
                        <div class="avatar-placeholder-large">
                            {{ strtoupper(substr($user->full_name ?? $user->username, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="user-details">
                    <h2 class="user-name">{{ $user->full_name }}</h2>
                    <p class="user-email">{{ $user->email }}</p>
                    <p class="user-username">@{{ $user->username }}</p>
                    <div class="user-meta">
                        <span class="status-badge status-{{ $user->role }}">
                            {{ ucfirst($user->role) }}
                        </span>
                        <span class="status-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Information -->
    <div class="grid grid-cols-2 gap-6">
        <!-- Basic Info -->
        <div class="card">
            <div class="card-header">
                <h3>Account Information</h3>
            </div>
            <div class="card-body">
                <div class="info-list">
                    <div class="info-item">
                        <span class="info-label">Full Name:</span>
                        <span class="info-value">{{ $user->full_name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Username:</span>
                        <span class="info-value">{{ $user->username }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $user->email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Role:</span>
                        <span class="info-value">{{ ucfirst($user->role) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status:</span>
                        <span class="info-value">
                            <span class="status-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Joined:</span>
                        <span class="info-value">{{ $user->created_at->format('F d, Y \a\t g:i A') }}</span>
                    </div>
                    @if($user->last_login)
                        <div class="info-item">
                            <span class="info-label">Last Login:</span>
                            <span class="info-value">{{ $user->last_login->format('F d, Y \a\t g:i A') }}</span>
                        </div>
                    @endif
                    <div class="info-item">
                        <span class="info-label">Email Verified:</span>
                        <span class="info-value">
                            @if($user->email_verified_at)
                                <span class="text-success">Yes</span>
                            @else
                                <span class="text-muted">No</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Summary -->
        <div class="card">
            <div class="card-header">
                <h3>Activity Summary</h3>
            </div>
            <div class="card-body">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value">{{ $user->products()->count() }}</div>
                        <div class="stat-label">Products Created</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $user->blogPosts()->count() }}</div>
                        <div class="stat-label">Blog Posts</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $user->activityLogs()->count() }}</div>
                        <div class="stat-label">Activity Logs</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $user->assignedInquiries()->count() }}</div>
                        <div class="stat-label">Assigned Inquiries</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection