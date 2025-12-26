@extends('layouts.app')

@section('title', 'Shop Premium Code - HireCodePro')
@section('meta_description', 'Browse our collection of premium SaaS templates, APIs, and plugins to accelerate your development.')

@section('content')
    <!-- Hero Section -->
    <section class="shop-hero"
        style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 100px 0 60px; color: white; text-align: center;">
        <div class="container">
            <h1
                style="font-size: 3.5rem; font-weight: 800; margin-bottom: 20px; background: linear-gradient(to right, #fff, #94a3b8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Premium Code Shop</h1>
            <p style="font-size: 1.25rem; color: #94a3b8; max-width: 700px; margin: 0 auto;">Everything you need to build
                faster and smarter. From production-ready templates to powerful APIs.</p>
        </div>
    </section>

    <!-- Shop Content -->
    <section class="section" style="background-color: var(--bg-secondary); padding: 60px 0;">
        <div class="container">
            <div class="shop-layout">
                <!-- Sidebar Filters -->
                <aside class="shop-sidebar">
                    <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                        <div class="filter-card">
                            <h3 class="filter-title">Search</h3>
                            <div class="search-box">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="What are you looking for?">
                                <button type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </div>

                        <div class="filter-card">
                            <h3 class="filter-title">Categories</h3>
                            <div class="filter-options">
                                <label class="filter-option">
                                    <input type="radio" name="type" value="" {{ !request('type') ? 'checked' : '' }}
                                        onchange="this.form.submit()">
                                    <span>All Products</span>
                                </label>
                                @foreach($productTypes as $type)
                                    <label class="filter-option">
                                        <input type="radio" name="type" value="{{ $type }}" {{ request('type') == $type ? 'checked' : '' }} onchange="this.form.submit()">
                                        <span>{{ ucfirst($type) }}s</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="filter-card">
                            <h3 class="filter-title">Price Range</h3>
                            <div class="price-range">
                                <input type="number" name="min_price" value="{{ request('min_price') }}"
                                    placeholder="Min $">
                                <span>-</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}"
                                    placeholder="Max $">
                            </div>
                            <button type="submit" class="btn btn-primary btn-small w-100 mt-3">Apply Price</button>
                        </div>

                        <a href="{{ route('products.index') }}" class="btn btn-outline btn-small w-100">Clear All
                            Filters</a>
                    </form>
                </aside>

                <!-- Product Grid -->
                <main class="shop-main">
                    <div class="shop-header">
                        <div class="results-count">
                            Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of
                            {{ $products->total() }} results
                        </div>
                        <div class="sort-box">
                            <select name="sort" form="filterForm" onchange="this.form.submit()">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest Items
                                </option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular
                                </option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to
                                    High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High
                                    to Low</option>
                            </select>
                        </div>
                    </div>

                    @if($products->count() > 0)
                        <div class="products-grid">
                            @foreach($products as $product)
                                <div class="product-card">
                                    <div class="product-image">
                                        @if($product->is_featured)
                                            <span class="product-badge">Best Seller</span>
                                        @endif
                                        @if($product->cover_image_url)
                                            <img src="{{ $product->cover_image_url }}" alt="{{ $product->name }}">
                                        @else
                                            <i class="fas fa-box"></i>
                                        @endif
                                    </div>
                                    <div class="product-content">
                                        <div class="product-header">
                                            <h3>{{ $product->name }}</h3>
                                            <div class="product-price">
                                                @if($product->current_price <= 0)
                                                    FREE
                                                @else
                                                    ${{ number_format($product->current_price, 0) }}
                                                @endif
                                            </div>
                                        </div>
                                        <p class="product-description">
                                            {{ \Illuminate\Support\Str::limit($product->short_description, 80) }}
                                        </p>

                                        <!-- Features List -->
                                        @if(!empty($product->features))
                                            <div class="product-features-list" style="margin-bottom: 20px;">
                                                <ul style="list-style: none; padding: 0; margin: 0;">
                                                    @foreach(array_slice($product->features, 0, 4) as $feature)
                                                        <li
                                                            style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-secondary); line-height: 1.4;">
                                                            <i class="fas fa-check"
                                                                style="color: #ef4444; flex-shrink: 0; margin-top: 3px;"></i>
                                                            <span>{{ $feature }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @elseif(!empty($product->tech_stack))
                                            <div class="product-tech-stack"
                                                style="margin-bottom: 15px; display: flex; flex-wrap: wrap; gap: 5px;">
                                                @foreach(array_slice($product->tech_stack, 0, 3) as $tech)
                                                    <span
                                                        style="font-size: 0.75rem; background: var(--bg-tertiary); padding: 2px 8px; border-radius: 4px; color: var(--text-secondary);">
                                                        {{ $tech }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="product-footer">
                                            <div class="product-stats">
                                                <div class="product-stat">
                                                    <i
                                                        class="fas fa-{{ $product->product_type === 'service' ? 'users' : 'download' }}"></i>
                                                    <span>{{ $product->product_type === 'service' ? ($product->purchase_count ?? 0) : ($product->download_count ?? 0) }}</span>
                                                </div>
                                                <div class="product-stat"><i class="fas fa-star"></i>
                                                    <span>{{ $product->average_rating ? number_format($product->average_rating, 1) : '5.0' }}</span>
                                                </div>
                                            </div>

                                            <div style="display: flex; gap: 10px; width: 100%;">
                                                @if(\App\Models\SiteSetting::get('enable_shopping_cart', true))
                                                    <form action="{{ route('cart.add', $product) }}" method="POST"
                                                        class="ajax-add-to-cart" style="flex: 1;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary btn-small w-100">
                                                            <i
                                                                class="fas fa-{{ $product->current_price <= 0 ? 'download' : 'shopping-cart' }}"></i>
                                                            {{ $product->current_price <= 0 ? 'Free' : 'Add' }}
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline btn-small"
                                                        style="padding: 8px 12px;"><i class="fas fa-eye"></i></a>
                                                @else
                                                    <a href="{{ route('products.show', $product) }}"
                                                        class="btn btn-primary btn-small w-100">
                                                        <i class="fas fa-paper-plane"></i> View Details / Inquiry
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="shop-pagination">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="no-results">
                            <i class="fas fa-search"></i>
                            <h3>No products found</h3>
                            <p>Try adjusting your search or filters to find what you're looking for.</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">View All Products</a>
                        </div>
                    @endif
                </main>
            </div>
        </div>
    </section>

    @push('styles')
        <style>
            .shop-layout {
                display: grid;
                grid-template-columns: 280px 1fr;
                gap: 40px;
            }

            .shop-sidebar {
                display: flex;
                flex-direction: column;
                gap: 25px;
            }

            .filter-card {
                background: var(--card-bg);
                border: 1px solid var(--border-color);
                border-radius: 16px;
                padding: 20px;
                margin-bottom: 25px;
            }

            .filter-title {
                font-size: 1.1rem;
                font-weight: 700;
                margin-bottom: 15px;
                color: var(--text-primary);
            }

            .search-box {
                display: flex;
                gap: 8px;
            }

            .search-box input {
                flex: 1;
                background: var(--bg-primary);
                border: 1px solid var(--border-color);
                padding: 8px 12px;
                border-radius: 8px;
                color: var(--text-primary);
                font-size: 0.9rem;
            }

            .search-box button {
                background: var(--primary-color);
                color: white;
                border: none;
                width: 38px;
                height: 38px;
                border-radius: 8px;
                cursor: pointer;
            }

            .filter-options {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .filter-option {
                display: flex;
                align-items: center;
                gap: 10px;
                cursor: pointer;
                color: var(--text-secondary);
                font-size: 0.95rem;
                transition: color 0.2s;
            }

            .filter-option:hover {
                color: var(--primary-color);
            }

            .filter-option input {
                accent-color: var(--primary-color);
                width: 18px;
                height: 18px;
            }

            .price-range {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .price-range input {
                width: 100%;
                background: var(--bg-primary);
                border: 1px solid var(--border-color);
                padding: 8px;
                border-radius: 8px;
                color: var(--text-primary);
                font-size: 0.9rem;
            }

            .shop-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 30px;
                padding-bottom: 20px;
                border-bottom: 1px solid var(--border-color);
            }

            .results-count {
                color: var(--text-secondary);
                font-size: 0.95rem;
            }

            .sort-box select {
                background: var(--card-bg);
                border: 1px solid var(--border-color);
                padding: 8px 15px;
                border-radius: 8px;
                color: var(--text-primary);
                font-size: 0.9rem;
                cursor: pointer;
            }

            .no-results {
                text-align: center;
                padding: 80px 20px;
                background: var(--card-bg);
                border-radius: 24px;
                border: 1px dashed var(--border-color);
            }

            .no-results i {
                font-size: 4rem;
                color: var(--text-tertiary);
                margin-bottom: 20px;
            }

            .shop-pagination {
                margin-top: 50px;
            }

            .shop-pagination .pagination {
                justify-content: center;
                gap: 10px;
            }

            @media (max-width: 992px) {
                .shop-layout {
                    grid-template-columns: 1fr;
                }

                .shop-sidebar {
                    display: none;
                    /* In real app, we'd make this a drawer */
                }
            }
        </style>
    @endpush
@endsection