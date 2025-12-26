@extends('admin.layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <h1 class="page-title">
            <i class="fas fa-box"></i>
            {{ $product->name }}
        </h1>
        <p class="page-subtitle">{{ $product->short_description }}</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i>
            Edit Product
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i>
            Back to Products
        </a>
    </div>
</div>

<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Product Overview -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle"></i>
                    Product Overview
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @if($product->cover_image_url)
                            <div class="mb-4">
                                <label class="form-label fw-bold">Cover Media</label>
                                @php
                                    $url = $product->cover_image_url;
                                    $isYoutube = \Illuminate\Support\Str::contains($url, ['youtube.com','youtu.be']);
                                    $isVideoFile = preg_match('/\.(mp4|webm|ogg|mov|avi)(\?.*)?$/i', $url);
                                @endphp
                                @if($isYoutube)
                                    @php
                                        preg_match('/(youtube.com.*v=|youtu.be\/)([a-zA-Z0-9_-]{6,})/', $url, $m);
                                        $id = $m[2] ?? null;
                                    @endphp
                                    @if($id)
                                        <div class="ratio ratio-16x9">
                                            <iframe src="https://www.youtube.com/embed/{{ $id }}" 
                                                    frameborder="0" 
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                    allowfullscreen
                                                    class="rounded"></iframe>
                                        </div>
                                    @else
                                        <a href="{{ $url }}" target="_blank" class="btn btn-outline-primary btn-sm">Open YouTube Video</a>
                                    @endif
                                @elseif($isVideoFile)
                                    <div class="ratio ratio-16x9">
                                        <video controls class="rounded w-100 h-100">
                                            <source src="{{ $url }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                @else
                                    <img src="{{ $url }}" 
                                         alt="{{ $product->name }}" 
                                         class="img-fluid rounded w-100" 
                                         style="max-height: 300px; object-fit: contain; background: #f8f9fa;">
                                @endif
                            </div>
                        @endif

                        <div class="product-badges mb-3">
                            @if($product->is_featured)
                                <span class="badge bg-warning mb-2 d-inline-flex align-items-center">
                                    <i class="fas fa-star me-1"></i>
                                    Featured Product
                                </span>
                            @endif

                            @if($product->is_on_sale)
                                <span class="badge bg-danger mb-2 d-inline-flex align-items-center">
                                    <i class="fas fa-tags me-1"></i>
                                    On Sale
                                </span>
                            @endif

                            <span class="badge bg-info mb-2">
                                <i class="fas fa-code me-1"></i>
                                {{ ucfirst($product->product_type) }}
                            </span>

                            <span class="badge bg-secondary mb-2">
                                <i class="fas fa-folder me-1"></i>
                                {{ $product->category->name ?? 'N/A' }}
                            </span>

                            @switch($product->status)
                                @case('active')
                                    <span class="badge bg-success mb-2">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Active
                                    </span>
                                    @break
                                @case('inactive')
                                    <span class="badge bg-secondary mb-2">
                                        <i class="fas fa-pause-circle me-1"></i>
                                        Inactive
                                    </span>
                                    @break
                                @case('draft')
                                    <span class="badge bg-warning mb-2">
                                        <i class="fas fa-edit me-1"></i>
                                        Draft
                                    </span>
                                    @break
                                @case('archived')
                                    <span class="badge bg-dark mb-2">
                                        <i class="fas fa-archive me-1"></i>
                                        Archived
                                    </span>
                                    @break
                            @endswitch
                        </div>

                        @if($product->preview_images && count($product->preview_images))
                            <div class="mt-4">
                                <label class="form-label fw-bold">Gallery</label>
                                <div class="row g-2 mt-2">
                                    @foreach($product->preview_images as $index => $mediaItem)
                                        @php
                                            // Handle both string URLs and rich objects {url, title, description}
                                            if (is_string($mediaItem)) {
                                                $mediaUrl = $mediaItem;
                                            } elseif (is_array($mediaItem) && isset($mediaItem['url'])) {
                                                $mediaUrl = $mediaItem['url'];
                                            } else {
                                                continue; // Skip invalid items
                                            }
                                            
                                            $isYoutube = \Illuminate\Support\Str::contains($mediaUrl, ['youtube.com','youtu.be']);
                                            $isVideoFile = preg_match('/\.(mp4|webm|ogg|mov|avi)(\?.*)?$/i', $mediaUrl);
                                        @endphp
                                        <div class="col-4 col-md-3">
                                            <div class="gallery-thumbnail position-relative rounded overflow-hidden bg-light" 
                                                 style="padding-top: 56.25%; cursor: pointer;" 
                                                 data-bs-toggle="modal" 
                                                 data-bs-target="#galleryModal"
                                                 data-index="{{ $index }}">
                                                @if($isYoutube)
                                                    @php 
                                                        preg_match('/(youtube.com.*v=|youtu.be\/)([a-zA-Z0-9_-]{6,})/', $mediaUrl, $m); 
                                                        $id = $m[2] ?? null; 
                                                    @endphp
                                                    @if($id)
                                                        <img src="https://img.youtube.com/vi/{{ $id }}/hqdefault.jpg" 
                                                             alt="YouTube Thumbnail" 
                                                             class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover">
                                                        <div class="position-absolute top-50 start-50 translate-middle">
                                                            <i class="fas fa-play-circle text-white fs-3 opacity-75"></i>
                                                        </div>
                                                    @else
                                                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                                            <i class="fas fa-external-link-alt"></i>
                                                        </div>
                                                    @endif
                                                @elseif($isVideoFile)
                                                    <video class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" muted>
                                                        <source src="{{ $mediaUrl }}" type="video/mp4">
                                                    </video>
                                                    <div class="position-absolute top-50 start-50 translate-middle">
                                                        <i class="fas fa-play-circle text-white fs-3 opacity-75"></i>
                                                    </div>
                                                @else
                                                    <img src="{{ $mediaUrl }}" 
                                                         alt="Gallery Image {{ $index + 1 }}" 
                                                         class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover">
                                                @endif
                                                <div class="position-absolute bottom-0 end-0 m-1">
                                                    <span class="badge bg-dark bg-opacity-75">
                                                        @if($isYoutube)
                                                            <i class="fab fa-youtube me-1"></i> Video
                                                        @elseif($isVideoFile)
                                                            <i class="fas fa-video me-1"></i> Video
                                                        @else
                                                            <i class="fas fa-image me-1"></i> Image
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="pricing-card bg-primary text-white rounded p-4 mb-4">
                            <h4 class="text-white mb-3">
                                <i class="fas fa-dollar-sign me-2"></i>
                                Pricing Information
                            </h4>
                            
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-grow-1">
                                    <div class="text-white-50 small">Base Price</div>
                                    <div class="h3 mb-0 text-white">${{ number_format($product->base_price, 2) }}</div>
                                </div>
                                @if($product->sale_price)
                                    <div class="text-end">
                                        <div class="text-white-50 small">Sale Price</div>
                                        <div class="h3 mb-0 text-warning">${{ number_format($product->sale_price, 2) }}</div>
                                    </div>
                                @endif
                            </div>

                            @if($product->cost_price)
                                <div class="mb-3">
                                    <div class="text-white-50 small">Cost Price</div>
                                    <div class="text-white">${{ number_format($product->cost_price, 2) }}</div>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-white-50 small">License Type</div>
                                    <div class="badge bg-white text-primary">{{ ucfirst(str_replace('_', ' ', $product->license_type)) }}</div>
                                </div>
                                @if($product->version)
                                    <div class="text-end">
                                        <div class="text-white-50 small">Version</div>
                                        <div class="text-white fw-bold">{{ $product->version }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Additional Info
                                </h6>
                                
                                @if($product->published_at)
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Published Date</span>
                                        <span class="fw-bold">{{ $product->published_at->format('M d, Y H:i') }}</span>
                                    </div>
                                @endif
                                
                                @if($product->created_at)
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Created Date</span>
                                        <span class="fw-bold">{{ $product->created_at->format('M d, Y') }}</span>
                                    </div>
                                @endif
                                
                                @if($product->updated_at)
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">Last Updated</span>
                                        <span class="fw-bold">{{ $product->updated_at->format('M d, Y') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Full Description -->
        @if($product->full_description)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-align-left"></i>
                    Full Description
                </h5>
            </div>
            <div class="card-body">
                <div class="product-description">
                    {!! nl2br(e($product->full_description)) !!}
                </div>
            </div>
        </div>
        @endif

        <!-- Technical Details -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-code"></i>
                    Technical Details
                </h5>
            </div>
            <div class="card-body">
                @if($product->tech_stack && count($product->tech_stack) > 0)
                    <div class="mb-4">
                        <label class="form-label fw-bold">Technology Stack</label>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @foreach($product->tech_stack as $tech)
                                <span class="badge bg-primary d-flex align-items-center">
                                    <i class="fas fa-tag me-1"></i>
                                    {{ $tech }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($product->dependencies && count($product->dependencies) > 0)
                    <div class="mb-4">
                        <label class="form-label fw-bold small">Dependencies</label>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @foreach($product->dependencies as $dep)
                                <span class="badge bg-secondary d-flex align-items-center">
                                    <i class="fas fa-cubes me-1"></i>
                                    {{ $dep }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($product->requirements)
                    <div class="mb-4">
                        <label class="form-label fw-bold">System Requirements</label>
                        <div class="mt-2">
                            <pre class="bg-light p-3 rounded border"><code class="text-dark">{{ $product->requirements }}</code></pre>
                        </div>
                    </div>
                @endif

                @if($product->license_terms)
                    <div>
                        <label class="form-label fw-bold">License Terms</label>
                        <div class="mt-2">
                            <div class="bg-light p-3 rounded border">
                                {!! nl2br(e($product->license_terms)) !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Links & Resources -->
        @if($product->demo_url || $product->documentation_url || $product->github_url)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-link"></i>
                    Links & Resources
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @if($product->demo_url)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded border">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-play-circle fs-2 text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="fw-bold">Live Demo</div>
                                    <a href="{{ $product->demo_url }}" target="_blank" class="text-truncate d-block">
                                        {{ $product->demo_url }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($product->documentation_url)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded border">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-book fs-2 text-success"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="fw-bold">Documentation</div>
                                    <a href="{{ $product->documentation_url }}" target="_blank" class="text-truncate d-block">
                                        {{ $product->documentation_url }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($product->github_url)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded border">
                                <div class="flex-shrink-0">
                                    <i class="fab fa-github fs-2 text-dark"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="fw-bold">GitHub Repository</div>
                                    <a href="{{ $product->github_url }}" target="_blank" class="text-truncate d-block">
                                        {{ $product->github_url }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Changelog -->
        @if($product->changelog)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history"></i>
                    Changelog
                </h5>
            </div>
            <div class="card-body">
                <pre class="bg-light p-3 rounded border"><code class="text-dark">{{ $product->changelog }}</code></pre>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Statistics -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar"></i>
                    Statistics
                </h5>
            </div>
            <div class="card-body">
                <div class="product-stats">
                    <div class="stat-card mb-3">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-label">Total Views</div>
                            <div class="stat-value">{{ number_format($product->view_count ?? 0) }}</div>
                        </div>
                    </div>

                    <div class="stat-card mb-3">
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-download"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-label">Downloads</div>
                            <div class="stat-value">{{ number_format($product->download_count ?? 0) }}</div>
                        </div>
                    </div>

                    <div class="stat-card mb-3">
                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-label">Purchases</div>
                            <div class="stat-value">{{ number_format($product->purchase_count ?? 0) }}</div>
                        </div>
                    </div>

                    @if($product->average_rating)
                    <div class="stat-card mb-3">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-label">Average Rating</div>
                            <div class="stat-value">{{ number_format($product->average_rating, 1) }} / 5.0</div>
                        </div>
                    </div>
                    @endif

                    <div class="stat-card mb-3">
                        <div class="stat-icon bg-secondary bg-opacity-10 text-secondary">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-label">Created</div>
                            <div class="stat-value">{{ $product->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>

                    @if($product->published_at)
                    <div class="stat-card">
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-label">Published</div>
                            <div class="stat-value">{{ $product->published_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- SEO Information -->
        @if($product->meta_title || $product->meta_description || $product->meta_keywords)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-search"></i>
                    SEO Information
                </h5>
            </div>
            <div class="card-body">
                @if($product->meta_title)
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Meta Title</label>
                        <div class="p-2 bg-light rounded border">{{ $product->meta_title }}</div>
                    </div>
                @endif

                @if($product->meta_description)
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Meta Description</label>
                        <div class="p-2 bg-light rounded border">{{ $product->meta_description }}</div>
                    </div>
                @endif

                @if($product->meta_keywords)
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Meta Keywords</label>
                        <div class="d-flex flex-wrap gap-1 mt-1">
                            @foreach(explode(',', $product->meta_keywords) as $keyword)
                                @if(trim($keyword))
                                    <span class="badge bg-secondary">{{ trim($keyword) }}</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="button" 
                            class="btn {{ $product->is_featured ? 'btn-warning' : 'btn-outline-warning' }} toggle-featured"
                            data-url="{{ route('admin.products.toggle-featured', $product) }}">
                        <i class="fas fa-star me-2"></i>
                        {{ $product->is_featured ? 'Remove from Featured' : 'Mark as Featured' }}
                    </button>

                    <button type="button" 
                            class="btn {{ $product->is_on_sale ? 'btn-danger' : 'btn-outline-danger' }} toggle-sale"
                            data-url="{{ route('admin.products.toggle-sale', $product) }}">
                        <i class="fas fa-tags me-2"></i>
                        {{ $product->is_on_sale ? 'Remove from Sale' : 'Put on Sale' }}
                    </button>

                    <button type="button" 
                            class="btn btn-outline-dark delete-product" 
                            data-url="{{ route('admin.products.destroy', $product) }}" 
                            data-name="{{ $product->name }}">
                        <i class="fas fa-trash me-2"></i>
                        Delete Product
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gallery Modal -->
@if($product->preview_images && count($product->preview_images))
<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="galleryCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($product->preview_images as $index => $mediaItem)
                            @php
                                // Handle both string URLs and rich objects
                                if (is_string($mediaItem)) {
                                    $mediaUrl = $mediaItem;
                                } elseif (is_array($mediaItem) && isset($mediaItem['url'])) {
                                    $mediaUrl = $mediaItem['url'];
                                } else {
                                    continue; // Skip invalid items
                                }
                                
                                $isYoutube = \Illuminate\Support\Str::contains($mediaUrl, ['youtube.com','youtu.be']);
                                $isVideoFile = preg_match('/\.(mp4|webm|ogg|mov|avi)(\?.*)?$/i', $mediaUrl);
                            @endphp
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                @if($isYoutube)
                                    @php 
                                        preg_match('/(youtube.com.*v=|youtu.be\/)([a-zA-Z0-9_-]{6,})/', $mediaUrl, $m); 
                                        $id = $m[2] ?? null; 
                                    @endphp
                                    @if($id)
                                        <div class="ratio ratio-16x9">
                                            <iframe src="https://www.youtube.com/embed/{{ $id }}" 
                                                    frameborder="0" 
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                    allowfullscreen></iframe>
                                        </div>
                                    @else
                                        <div class="text-center p-5">
                                            <i class="fas fa-external-link-alt fa-3x mb-3"></i>
                                            <p>YouTube Video</p>
                                            <a href="{{ $mediaUrl }}" target="_blank" class="btn btn-primary">Open Link</a>
                                        </div>
                                    @endif
                                @elseif($isVideoFile)
                                    <div class="ratio ratio-16x9">
                                        <video controls class="w-100 h-100">
                                            <source src="{{ $mediaUrl }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <img src="{{ $mediaUrl }}" 
                                             alt="Gallery Image {{ $index + 1 }}" 
                                             class="img-fluid rounded" 
                                             style="max-height: 70vh;">
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    @if(count($product->preview_images) > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <div class="w-100 text-center">
                    <span id="galleryCounter" class="badge bg-dark">
                        1 / {{ count($product->preview_images) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<!-- Bootstrap 5 for Modal and Carousel -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
/* Existing pricing-card and other styles */
.pricing-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.pricing-card h4 {
    margin-bottom: 1rem;
    color: white;
}

/* Product stats */
.product-stats {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-radius: 8px;
    background-color: #f8f9fa;
    border: 1px solid #e3e6f0;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.stat-content {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.stat-label {
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 600;
}

.stat-value {
    font-size: 1.25rem;
    font-weight: 800;
    color: #212529;
}

.product-description {
    line-height: 1.6;
    color: #495057;
}

.product-description p {
    margin-bottom: 1rem;
}

.license-terms {
    line-height: 1.6;
    color: #495057;
}

pre {
    white-space: pre-wrap;
    word-wrap: break-word;
    font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
    font-size: 0.875rem;
}

/* Gallery thumbnail */
.gallery-thumbnail {
    transition: all 0.3s ease;
}

.gallery-thumbnail:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.gallery-thumbnail img,
.gallery-thumbnail video {
    transition: transform 0.3s ease;
}

.object-fit-cover {
    object-fit: cover;
}

/* Carousel styles */
.carousel-item img,
.carousel-item video,
.carousel-item iframe {
    max-height: 70vh;
    object-fit: contain;
}

/* Product badges */
.product-badges .badge {
    font-size: 0.85rem;
    padding: 0.5em 0.8em;
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
    display: inline-flex;
    align-items: center;
}

/* Quick actions grid */
.d-grid.gap-2 > .btn {
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.d-grid.gap-2 > .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

@media (max-width: 768px) {
    .product-stats {
        grid-template-columns: 1fr;
    }
    
    .gallery-thumbnail {
        margin-bottom: 0.5rem;
    }
    
    .d-grid.gap-2 > .btn {
        padding: 0.65rem 0.75rem;
        font-size: 0.9rem;
    }
}

/* Toast notification */
.toast {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1060;
    min-width: 300px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    border-left: 4px solid #007bff;
    transform: translateX(400px);
    transition: transform 0.3s ease;
    overflow: hidden;
}

.toast.show {
    transform: translateX(0);
}

.toast.success {
    border-left-color: #28a745;
}

.toast.error {
    border-left-color: #dc3545;
}

.toast.warning {
    border-left-color: #ffc107;
}

.toast-content {
    display: flex;
    align-items: center;
    padding: 1rem;
    gap: 0.75rem;
}

.toast-close {
    position: absolute;
    top: 10px;
    right: 10px;
    background: none;
    border: none;
    font-size: 1.25rem;
    cursor: pointer;
    color: #6c757d;
    padding: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
}

.toast-close:hover {
    background: #f8f9fa;
    color: #495057;
}
</style>
@endpush

@push('scripts')
<!-- Bootstrap 5 JS Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize gallery carousel
    const galleryCarousel = document.getElementById('galleryCarousel');
    if (galleryCarousel) {
        const carousel = new bootstrap.Carousel(galleryCarousel);
        
        // Update counter
        galleryCarousel.addEventListener('slide.bs.carousel', function(event) {
            const total = {{ count($product->preview_images ?? []) }};
            const current = event.to + 1;
            document.getElementById('galleryCounter').textContent = `${current} / ${total}`;
        });
    }

    // Gallery thumbnail click handler
    document.querySelectorAll('.gallery-thumbnail').forEach(thumb => {
        thumb.addEventListener('click', function() {
            const index = parseInt(this.dataset.index);
            if (galleryCarousel) {
                const carousel = bootstrap.Carousel.getInstance(galleryCarousel);
                if (carousel) {
                    carousel.to(index);
                }
            }
        });
    });

    // Toggle Featured
    document.querySelector('.toggle-featured')?.addEventListener('click', async function() {
        const url = this.dataset.url;
        const button = this;
        
        if (button.disabled) return;
        button.disabled = true;
        
        const originalText = button.innerHTML;
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
        
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                // Update button appearance
                if (data.is_featured) {
                    button.classList.remove('btn-outline-warning');
                    button.classList.add('btn-warning');
                    button.innerHTML = '<i class="fas fa-star me-2"></i> Remove from Featured';
                } else {
                    button.classList.remove('btn-warning');
                    button.classList.add('btn-outline-warning');
                    button.innerHTML = '<i class="fas fa-star me-2"></i> Mark as Featured';
                }
                
                showToast(data.message, 'success');
                
                // Reload page after 1 second to update all UI elements
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showToast(data.message || 'Action failed', 'error');
                button.innerHTML = originalText;
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('An error occurred. Please try again.', 'error');
            button.innerHTML = originalText;
        } finally {
            button.disabled = false;
        }
    });

    // Toggle Sale
    document.querySelector('.toggle-sale')?.addEventListener('click', async function() {
        const url = this.dataset.url;
        const button = this;
        
        if (button.disabled) return;
        button.disabled = true;
        
        const originalText = button.innerHTML;
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
        
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                // Update button appearance
                if (data.is_on_sale) {
                    button.classList.remove('btn-outline-danger');
                    button.classList.add('btn-danger');
                    button.innerHTML = '<i class="fas fa-tags me-2"></i> Remove from Sale';
                } else {
                    button.classList.remove('btn-danger');
                    button.classList.add('btn-outline-danger');
                    button.innerHTML = '<i class="fas fa-tags me-2"></i> Put on Sale';
                }
                
                showToast(data.message, 'success');
                
                // Reload page after 1 second
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showToast(data.message || 'Action failed', 'error');
                button.innerHTML = originalText;
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('An error occurred. Please try again.', 'error');
            button.innerHTML = originalText;
        } finally {
            button.disabled = false;
        }
    });

    // Delete Product
    document.querySelector('.delete-product')?.addEventListener('click', function() {
        const url = this.dataset.url;
        const name = this.dataset.name;
        
        if (confirm(`Are you sure you want to delete "${name}"? This action cannot be undone. All associated data will be permanently removed.`)) {
            // Disable button to prevent multiple clicks
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...';
            
            // Create and submit delete form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            form.style.display = 'none';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);

            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(methodField);

            document.body.appendChild(form);
            form.submit();
        }
    });

    // Toast notification function
    function showToast(message, type = 'info') {
        // Remove existing toasts
        document.querySelectorAll('.toast').forEach(toast => {
            toast.remove();
        });

        const icon = {
            'success': 'fa-check-circle text-success',
            'error': 'fa-exclamation-circle text-danger',
            'warning': 'fa-exclamation-triangle text-warning',
            'info': 'fa-info-circle text-primary'
        }[type] || 'fa-info-circle text-primary';

        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="fas ${icon}"></i>
                <span>${message}</span>
            </div>
            <button class="toast-close">&times;</button>
        `;

        document.body.appendChild(toast);

        // Show toast
        setTimeout(() => toast.classList.add('show'), 100);

        // Auto remove after 3 seconds
        const autoRemove = setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 300);
        }, 3000);

        // Manual close
        toast.querySelector('.toast-close').addEventListener('click', () => {
            clearTimeout(autoRemove);
            toast.classList.remove('show');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 300);
        });
    }
});
</script>
@endpush