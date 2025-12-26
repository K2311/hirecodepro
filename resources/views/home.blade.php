@extends('layouts.app')

@section('title', 'HireCadePro | Premium Full-Stack Development & Verified Code Solutions')

@section('content')
    <!-- Hero Section -->
    @if(\App\Models\SiteSetting::get('show_hero_section', true))
    <section id="home" class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Premium Full-Stack Development & Verified Code Solutions</h1>
                    <p>HireCadePro delivers elite web architecture, scalable APIs, and high-performance SaaS products. We help ambitious startups and enterprises transform complex ideas into market-leading digital realities.</p>

                    <div class="hero-badges">
                        <span class="badge"><i class="fab fa-laravel"></i> Laravel</span>
                        <span class="badge"><i class="fab fa-wordpress"></i> WordPress</span>
                        <span class="badge"><i class="fab fa-react"></i> React/Next.js</span>
                        <span class="badge"><i class="fab fa-node-js"></i> Node.js</span>
                        <span class="badge"><i class="fas fa-database"></i> PostgreSQL/MongoDB</span>
                        <span class="badge"><i class="fas fa-cloud"></i> AWS & Docker</span>
                    </div>

                    <div class="hero-buttons">
                        <a href="#services" class="btn btn-primary btn-large">View Services</a>
                        <a href="#products" class="btn btn-outline btn-large">Browse Products</a>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="code-window">
                        <div class="window-header">
                            <div class="window-dot dot-red"></div>
                            <div class="window-dot dot-yellow"></div>
                            <div class="window-dot dot-green"></div>
                            <span style="margin-left: 10px; font-size: 14px;">HireCadeCore.php</span>
                        </div>
                        <div class="window-content">
                            <span class="code-comment">// HireCadePro Premium Product Engine</span><br>
                            <span class="code-keyword">class</span> <span class="code-function">HireCadeCore</span> {<br>
                            &nbsp;&nbsp;<span class="code-keyword">public function</span> <span class="code-function">launchProduct</span>($config) {<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;$engine = <span class="code-keyword">new</span> <span class="code-function">CoreEngine</span>($config);<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;$engine-><span class="code-function">optimizePerformance</span>();<br><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;<span class="code-keyword">return</span> $engine-><span class="code-function">deployToCloud</span>([<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'<span class="code-string">region</span>' => '<span class="code-string">Global</span>',<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'<span class="code-string">scaling</span>' => '<span class="code-string">Automatic</span>'<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;]);<br>
                            &nbsp;&nbsp;}<br>
                            }
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Services Section -->
    @if(\App\Models\SiteSetting::get('show_services_section', true))
    <section id="services" class="section">
        <div class="container">
            <h2 class="section-title">Development Services</h2>
            <p class="section-subtitle">Custom development solutions tailored to your needs. From MVP development to
                full-scale applications.</p>

            <div class="services-grid">
                @forelse($services as $service)
                    <div class="service-card {{ $service->is_featured ? 'featured' : '' }}">
                        <div class="service-icon">
                            <i class="{{ $service->icon_class }}"></i>
                        </div>
                        <h3>{{ $service->name }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($service->description, 150) }}</p>

                        @if($service->features && is_array($service->features))
                            <ul class="service-features">
                                @foreach(array_slice($service->features, 0, 5) as $feature)
                                    <li><i class="fas fa-check"></i> {{ $feature }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="service-footer">
                            @if($service->base_rate)
                                <div class="service-price">
                                    @if($service->pricing_model === 'hourly')
                                        ${{ number_format($service->base_rate, 0) }}/hour
                                    @elseif($service->pricing_model === 'fixed')
                                        From ${{ number_format($service->base_rate, 0) }}
                                    @else
                                        From ${{ number_format($service->base_rate, 0) }}
                                    @endif
                                </div>
                            @endif

                            <a href="{{ route('quote.index') }}" class="btn btn-primary">Get Quote</a>
                        </div>
                    </div>
                @empty
                    <!-- Fallback if no services in database -->
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h3>SaaS MVP Development</h3>
                        <p>Build a fully-functional Minimum Viable Product for your SaaS idea with all core features
                            implemented.</p>

                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> Full-stack development</li>
                            <li><i class="fas fa-check"></i> User authentication & authorization</li>
                            <li><i class="fas fa-check"></i> Payment integration (Stripe/PayPal)</li>
                            <li><i class="fas fa-check"></i> Admin dashboard</li>
                            <li><i class="fas fa-check"></i> 3 months of support</li>
                        </ul>

                        <div class="service-footer">
                            <div class="service-price">From $8,500</div>
                            <a href="{{ route('quote.index') }}" class="btn btn-primary">Get Quote</a>
                        </div>
                    </div>

                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <h3>Custom API Development</h3>
                        <p>Design and build secure, scalable RESTful or GraphQL APIs for your applications and integrations.</p>

                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> REST or GraphQL API design</li>
                            <li><i class="fas fa-check"></i> JWT authentication</li>
                            <li><i class="fas fa-check"></i> Rate limiting & security</li>
                            <li><i class="fas fa-check"></i> Comprehensive documentation</li>
                            <li><i class="fas fa-check"></i> API testing & deployment</li>
                        </ul>

                        <div class="service-footer">
                            <div class="service-price">From $4,200</div>
                            <a href="{{ route('quote.index') }}" class="btn btn-primary">Get Quote</a>
                        </div>
                    </div>

                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-robot"></i>
                        </div>
                        <h3>AI Integration</h3>
                        <p>Integrate OpenAI, GPT models, or custom machine learning models into your existing applications.</p>

                        <ul class="service-features">
                            <li><i class="fas fa-check"></i> OpenAI/GPT integration</li>
                            <li><i class="fas fa-check"></i> Custom ML model deployment</li>
                            <li><i class="fas fa-check"></i> Real-time processing</li>
                            <li><i class="fas fa-check"></i> Data pipeline setup</li>
                            <li><i class="fas fa-check"></i> Performance optimization</li>
                        </ul>

                        <div class="service-footer">
                            <div class="service-price">From $6,000</div>
                            <a href="{{ route('quote.index') }}" class="btn btn-primary">Get Quote</a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    <!-- Products Section -->
    @if(\App\Models\SiteSetting::get('show_products_section', true))
    <section id="products" class="section" style="background-color: var(--bg-secondary);">
        <div class="container">
            <h2 class="section-title">Premium Code Products</h2>
            <p class="section-subtitle">Production-ready code templates, APIs, and plugins to accelerate your development.
            </p>

            <div class="products-filter">
                <button class="filter-btn active" data-filter="all">All Products</button>
                <button class="filter-btn" data-filter="template">SaaS Templates</button>
                    <button class="filter-btn" data-filter="api">APIs</button>
                    <button class="filter-btn" data-filter="plugin">Plugins</button>
                </div>

                <div class="products-grid">
                    @foreach($products as $product)
                        <div class="product-card" data-category="{{ $product->product_type }}" style="display: none;">
                            <div class="product-image">
                                @if($product->is_featured)
                                    <span class="product-badge">Best Seller</span>
                                @endif
                                @if($product->cover_image_url)
                                    @php
                                        $url = $product->cover_image_url;
                                        $isYoutube = \Illuminate\Support\Str::contains($url, ['youtube.com', 'youtu.be']);
                                        $isVideoFile = preg_match('/\.(mp4|webm|ogg)(\?.*)?$/i', $url);
                                    @endphp
                                    @if($isYoutube)
                                        @php preg_match('/(youtube.com.*v=|youtu.be\/)([a-zA-Z0-9_-]{6,})/', $url, $m);
                                        $id = $m[2] ?? null; @endphp
                                        @if($id)
                                            <iframe src="https://www.youtube.com/embed/{{ $id }}" frameborder="0" allowfullscreen></iframe>
                                        @else
                                            <img src="{{ $url }}" alt="{{ $product->name }}">
                                        @endif
                                    @elseif($isVideoFile)
                                        <video src="{{ asset($url) }}" muted loop onmouseover="this.play()" onmouseout="this.pause()"></video>
                                    @else
                                        <img src="{{ asset($url) }}" alt="{{ $product->name }}">
                                    @endif
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
                                    {{ \Illuminate\Support\Str::limit($product->short_description, 120) }}</p>

                                <!-- Gallery Preview Thumbnails -->
                                @php
                                    $galleryRaw = is_string($product->preview_images) ? json_decode($product->preview_images, true) : $product->preview_images;
                                    $galleryProcessed = [];
                                    if (is_array($galleryRaw)) {
                                        foreach ($galleryRaw as $item) {
                                            if (is_string($item)) {
                                                $galleryProcessed[] = ['url' => $item];
                                            } elseif (is_array($item) && isset($item['url'])) {
                                                $galleryProcessed[] = $item;
                                            }
                                        }
                                    }
                                    $gallery = array_slice($galleryProcessed, 0, 3);
                                @endphp
                                @if(!empty($gallery))
                                    <div class="product-gallery-preview">
                                        @foreach($gallery as $mediaItem)
                                            @php
                                                $mediaUrl = $mediaItem['url'];
                                                $isYoutubeMedia = \Illuminate\Support\Str::contains($mediaUrl, ['youtube.com', 'youtu.be']);
                                                $isVideoMedia = preg_match('/\.(mp4|webm|ogg)(\?.*)?$/i', $mediaUrl);
                                            @endphp
                                            <div class="gallery-item" title="View gallery">
                                                @if($isYoutubeMedia)
                                                    @php preg_match('/(youtube.com.*v=|youtu.be\/)([a-zA-Z0-9_-]{6,})/', $mediaUrl, $m);
                                                    $youtubeId = $m[2] ?? null; @endphp
                                                    @if($youtubeId)
                                                        <img src="https://img.youtube.com/vi/{{ $youtubeId }}/default.jpg" alt="Video">
                                                        <div class="gallery-item-video-icon"><i class="fas fa-play"></i></div>
                                                    @endif
                                                @elseif($isVideoMedia)
                                                    <video>
                                                        <source src="{{ $mediaUrl }}">
                                                    </video>
                                                    <div class="gallery-item-video-icon"><i class="fas fa-play"></i></div>
                                                @else
                                                    <img src="{{ asset($mediaUrl) }}" alt="Gallery">
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Features List -->
                                @if(!empty($product->features))
                                    <div class="product-features-list" style="margin-bottom: 20px;">
                                        <ul style="list-style: none; padding: 0; margin: 0;">
                                            @foreach(array_slice($product->features, 0, 4) as $feature)
                                                <li style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-secondary); line-height: 1.4;">
                                                    <i class="fas fa-check" style="color: #ef4444; flex-shrink: 0; margin-top: 3px;"></i>
                                                    <span>{{ $feature }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <div class="tech-stack">
                                        @if(is_array($product->tech_stack))
                                            @foreach($product->tech_stack as $tech)
                                                <span class="tech-badge">{{ $tech }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                @endif

                                <div class="product-footer">
                                    <div class="product-stats">
                                        <div class="product-stat">
                                            <i class="fas fa-download"></i>
                                            <span>{{ $product->download_count ?? 0 }}</span>
                                        </div>
                                        <div class="product-stat">
                                            <i class="fas fa-star"></i>
                                            <span>{{ $product->average_rating ? number_format($product->average_rating, 1) : '0.0' }}</span>
                                        </div>
                                    </div>
                                    <div class="product-actions" style="display: flex; gap: 8px;">
                                        @if(\App\Models\SiteSetting::get('enable_shopping_cart', true))
                                            <form class="ajax-add-to-cart" action="{{ route('cart.add', $product) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline btn-small" title="Add to Cart">
                                                    <i class="fas fa-cart-plus"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-primary btn-small view-product"
                                            data-product="{{ $product->id }}" style="{{ !\App\Models\SiteSetting::get('enable_shopping_cart', true) ? 'width: 100%;' : '' }}">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="text-align: center; margin-top: 50px;">
                    <a href="{{ route('products.index') }}" class="btn btn-outline btn-large">View All Products</a>
                </div>
            </div>
        </section>
        @endif

        <!-- Portfolio Section -->
        @if(\App\Models\SiteSetting::get('show_portfolio_section', true) && $portfolioProjects->count() > 0)
            <section id="portfolio" class="section">
                <div class="container">
                    <h2 class="section-title">Featured Work</h2>
                    <p class="section-subtitle">Recent projects showcasing our expertise in building scalable, modern applications.</p>

                    <div class="portfolio-grid">
                        @foreach($portfolioProjects as $project)
                            <div class="portfolio-card">
                                <div class="portfolio-image">
                                    @if($project->is_featured)
                                        <span class="portfolio-badge">Featured</span>
                                    @endif
                                    @if($project->cover_image_url)
                                        <img src="{{ asset($project->cover_image_url) }}" alt="{{ $project->title }}">
                                    @else
                                        <div class="portfolio-placeholder">
                                            <i class="fas fa-briefcase"></i>
                                        </div>
                                    @endif
                                    <div class="portfolio-overlay">
                                        <h3>{{ $project->title }}</h3>
                                        @if($project->client_name)
                                            <p class="portfolio-client"><i class="fas fa-building"></i> {{ $project->client_name }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="portfolio-content">
                                    <div class="portfolio-type">{{ ucfirst($project->project_type ?? 'Web App') }}</div>
                                    @if($project->challenge)
                                        <p class="portfolio-description">{{ \Illuminate\Support\Str::limit($project->challenge, 120) }}</p>
                                    @endif

                                    @if($project->tech_stack && is_array($project->tech_stack))
                                        <div class="tech-stack">
                                            @foreach(array_slice($project->tech_stack, 0, 4) as $tech)
                                                <span class="tech-badge">{{ $tech }}</span>
                                            @endforeach
                                            @if(count($project->tech_stack) > 4)
                                                <span class="tech-badge">+{{ count($project->tech_stack) - 4 }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- About Section -->
        @if(\App\Models\SiteSetting::get('show_about_section', true))
        <section id="about" class="section">
            <div class="container">
                <div class="about-content">
                    <div class="about-text">
                        <h2>Building Digital Products Since 2015</h2>
                        <p>I'm a full-stack developer specializing in building scalable web applications and SaaS products. With
                            over 8 years of experience, I've helped dozens of startups and businesses turn their ideas into
                            successful products.</p>

                        <p>My expertise spans across modern frameworks like Laravel, WordPress, and React/Next.js, as well as backend technologies
                            (Node.js, PHP, Python) and cloud infrastructure (AWS, Docker).</p>

                        <div class="about-stats">
                            <div class="about-stat">
                                <div class="about-stat-number">50+</div>
                                <div class="about-stat-label">Projects Completed</div>
                            </div>
                            <div class="about-stat">
                                <div class="about-stat-number">30+</div>
                                <div class="about-stat-label">Happy Clients</div>
                            </div>
                            <div class="about-stat">
                                <div class="about-stat-number">8+</div>
                                <div class="about-stat-label">Years Experience</div>
                            </div>
                        </div>
                    </div>

                    <div class="about-visual">
                        <div class="experience-card">
                            <div class="experience-header">
                                <div
                                    style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-color), var(--accent-color)); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: 700;">
                                    VP
                                </div>
                                <div class="experience-info">
                                    <h4>Viral Padvi</h4>
                                    <p>Full-Stack Developer & SaaS Architect</p>
                                </div>
                            </div>

                            <p style="color: var(--text-secondary); margin-bottom: 20px;">
                                "I believe in writing clean, maintainable code and building products that users love. Every
                                project is an opportunity to learn something new and push the boundaries of what's possible."
                            </p>

                            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                <span class="badge">Laravel</span>
                                <span class="badge">WordPress</span>
                                <span class="badge">React</span>
                                <span class="badge">Node.js</span>
                                <span class="badge">PostgreSQL</span>
                                <span class="badge">AWS</span>
                                <span class="badge">Docker</span>
                                <span class="badge">TypeScript</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif

        <!-- Testimonials Section -->
        @if(\App\Models\SiteSetting::get('show_testimonials_section', true) && $testimonials->count() > 0)
            <section id="testimonials" class="section" style="background-color: var(--bg-secondary);">
                <div class="container">
                    <h2 class="section-title">Client Testimonials</h2>
                    <p class="section-subtitle">What our clients say about working with us.</p>

                    <div class="testimonials-grid">
                        @foreach($testimonials->take(3) as $testimonial)
                            @if($testimonial->is_published)
                                <div class="testimonial-card">
                                    <div class="testimonial-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= ($testimonial->rating ?? 5))
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="testimonial-content">"{{ $testimonial->content }}"</p>
                                    <div class="testimonial-author">
                                        @if($testimonial->client_avatar_url)
                                            <img src="{{ $testimonial->client_avatar_url }}" alt="{{ $testimonial->client_name }}" class="testimonial-avatar">
                                        @else
                                            <div class="testimonial-avatar-placeholder">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        @endif
                                        <div class="testimonial-info">
                                            <div class="testimonial-name">{{ $testimonial->client_name }}</div>
                                            @if($testimonial->client_position && $testimonial->client_company)
                                                <div class="testimonial-position">{{ $testimonial->client_position }} at {{ $testimonial->client_company }}</div>
                                            @elseif($testimonial->client_company)
                                                <div class="testimonial-position">{{ $testimonial->client_company }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Blog Preview Section -->
        @if(\App\Models\SiteSetting::get('show_blog_section', true) && $blogPosts->count() > 0)
            <section id="blog" class="section">
                <div class="container">
                    <h2 class="section-title">Latest Insights</h2>
                    <p class="section-subtitle">Articles, tutorials, and thoughts on web development and technology.</p>

                    <div class="blog-grid">
                        @foreach($blogPosts as $post)
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
                                            <span class="blog-category">{{ $post->category->name }}</span>
                                        @endif
                                        <span class="blog-date">{{ $post->published_at->format('M d, Y') }}</span>
                                    </div>
                                    <h3 class="blog-title">
                                        <a href="{{ route('blog.show', $post) }}" style="color: inherit; text-decoration: none;">
                                            {{ $post->title }}
                                        </a>
                                    </h3>
                                    @if($post->excerpt)
                                        <p class="blog-excerpt">{{ \Illuminate\Support\Str::limit($post->excerpt, 120) }}</p>
                                    @endif
                                    <div class="blog-footer">
                                        @if($post->author)
                                            <div class="blog-author">
                                                <i class="fas fa-user-circle"></i> {{ $post->author->name }}
                                            </div>
                                        @endif
                                        <div class="blog-stats">
                                            <span><i class="fas fa-eye"></i> {{ $post->view_count ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div style="text-align: center; margin-top: 50px;">
                        <a href="{{ route('blog.index') }}" class="btn btn-outline btn-large">View All Insights</a>
                    </div>
                </div>
            </section>
        @endif

        <!-- Contact CTA -->
        @if(\App\Models\SiteSetting::get('show_contact_section', true))
        <section id="contact" class="contact-cta">
            <div class="container">
                <div class="contact-content">
                    <div class="contact-text">
                        <h2>Ready to Start Your Project?</h2>
                        <p>Let's discuss how I can help bring your ideas to life. Get in touch for a free consultation.</p>
                    </div>

                    <div class="contact-form-wrapper">
                        <div id="home-form-messages"></div>

                        <form id="homeContactForm" class="contact-form-inline">
                            @csrf
                            <input type="hidden" name="source_page" value="{{ url()->current() }}">

                            <div class="form-row">
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Your Name *" required>
                                    <div class="error-message" data-field="name"></div>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" placeholder="Email Address *" required>
                                    <div class="error-message" data-field="email"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <select name="inquiry_type" required>
                                    <option value="">Select inquiry type *</option>
                                    <option value="general">General Inquiry</option>
                                    <option value="service">Service Request</option>
                                    <option value="support">Technical Support</option>
                                    <option value="partnership">Partnership</option>
                                </select>
                                <div class="error-message" data-field="inquiry_type"></div>
                            </div>

                            <div class="form-group">
                                <textarea name="message" rows="4" placeholder="Tell me about your project *"
                                    required></textarea>
                                <div class="error-message" data-field="message"></div>
                            </div>

                            <button type="submit" class="btn btn-white btn-large" id="homeSubmitBtn">
                                <span id="homeBtnText">Send Message</span>
                                <span id="homeBtnLoader" style="display: none;">
                                    <i class="fas fa-spinner fa-spin"></i> Sending...
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        @endif

        <!-- Product Modal -->
        <div class="modal" id="productModal">
            <div class="modal-content">
                <button class="modal-close" id="modalClose">
                    <i class="fas fa-times"></i>
                </button>

                <div id="modalContent">
                    <!-- Content will be loaded here by JavaScript -->
                </div>
            </div>
        </div>
@endsection

@push('styles')
    <style>
        /* Contact CTA Form Styles */
        .contact-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .contact-text h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: white;
        }

        .contact-text p {
            font-size: 1.125rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .contact-form-wrapper {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 2rem;
        }

        .contact-form-inline {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .contact-form-inline .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .contact-form-inline .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .contact-form-inline input,
        .contact-form-inline select,
        .contact-form-inline textarea {
            padding: 0.75rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1rem;
            backdrop-filter: blur(10px);
        }

        .contact-form-inline input::placeholder,
        .contact-form-inline select option,
        .contact-form-inline textarea::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .contact-form-inline input:focus,
        .contact-form-inline select:focus,
        .contact-form-inline textarea:focus {
            outline: none;
            border-color: white;
            background: rgba(255, 255, 255, 0.2);
        }

        .contact-form-inline select {
            color: white;
        }

        .contact-form-inline textarea {
            resize: vertical;
            min-height: 100px;
        }

        .contact-form-inline .error-message {
            color: #fca5a5;
            font-size: 0.75rem;
            min-height: 1rem;
        }

        #home-form-messages {
            margin-bottom: 1rem;
        }

        #home-form-messages .alert {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        #home-form-messages .alert-success {
            background-color: rgba(34, 197, 94, 0.2);
            color: #bbf7d0;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        #home-form-messages .alert-error {
            background-color: rgba(239, 68, 68, 0.2);
            color: #fecaca;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .contact-content {
                grid-template-columns: 1fr;
                gap: 40px;
                text-align: center;
            }

            .contact-text h2 {
                font-size: 2rem;
            }

            .contact-form-wrapper {
                padding: 1.5rem;
            }

            .contact-form-inline .form-row {
                grid-template-columns: 1fr;
            }
        }

        /* Portfolio Section Styles */
        .portfolio-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .portfolio-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .portfolio-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            border-color: var(--primary-color);
        }

        .portfolio-image {
            position: relative;
            height: 250px;
            overflow: hidden;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        }

        .portfolio-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .portfolio-card:hover .portfolio-image img {
            transform: scale(1.1);
        }

        .portfolio-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            font-size: 4rem;
            color: white;
            opacity: 0.3;
        }

        .portfolio-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--accent-color);
            color: white;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 2;
        }

        .portfolio-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            padding: 20px;
            color: white;
        }

        .portfolio-overlay h3 {
            margin: 0 0 5px 0;
            font-size: 1.25rem;
        }

        .portfolio-client {
            margin: 0;
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .portfolio-content {
            padding: 20px;
        }

        .portfolio-type {
            display: inline-block;
            background: var(--primary-color);
            color: white;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .portfolio-description {
            color: var(--text-secondary);
            margin: 10px 0;
            line-height: 1.6;
        }

        /* Testimonials Section Styles */
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .testimonial-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 30px;
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .testimonial-rating {
            color: #fbbf24;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .testimonial-content {
            color: var(--text-primary);
            font-size: 1rem;
            line-height: 1.7;
            margin: 15px 0 20px 0;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .testimonial-avatar,
        .testimonial-avatar-placeholder {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .testimonial-avatar-placeholder {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .testimonial-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 3px;
        }

        .testimonial-position {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        /* Blog Section Styles */
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .blog-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-color: var(--primary-color);
        }

        .blog-image {
            position: relative;
            height: 200px;
            overflow: hidden;
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
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
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
            margin-bottom: 15px;
            font-size: 0.875rem;
        }

        .blog-category {
            background: var(--primary-color);
            color: white;
            padding: 4px 12px;
            border-radius: 50px;
            font-weight: 600;
        }

        .blog-date {
            color: var(--text-secondary);
        }

        .blog-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 10px 0;
            color: var(--text-primary);
            line-height: 1.4;
        }

        .blog-excerpt {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.6;
            margin: 10px 0;
            flex: 1;
        }

        .blog-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .blog-author {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .blog-stats {
            display: flex;
            gap: 15px;
        }

        .blog-stats span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Featured service card highlight */
        .service-card.featured {
            border-color: var(--accent-color);
            background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.05), rgba(var(--accent-rgb), 0.05));
        }

        @media (max-width: 768px) {
            .portfolio-grid,
            .testimonials-grid,
            .blog-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const homeContactForm = document.getElementById('homeContactForm');
            const homeSubmitBtn = document.getElementById('homeSubmitBtn');
            const homeBtnText = document.getElementById('homeBtnText');
            const homeBtnLoader = document.getElementById('homeBtnLoader');
            const homeFormMessages = document.getElementById('home-form-messages');

            if (homeContactForm) {
                homeContactForm.addEventListener('submit', async function (e) {
                    e.preventDefault();

                    // Clear previous messages and errors
                    clearHomeMessages();
                    clearHomeErrors();

                    // Show loading state
                    setHomeLoading(true);

                    try {
                        const formData = new FormData(homeContactForm);
                        const response = await fetch('/contact', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            showHomeMessage('success', data.message);
                            homeContactForm.reset();
                        } else {
                            if (data.errors) {
                                showHomeErrors(data.errors);
                            } else {
                                showHomeMessage('error', data.message || 'An error occurred. Please try again.');
                            }
                        }
                    } catch (error) {
                        showHomeMessage('error', 'Network error. Please check your connection and try again.');
                    } finally {
                        setHomeLoading(false);
                    }
                });
            }

            function setHomeLoading(loading) {
                if (homeSubmitBtn) {
                    homeSubmitBtn.disabled = loading;
                    homeBtnText.style.display = loading ? 'none' : 'inline';
                    homeBtnLoader.style.display = loading ? 'inline' : 'none';
                }
            }

            function showHomeMessage(type, message) {
                if (homeFormMessages) {
                    const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
                    homeFormMessages.innerHTML = `<div class="alert ${alertClass}">${message}</div>`;
                    homeFormMessages.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            }

            function showHomeErrors(errors) {
                for (const [field, messages] of Object.entries(errors)) {
                    const errorElement = document.querySelector(`#homeContactForm .error-message[data-field="${field}"]`);
                    if (errorElement) {
                        errorElement.textContent = messages[0];
                    }
                }
            }

            function clearHomeMessages() {
                if (homeFormMessages) {
                    homeFormMessages.innerHTML = '';
                }
            }

            function clearHomeErrors() {
                document.querySelectorAll('#homeContactForm .error-message').forEach(el => {
                    el.textContent = '';
                });
            }

            // Product Filtering Logic
            const filterBtns = document.querySelectorAll('.filter-btn');
            const productCards = document.querySelectorAll('.product-card');

            function filterProducts(filter) {
                let shownCount = 0;
                productCards.forEach(card => {
                    const category = card.getAttribute('data-category');
                    if (shownCount < 6 && (filter === 'all' || category === filter)) {
                        card.style.display = 'block';
                        shownCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Update active button
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    // Filter products
                    const filter = this.getAttribute('data-filter');
                    filterProducts(filter);
                });
            });

            // Initialize with 'all' filter and limit 6
            filterProducts('all');

            // AJAX Add to Cart
            document.querySelectorAll('.ajax-add-to-cart').forEach(form => {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const btn = this.querySelector('button');
                    const originalContent = btn.innerHTML;

                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                    try {
                        const response = await fetch(this.action, {
                            method: 'POST',
                            body: new FormData(this),
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            // Update cart badge
                            let badge = document.querySelector('.cart-badge');
                            if (!badge) {
                                const cartLink = document.querySelector('.cart-link');
                                badge = document.createElement('span');
                                badge.className = 'cart-badge';
                                cartLink.appendChild(badge);
                            }
                            badge.textContent = data.cart_count;

                            // Feedback
                            btn.innerHTML = '<i class="fas fa-check"></i>';
                            setTimeout(() => {
                                btn.innerHTML = originalContent;
                                btn.disabled = false;
                            }, 2000);
                        }
                    } catch (error) {
                        btn.innerHTML = originalContent;
                        btn.disabled = false;
                        console.error('Error adding to cart:', error);
                    }
                });
            });
        });
    </script>
@endpush