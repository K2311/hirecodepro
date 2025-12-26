@extends('admin.layouts.app')

@section('title', 'Users | CodeCraft Studio')
@section('page-title', 'User Management')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h1>Users</h1>
            <p>Manage user accounts and permissions</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Add New User
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card" style="margin-bottom: 24px;">
        <div class="card-body">
            <form action="{{ route('admin.users.index') }}" method="GET" class="filters-form">
                <div class="form-group">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by name, email, or username"
                        class="form-control" style="min-width: 300px;">
                </div>
                <div class="form-group">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" style="min-width: 150px;">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="developer" {{ request('role') == 'developer' ? 'selected' : '' }}>Developer</option>
                        <option value="client" {{ request('role') == 'client' ? 'selected' : '' }}>Client</option>
                    </select>
                </div>
                <div class="form-group">
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        @if(request('search') || request('role'))
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Reset</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header">
            <h3>Users ({{ $users->total() }})</h3>
        </div>
        <div class="card-body">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-avatar">
                                                @if($user->avatar_url)
                                                    <img src="{{ $user->avatar_url }}" alt="Avatar">
                                                @else
                                                    <div class="avatar-placeholder">
                                                        {{ strtoupper(substr($user->full_name ?? $user->username, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="user-info">
                                                <div class="user-name">{{ $user->full_name }}</div>
                                                <div class="user-email">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $user->role }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-secondary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if(auth()->id() !== $user->id)
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this user?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-container">
                    {{ $users->withQueryString()->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <h3>No users found</h3>
                    <p>{{ request('search') || request('role') ? 'Try adjusting your filters.' : 'Get started by adding your first user.' }}</p>
                    @if(!request('search') && !request('role'))
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add New User</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection