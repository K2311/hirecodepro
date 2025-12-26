@extends('admin.layouts.app')

@section('title', 'Edit User | CodeCraft Studio')
@section('page-title', 'Edit User')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h1>Edit User</h1>
            <p>Update user account information</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary">
                <i class="fas fa-eye"></i>
                View User
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Users
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Edit User: {{ $user->full_name }}</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="form">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}"
                            class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Username *</label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}"
                            class="form-control" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Email Address *</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Role *</label>
                        <select name="role" class="form-select" required>
                            <option value="client" {{ old('role', $user->role) == 'client' ? 'selected' : '' }}>Client</option>
                            <option value="developer" {{ old('role', $user->role) == 'developer' ? 'selected' : '' }}>Developer</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">New Password (leave blank to keep current)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="is_active" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        Active Account
                    </label>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
@endsection