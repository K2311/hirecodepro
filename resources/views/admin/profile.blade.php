@extends('admin.layouts.app')

@section('title', 'My Profile | CodeCraft Studio')

@section('page-title', 'My Profile')

@section('content')
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile Card -->
            <div class="table-card" style="text-align: center; padding: 2rem;">
                <div style="width: 100px; height: 100px; background-color: #e2e8f0; border-radius: 50%; margin: 0 auto 1.5rem; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: #64748b;">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <h3 style="margin-bottom: 0.5rem; font-size: 1.25rem; font-weight: 600;">{{ auth()->user()->name }}</h3>
                <p style="color: #64748b; margin-bottom: 1.5rem;">{{ auth()->user()->email }}</p>
                
                <div style="display: flex; gap: 0.5rem; justify-content: center;">
                    <span class="status-badge status-completed">Admin</span>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="table-card">
                <div class="table-header">
                    <h2 class="table-title">Profile Details</h2>
                    <div class="table-actions">
                        <a href="{{ route('admin.users.edit', auth()->user()) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                            Edit Profile
                        </a>
                    </div>
                </div>

                <div style="padding: 2rem;">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h4 style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.5rem;">Full Name</h4>
                            <p style="font-size: 1rem; font-weight: 500;">{{ auth()->user()->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h4 style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.5rem;">Email Address</h4>
                            <p style="font-size: 1rem; font-weight: 500;">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <h4 style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.5rem;">Account Created</h4>
                            <p style="font-size: 1rem; font-weight: 500;">{{ auth()->user()->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h4 style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.5rem;">Role</h4>
                            <p style="font-size: 1rem; font-weight: 500;">Administrator</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
