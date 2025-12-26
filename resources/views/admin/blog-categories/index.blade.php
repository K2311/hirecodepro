@extends('admin.layouts.app')

@section('title', 'Blog Categories | CodeCraft Studio')

@section('content')
    <div class="page-header mb-4">
        <div class="page-title">
            <h1 class="fw-bold">
                <a href="{{ route('admin.blog-posts.index') }}" class="text-muted decoration-none me-2"><i
                        class="fas fa-arrow-left"></i></a>
                Blog Categories
            </h1>
            <p class="text-muted small">Organize your posts into logical categories</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.blog-categories.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-plus me-2"></i> Add Category
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="premium-card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.blog-categories.index') }}" method="GET" class="row g-3">
                <div class="col-lg-10">
                    <div class="input-icon-wrapper">
                        <i class="fas fa-search input-icon"></i>
                        <input type="text" name="search" class="form-input-premium ps-5" placeholder="Search categories..."
                            value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-lg-2">
                    <button type="submit" class="btn btn-dark w-100 rounded-pill">
                        <i class="fas fa-search me-2"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="premium-card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th class="ps-4">Category Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th class="text-center">Posts Count</th>
                            <th class="text-center">Status</th>
                            <th class="pe-4 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr class="align-middle">
                                <td class="ps-4 fw-bold text-dark">{{ $category->name }}</td>
                                <td class="font-monospace small opacity-75 text-muted">{{ $category->slug }}</td>
                                <td class="text-muted small" style="max-width: 250px;">
                                    {{ Str::limit($category->description ?: 'No description', 60) }}
                                </td>
                                <td class="text-center fw-bold">{{ $category->posts_count ?? $category->posts()->count() }}</td>
                                <td class="text-center">
                                    @if($category->is_active)
                                        <span class="status-badge cat-active">Active</span>
                                    @else
                                        <span class="status-badge cat-inactive">Inactive</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.blog-categories.edit', $category) }}"
                                            class="btn-action-premium" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.blog-categories.destroy', $category) }}" method="POST"
                                            onsubmit="return confirm('Delete this category?');" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-action-premium danger" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state py-5">
                                        <div class="empty-icon bg-soft-secondary text-muted rounded-circle mx-auto mb-4"
                                            style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-tags fa-2x opacity-50"></i>
                                        </div>
                                        <h3 class="fw-bold">No Categories Found</h3>
                                        <p class="text-muted mx-auto" style="max-width: 300px;">Create categories to start
                                            organizing your blog content.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($categories->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $categories->withQueryString()->links() }}
            </div>
        @endif
    </div>

    <style>
        .decoration-none {
            text-decoration: none;
        }

        .font-monospace {
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        }

        .bg-soft-secondary {
            background-color: #f1f5f9 !important;
            color: #64748b !important;
        }

        .premium-card {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
        }

        body.dark-mode .premium-card {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
        }

        .premium-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .premium-table thead th {
            background: #f8fafc;
            padding: 14px 16px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom: 1px solid #f1f5f9;
        }

        body.dark-mode .premium-table thead th {
            background: rgba(255, 255, 255, 0.02);
            color: #94a3b8;
            border-color: var(--dark-border);
        }

        .premium-table tbody tr:hover {
            background-color: #f8fafc;
            transition: all 0.2s;
        }

        body.dark-mode .premium-table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.02);
        }

        .premium-table tbody td {
            padding: 18px 16px;
            border-bottom: 1px solid #f1f5f9;
        }

        body.dark-mode .premium-table tbody td {
            border-color: var(--dark-border);
        }

        .form-input-premium {
            width: 100%;
            height: 44px;
            padding: 10px 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.9rem;
            transition: all 0.2s;
            outline: none;
        }

        body.dark-mode .form-input-premium {
            background: rgba(255, 255, 255, 0.03);
            border-color: var(--dark-border);
            color: var(--dark-text);
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
            pointer-events: none;
            opacity: 0.7;
        }

        .status-badge {
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            display: inline-block;
            padding: 4px 12px;
        }

        .cat-active {
            background: #dcfce7;
            color: #166534;
        }

        .cat-inactive {
            background: #f1f5f9;
            color: #475569;
        }

        body.dark-mode .cat-inactive {
            background: rgba(255, 255, 255, 0.05);
            color: #94a3b8;
        }

        .btn-action-premium {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #f1f5f9;
            color: #475569;
            border: none;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-action-premium:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .btn-action-premium.danger:hover {
            background: #ef4444;
            color: white;
        }

        body.dark-mode .btn-action-premium {
            background: rgba(255, 255, 255, 0.05);
            color: #94a3b8;
        }
    </style>
@endsection