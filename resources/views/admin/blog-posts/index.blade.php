@extends('admin.layouts.app')

@section('title', 'Blog Posts | CodeCraft Studio')

@section('content')
    <div class="page-header mb-4">
        <div class="page-title">
            <h1 class="fw-bold">Blog Posts</h1>
            <p class="text-muted small">Manage your content and articles</p>
        </div>
        <div class="page-actions d-flex gap-2">
            <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                <i class="fas fa-tags me-2"></i> Categories
            </a>
            <a href="{{ route('admin.blog-posts.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-plus me-2"></i> Create New Post
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="premium-card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.blog-posts.index') }}" method="GET" class="row g-3">
                <div class="col-lg-4">
                    <div class="input-icon-wrapper">
                        <i class="fas fa-search input-icon"></i>
                        <input type="text" name="search" class="form-input-premium ps-5" placeholder="Search posts..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="select-wrapper">
                        <select name="category" class="form-select-premium">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="select-wrapper">
                        <select name="status" class="form-select-premium">
                            <option value="">All Statuses</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        </select>
                        <i class="fas fa-chevron-down select-icon"></i>
                    </div>
                </div>
                <div class="col-lg-2">
                    <button type="submit" class="btn btn-dark w-100 rounded-pill h-100">
                        <i class="fas fa-filter me-2"></i> Filter
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
                            <th class="ps-4" style="width: 80px;">Cover</th>
                            <th>Post Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Featured</th>
                            <th>Created</th>
                            <th class="pe-4 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr class="align-middle">
                                <td class="ps-4">
                                    @if($post->cover_image_url)
                                        <div class="cover-wrapper">
                                            <img src="{{ $post->cover_image_url }}" alt="" class="rounded-3 shadow-sm cover-img">
                                        </div>
                                    @else
                                        <div class="bg-soft-secondary rounded-3 d-flex align-items-center justify-content-center shadow-sm cover-placeholder">
                                            <i class="fas fa-image text-muted opacity-50"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark fs-6">{{ $post->title }}</div>
                                    <div class="text-muted small font-monospace opacity-75">/{{ Str::limit($post->slug, 30) }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-soft-info text-info px-3 py-2 rounded-pill fw-bold" style="font-size: 0.65rem;">
                                        {{ $post->category->name }}
                                    </span>
                                </td>
                                <td class="text-muted fw-medium">{{ $post->author->name }}</td>
                                <td class="text-center">
                                    @if($post->status === 'published')
                                        <span class="status-badge blog-published">Published</span>
                                    @elseif($post->status === 'draft')
                                        <span class="status-badge blog-draft">Draft</span>
                                    @else
                                        <span class="status-badge blog-scheduled">Scheduled</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($post->is_featured)
                                        <span class="badge bg-soft-warning text-warning p-2 rounded-circle">
                                            <i class="fas fa-star"></i>
                                        </span>
                                    @else
                                        <span class="text-muted opacity-25">
                                            <i class="far fa-star"></i>
                                        </span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $post->created_at->format('M d, Y') }}</td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.blog-posts.edit', $post) }}" class="btn-action-premium" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.blog-posts.destroy', $post) }}" method="POST"
                                            onsubmit="return confirm('Delete this post?');" class="d-inline">
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
                                <td colspan="8" class="text-center py-5">
                                    <div class="empty-state py-5">
                                        <div class="empty-icon bg-soft-secondary text-muted rounded-circle mx-auto mb-4"
                                            style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-newspaper fa-2x opacity-50"></i>
                                        </div>
                                        <h3 class="fw-bold">No Blog Posts Found</h3>
                                        <p class="text-muted mx-auto" style="max-width: 300px;">Start your blog by creating your first post.</p>
                                        <a href="{{ route('admin.blog-posts.create') }}" class="btn btn-primary rounded-pill px-4 mt-3">Create Post</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($posts->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $posts->withQueryString()->links() }}
            </div>
        @endif
    </div>

    <style>
        .font-monospace { font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; }
        .bg-soft-primary { background-color: rgba(59, 130, 246, 0.1) !important; color: #3b82f6 !important; }
        .bg-soft-success { background-color: rgba(16, 185, 129, 0.1) !important; color: #10b981 !important; }
        .bg-soft-warning { background-color: rgba(245, 158, 11, 0.1) !important; color: #f59e0b !important; }
        .bg-soft-danger { background-color: rgba(239, 68, 68, 0.1) !important; color: #ef4444 !important; }
        .bg-soft-info { background-color: rgba(6, 182, 212, 0.1) !important; color: #0891b2 !important; }
        .bg-soft-secondary { background-color: #f1f5f9 !important; color: #64748b !important; }
        
        .premium-card { background: #ffffff; border-radius: 16px; overflow: hidden; }
        body.dark-mode .premium-card { background: var(--dark-card); border: 1px solid var(--dark-border); }
        
        .premium-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .premium-table thead th { background: #f8fafc; padding: 14px 16px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; border-bottom: 1px solid #f1f5f9; }
        body.dark-mode .premium-table thead th { background: rgba(255, 255, 255, 0.02); color: #94a3b8; border-color: var(--dark-border); }
        .premium-table tbody tr:hover { background-color: #f8fafc; transition: all 0.2s; }
        body.dark-mode .premium-table tbody tr:hover { background-color: rgba(255, 255, 255, 0.02); }
        .premium-table tbody td { padding: 18px 16px; border-bottom: 1px solid #f1f5f9; }
        body.dark-mode .premium-table tbody td { border-color: var(--dark-border); }

        .form-input-premium, .form-select-premium { width: 100%; height: 44px; padding: 10px 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; transition: all 0.2s; outline: none; }
        body.dark-mode .form-input-premium, body.dark-mode .form-select-premium { background: rgba(255, 255, 255, 0.03); border-color: var(--dark-border); color: var(--dark-text); }
        .select-wrapper, .input-icon-wrapper { position: relative; }
        .select-icon, .input-icon { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; opacity: 0.7; }
        .input-icon { left: 16px; right: auto; }

        .cover-img { width: 60px; height: 40px; object-fit: cover; }
        .cover-placeholder { width: 60px; height: 40px; }
        
        .status-badge { border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-block; padding: 4px 12px; }
        .blog-published { background: #dcfce7; color: #166534; }
        .blog-draft { background: #f1f5f9; color: #475569; }
        .blog-scheduled { background: #e0f2fe; color: #0369a1; }
        body.dark-mode .blog-draft { background: rgba(255, 255, 255, 0.05); color: #94a3b8; }

        .btn-action-premium { 
            width: 32px; height: 32px; 
            display: flex; align-items: center; justify-content: center; 
            border-radius: 8px; background: #f1f5f9; color: #475569; 
            border: none; transition: all 0.2s; text-decoration: none;
        }
        .btn-action-premium:hover { background: var(--primary); color: white; transform: translateY(-2px); }
        .btn-action-premium.danger:hover { background: #ef4444; color: white; }
        body.dark-mode .btn-action-premium { background: rgba(255, 255, 255, 0.05); color: #94a3b8; }
    </style>
@endsection