@extends('layouts.app')

@section('title', 'Blog | CodeCraft Insights & Tutorials')

@section('content')
    <!-- Blog Hero Section -->
    <section class="blog-hero">
        <div class="container">
            <div class="blog-hero-content">
                <h1>Insights, Tutorials & Updates</h1>
                <p>Exploring the world of web development, SaaS, and cutting-edge technology.</p>

                <div class="blog-search-wrapper">
                    <form action="{{ route('blog.index') }}" method="GET" class="blog-search-form">
                        <div class="search-input-group">
                            <i class="fas fa-search"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search articles...">
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="blog-main-layout">
                <main class="blog-posts-grid">
                    @php
                        $activeCategory = null;
                        if (request('category')) {
                            $activeCategory = $categories->where('slug', request('category'))->first();
                        }
                    @endphp

                    @if($activeCategory)
                        <div class="category-header">
                            <div class="category-info">
                                <span class="badge bg-primary">Category</span>
                                <h2>{{ $activeCategory->name }}</h2>
                                @if($activeCategory->description)
                                    <p>{{ $activeCategory->description }}</p>
                                @endif
                            </div>
                            <a href="{{ route('blog.index') }}" class="btn btn-outline btn-small"><i class="fas fa-times"></i>
                                Clear Filter</a>
                        </div>
                    @endif

                    @if(request('search'))
                        <div class="search-results-header">
                            <h2>Search results for: "{{ request('search') }}"</h2>
                            <p>Found {{ $posts->total() }} articles</p>
                            <a href="{{ route('blog.index', ['category' => request('category')]) }}" class="btn btn-link"><i
                                    class="fas fa-times"></i> Clear search</a>
                        </div>
                    @endif

                    <div class="blog-grid">
                        @forelse($posts as $post)
                            <article class="blog-card">
                                @if($post->cover_image_url)
                                    <a href="{{ route('blog.show', $post) }}" class="blog-image">
                                        <img src="{{ $post->cover_image_url }}" alt="{{ $post->title }}">
                                        @if($post->is_featured)
                                            <span class="blog-badge">Featured</span>
                                        @endif
                                    </a>
                                @endif
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        @if($post->category)
                                            <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}"
                                                class="blog-category">
                                                {{ $post->category->name }}
                                            </a>
                                        @endif
                                        <span class="blog-date">{{ $post->published_at->format('M d, Y') }}</span>
                                    </div>
                                    <h3 class="blog-title">
                                        <a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a>
                                    </h3>
                                    @if($post->excerpt)
                                        <p class="blog-excerpt">{{ \Illuminate\Support\Str::limit($post->excerpt, 120) }}</p>
                                    @endif
                                    <div class="blog-footer">
                                        <div class="blog-author">
                                            <i class="fas fa-user-circle"></i> {{ $post->author->name ?? 'Admin' }}
                                        </div>
                                        <div class="blog-stats">
                                            <span><i class="fas fa-eye"></i> {{ $post->view_count ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="no-posts">
                                <img src="https://via.placeholder.com/300?text=No+Posts+Found" alt="No posts">
                                <h3>No articles found</h3>
                                <p>We couldn't find any articles matching your criteria.</p>
                                <a href="{{ route('blog.index') }}" class="btn btn-primary">Browse All Articles</a>
                            </div>
                        @endforelse
                    </div>

                    <div class="blog-pagination">
                        {{ $posts->links() }}
                    </div>
                </main>

                <aside class="blog-sidebar">
                    <!-- Categories -->
                    <div class="sidebar-widget">
                        <h4 class="widget-title">Categories</h4>
                        <ul class="category-list">
                            <li>
                                <a href="{{ route('blog.index') }}" class="{{ !request('category') ? 'active' : '' }}">
                                    All Categories <span>{{ \App\Models\BlogPost::published()->count() }}</span>
                                </a>
                            </li>
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('blog.index', ['category' => $category->slug]) }}"
                                        class="{{ request('category') === $category->slug ? 'active' : '' }}">
                                        {{ $category->name }} <span>{{ $category->posts_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Recent Posts -->
                    <div class="sidebar-widget">
                        <h4 class="widget-title">Recent Articles</h4>
                        <div class="recent-posts-list">
                            @foreach($recentPosts as $recentPost)
                                <a href="{{ route('blog.show', $recentPost) }}" class="recent-post-item">
                                    <div class="recent-post-thumb">
                                        @if($recentPost->cover_image_url)
                                            <img src="{{ $recentPost->cover_image_url }}" alt="{{ $recentPost->title }}">
                                        @else
                                            <i class="fas fa-image"></i>
                                        @endif
                                    </div>
                                    <div class="recent-post-info">
                                        <h5>{{ \Illuminate\Support\Str::limit($recentPost->title, 50) }}</h5>
                                        <span>{{ $recentPost->published_at->format('M d, Y') }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .blog-hero {
            padding: 80px 0;
            background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-tertiary) 100%);
            text-align: center;
        }

        .blog-hero h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 15px;
            color: var(--text-primary);
        }

        .blog-hero p {
            font-size: 1.25rem;
            color: var(--text-secondary);
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .blog-search-wrapper {
            max-width: 500px;
            margin: 0 auto;
        }

        .search-input-group {
            display: flex;
            align-items: center;
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 50px;
            padding: 5px 5px 5px 20px;
            box-shadow: var(--card-shadow);
        }

        .search-input-group i {
            color: var(--text-tertiary);
            margin-right: 10px;
        }

        .search-input-group input {
            border: none;
            background: none;
            flex: 1;
            padding: 10px 10px 10px 0;
            font-size: 1rem;
            color: var(--text-primary);
            outline: none;
        }

        .blog-main-layout {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 40px;
        }

        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        /* Blog Card Overrides/Enhancements */
        .blog-card {
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-color: var(--primary-color);
        }

        .blog-image {
            position: relative;
            height: 180px;
            overflow: hidden;
            display: block;
        }

        .blog-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .blog-card:hover .blog-image img {
            transform: scale(1.05);
        }

        .blog-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--accent-color);
            color: white;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .blog-content {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .blog-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 12px;
            font-size: 0.8rem;
            align-items: center;
        }

        .blog-category {
            background: var(--primary-color);
            color: white;
            padding: 2px 10px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
        }

        .blog-date {
            color: var(--text-secondary);
        }

        .blog-title {
            font-size: 1.15rem;
            font-weight: 700;
            margin: 0 0 10px 0;
            line-height: 1.4;
        }

        .blog-title a {
            color: var(--text-primary);
            text-decoration: none;
            transition: color 0.2s;
        }

        .blog-title a:hover {
            color: var(--primary-color);
        }

        .blog-excerpt {
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 15px;
            flex: 1;
        }

        .blog-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
            font-size: 0.8rem;
            color: var(--text-tertiary);
        }

        .blog-author {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .blog-stats {
            display: flex;
            gap: 10px;
        }

        /* Sidebar Widgets */
        .sidebar-widget {
            background-color: var(--bg-secondary);
            border-radius: 16px;
            padding: 25px;
            border: 1px solid var(--border-color);
            margin-bottom: 30px;
        }

        .widget-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-color);
            display: inline-block;
        }

        .category-list {
            list-style: none;
        }

        .category-list li {
            margin-bottom: 10px;
        }

        .category-list a {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--text-secondary);
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .category-list a:hover,
        .category-list a.active {
            background-color: var(--bg-tertiary);
            color: var(--primary-color);
            font-weight: 600;
        }

        .category-list span {
            background-color: var(--border-color);
            color: var(--text-tertiary);
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 10px;
        }

        .recent-posts-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .recent-post-item {
            display: flex;
            gap: 12px;
            text-decoration: none;
            color: inherit;
            transition: all 0.2s;
        }

        .recent-post-item:hover h5 {
            color: var(--primary-color);
        }

        .recent-post-thumb {
            width: 70px;
            height: 70px;
            border-radius: 8px;
            overflow: hidden;
            background-color: var(--bg-tertiary);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-tertiary);
        }

        .recent-post-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .recent-post-info h5 {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 5px;
            line-height: 1.3;
            color: var(--text-primary);
        }

        .recent-post-info span {
            font-size: 0.75rem;
            color: var(--text-tertiary);
        }

        .category-header {
            background-color: var(--bg-secondary);
            padding: 30px;
            border-radius: 16px;
            margin-bottom: 30px;
            border: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .category-info h2 {
            margin: 10px 0;
            font-size: 2rem;
        }

        .category-info p {
            color: var(--text-secondary);
        }

        .search-results-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .no-posts {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            background-color: var(--bg-secondary);
            border-radius: 16px;
            border: 1px dashed var(--border-color);
        }

        .no-posts img {
            max-width: 200px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .no-posts h3 {
            margin-bottom: 10px;
        }

        .no-posts p {
            color: var(--text-secondary);
            margin-bottom: 20px;
        }

        .blog-pagination {
            margin-top: 40px;
        }

        @media (max-width: 900px) {
            .blog-main-layout {
                grid-template-columns: 1fr;
            }

            .blog-sidebar {
                order: 2;
            }

            .blog-posts-grid {
                order: 1;
            }
        }
    </style>
@endpush