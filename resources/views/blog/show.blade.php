@extends('layouts.app')

@section('title', $post->meta_title ?? $post->title . ' | CodeCraft Blog')
@section('meta_description', $post->meta_description ?? $post->excerpt)
@section('meta_keywords', $post->meta_keywords)

@section('content')
    <article class="post-detail">
        <!-- Post Header -->
        <header class="post-header"
            style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ $post->cover_image_url ?? '' }}');">
            <div class="container">
                <div class="post-header-content">
                    @if($post->category)
                        <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}" class="post-category-badge">
                            {{ $post->category->name }}
                        </a>
                    @endif
                    <h1 class="post-title">{{ $post->title }}</h1>
                    <div class="post-meta-top">
                        <div class="post-author-info">
                            <i class="fas fa-user-circle"></i>
                            <span>By <strong>{{ $post->author->name ?? 'Admin' }}</strong></span>
                        </div>
                        <div class="post-date-info">
                            <i class="far fa-calendar-alt"></i>
                            <span>{{ $post->published_at->format('M d, Y') }}</span>
                        </div>
                        <div class="post-read-time">
                            <i class="far fa-clock"></i>
                            <span>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container">
            <div class="post-main-layout">
                <div class="post-body">
                    <!-- Post Content -->
                    <div class="post-content-container">
                        @if($post->excerpt)
                            <div class="post-excerpt-lead">
                                {{ $post->excerpt }}
                            </div>
                        @endif

                        <div class="blog-content-body">
                            {!! $post->content !!}
                        </div>

                        <!-- Post Tag/Footer area -->
                        <div class="post-tags-social">
                            <div class="post-share">
                                <span>Share this:</span>
                                <div class="share-buttons">
                                    <a href="#" class="share-btn twitter" title="Share on Twitter"><i
                                            class="fab fa-twitter"></i></a>
                                    <a href="#" class="share-btn facebook" title="Share on Facebook"><i
                                            class="fab fa-facebook-f"></i></a>
                                    <a href="#" class="share-btn linkedin" title="Share on LinkedIn"><i
                                            class="fab fa-linkedin-in"></i></a>
                                    <a href="#" class="share-btn whatsapp" title="Share on WhatsApp"><i
                                            class="fab fa-whatsapp"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Posts -->
                    @if($relatedPosts->count() > 0)
                        <section class="related-posts">
                            <h3 class="section-title-small">Related Articles</h3>
                            <div class="related-grid">
                                @foreach($relatedPosts as $related)
                                    <a href="{{ route('blog.show', $related) }}" class="related-card">
                                        <div class="related-thumb">
                                            @if($related->cover_image_url)
                                                <img src="{{ $related->cover_image_url }}" alt="{{ $related->title }}">
                                            @endif
                                        </div>
                                        <div class="related-info">
                                            <h4>{{ \Illuminate\Support\Str::limit($related->title, 60) }}</h4>
                                            <span>{{ $related->published_at->format('M d, Y') }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>

                <!-- Sidebar -->
                <aside class="post-sidebar">
                    <div class="sidebar-widget">
                        <h4 class="widget-title">Search Blog</h4>
                        <form action="{{ route('blog.index') }}" method="GET" class="sidebar-search">
                            <input type="text" name="search" placeholder="Search...">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>

                    <div class="sidebar-widget">
                        <h4 class="widget-title">Details</h4>
                        <ul class="post-details-list">
                            <li><i class="fas fa-eye"></i> Views: <span>{{ $post->view_count }}</span></li>
                            <li><i class="fas fa-folder"></i> Category:
                                <span>{{ $post->category->name ?? 'Uncategorized' }}</span></li>
                            @if($post->author)
                                <li><i class="fas fa-user"></i> Author: <span>{{ $post->author->name }}</span></li>
                            @endif
                        </ul>
                    </div>

                    <div class="sidebar-widget">
                        <h4 class="widget-title">Categories</h4>
                        <ul class="category-list">
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('blog.index', ['category' => $category->slug]) }}">
                                        {{ $category->name }} <span>{{ $category->posts_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="sidebar-widget">
                        <h4 class="widget-title">Recent Articles</h4>
                        <div class="recent-posts-list">
                            @foreach($recentPosts as $recent)
                                <a href="{{ route('blog.show', $recent) }}" class="recent-post-item">
                                    <div class="recent-post-thumb">
                                        @if($recent->cover_image_url)
                                            <img src="{{ $recent->cover_image_url }}" alt="{{ $recent->title }}">
                                        @else
                                            <i class="fas fa-image"></i>
                                        @endif
                                    </div>
                                    <div class="recent-post-info">
                                        <h5>{{ \Illuminate\Support\Str::limit($recent->title, 50) }}</h5>
                                        <span>{{ $recent->published_at->format('M d, Y') }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </article>
@endsection

@push('styles')
    <style>
        .post-header {
            padding: 120px 0 80px;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            margin-bottom: 50px;
            text-align: center;
        }

        .post-header-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .post-category-badge {
            background: var(--primary-color);
            color: white;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .post-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 30px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .post-meta-top {
            display: flex;
            justify-content: center;
            gap: 30px;
            font-size: 0.95rem;
            opacity: 0.9;
            flex-wrap: wrap;
        }

        .post-meta-top>div {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .post-main-layout {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 60px;
        }

        .post-body {
            background: var(--bg-primary);
            border-radius: 20px;
        }

        .post-excerpt-lead {
            font-size: 1.25rem;
            color: var(--text-secondary);
            line-height: 1.6;
            font-style: italic;
            margin-bottom: 40px;
            padding-left: 20px;
            border-left: 4px solid var(--primary-color);
        }

        /* Content Styling - CKEditor Compatible */
        .blog-content-body {
            font-size: 1.125rem;
            line-height: 1.8;
            color: var(--text-primary);
        }

        .blog-content-body h2,
        .blog-content-body h3,
        .blog-content-body h4 {
            margin: 40px 0 20px;
            font-weight: 800;
        }

        .blog-content-body h2 {
            font-size: 2rem;
        }

        .blog-content-body h3 {
            font-size: 1.5rem;
        }

        .blog-content-body p {
            margin-bottom: 25px;
        }

        .blog-content-body img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            margin: 30px 0;
            box-shadow: var(--card-shadow);
        }

        .blog-content-body blockquote {
            background: var(--bg-secondary);
            border-left: 5px solid var(--accent-color);
            padding: 30px;
            margin: 40px 0;
            border-radius: 0 16px 16px 0;
            font-style: italic;
            font-size: 1.2rem;
            color: var(--text-secondary);
        }

        .blog-content-body ul,
        .blog-content-body ol {
            margin-bottom: 30px;
            padding-left: 25px;
        }

        .blog-content-body li {
            margin-bottom: 10px;
        }

        .blog-content-body pre {
            background: #1e1e1e;
            color: #d4d4d4;
            padding: 20px;
            border-radius: 12px;
            overflow-x: auto;
            margin: 30px 0;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.95rem;
        }

        .post-tags-social {
            margin-top: 60px;
            padding-top: 30px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .post-share {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .share-buttons {
            display: flex;
            gap: 10px;
        }

        .share-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: transform 0.2s;
        }

        .share-btn:hover {
            transform: translateY(-3px);
            color: white;
        }

        .share-btn.twitter {
            background: #1da1f2;
        }

        .share-btn.facebook {
            background: #1877f2;
        }

        .share-btn.linkedin {
            background: #0077b5;
        }

        .share-btn.whatsapp {
            background: #25d366;
        }

        /* Sidebar Widgets */
        .post-sidebar .sidebar-widget {
            background-color: var(--bg-secondary);
            border-radius: 16px;
            padding: 25px;
            border: 1px solid var(--border-color);
            margin-bottom: 30px;
        }

        .widget-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-color);
            display: inline-block;
        }

        .sidebar-search {
            position: relative;
        }

        .sidebar-search input {
            width: 100%;
            padding: 12px 15px;
            border-radius: 30px;
            border: 1px solid var(--border-color);
            background: var(--bg-primary);
            color: var(--text-primary);
        }

        .sidebar-search button {
            position: absolute;
            right: 5px;
            top: 5px;
            bottom: 5px;
            width: 35px;
            border-radius: 50%;
            border: none;
            background: var(--primary-color);
            color: white;
            cursor: pointer;
        }

        .post-details-list {
            list-style: none;
        }

        .post-details-list li {
            display: flex;
            margin-bottom: 12px;
            gap: 10px;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .post-details-list i {
            color: var(--primary-color);
            width: 20px;
        }

        .post-details-list span {
            color: var(--text-primary);
            font-weight: 600;
        }

        .category-list {
            list-style: none;
        }

        .category-list a {
            display: flex;
            justify-content: space-between;
            color: var(--text-secondary);
            text-decoration: none;
            padding: 8px 0;
            transition: color 0.2s;
            border-bottom: 1px dashed var(--border-color);
        }

        .category-list a:hover {
            color: var(--primary-color);
        }

        .category-list span {
            font-size: 0.75rem;
            background: var(--bg-tertiary);
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
        }

        .recent-post-thumb {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
            background: var(--bg-tertiary);
        }

        .recent-post-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .recent-post-info h5 {
            font-size: 0.85rem;
            margin-bottom: 4px;
            line-height: 1.3;
        }

        .recent-post-info span {
            font-size: 0.75rem;
            color: var(--text-tertiary);
        }

        .related-posts {
            margin-top: 80px;
        }

        .section-title-small {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .related-card {
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s;
        }

        .related-card:hover {
            transform: translateY(-5px);
        }

        .related-thumb {
            height: 120px;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 12px;
            background: var(--bg-tertiary);
        }

        .related-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .related-info h4 {
            font-size: 0.95rem;
            margin-bottom: 5px;
            line-height: 1.4;
        }

        .related-info span {
            font-size: 0.8rem;
            color: var(--text-tertiary);
        }

        @media (max-width: 992px) {
            .post-main-layout {
                grid-template-columns: 1fr;
            }

            .post-title {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .post-header {
                padding: 100px 0 60px;
            }

            .post-meta-top {
                gap: 15px;
            }
        }
    </style>
@endpush