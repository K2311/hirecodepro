@extends('admin.layouts.app')

@section('title', 'Portfolio Management')

@section('content')
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">
                <i class="fas fa-folder-open"></i>
                Portfolio Management
            </h1>
            <p class="page-subtitle">Showcase your best engineering projects and client work</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Add Project
            </a>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card mb-4 filter-card">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.portfolio.index') }}"
                class="d-flex flex-wrap align-items-end filter-form">
                <div class="filter-item">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Title, client, or type..." style="min-width:260px;">
                </div>

                <div class="filter-item">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" style="width:150px;">
                        <option value="">All Status</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                <div class="filter-item">
                    <label for="featured" class="form-label">Featured</label>
                    <select class="form-select" id="featured" name="featured" style="width:140px;">
                        <option value="">All</option>
                        <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>Featured Only</option>
                    </select>
                </div>

                <div class="filter-actions ms-auto">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.portfolio.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Projects Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Projects ({{ $projects->total() }})</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Client</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Created</th>
                        <th width="150" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($project->cover_image_url)
                                        <img src="{{ $project->cover_image_url }}" alt="{{ $project->title }}" class="rounded me-3"
                                            width="50" height="50" style="object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0">{{ $project->title }}</h6>
                                        <small class="text-muted">Slug: {{ $project->slug }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $project->client_name ?: 'N/A' }}</td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info">{{ $project->project_type }}</span>
                            </td>
                            <td>
                                @if($project->is_published)
                                    <span class="status-badge status-published">Published</span>
                                @else
                                    <span class="status-badge status-draft">Draft</span>
                                @endif
                            </td>
                            <td>
                                @if($project->is_featured)
                                    <span class="text-warning"><i class="fas fa-star"></i> Featured</span>
                                @else
                                    <span class="text-muted"><i class="far fa-star"></i> Standard</span>
                                @endif
                            </td>
                            <td>{{ $project->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.portfolio.edit', $project) }}"
                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.portfolio.destroy', $project) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Delete this project?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                <h3>No projects found</h3>
                                <p>Start by adding your first portfolio project.</p>
                                <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary">Add Project</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $projects->links() }}
        </div>
    </div>

    <style>
        .filter-item {
            margin-right: 15px;
            margin-bottom: 10px;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-published {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .status-draft {
            background: rgba(107, 114, 128, 0.1);
            color: #6b7280;
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }
    </style>
@endsection