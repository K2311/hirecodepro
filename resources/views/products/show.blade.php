@extends('layouts.app')

@section('title', $product->name . ' | HireCode')

@section('content')
    <style>
        .product-page-v3 {
            padding: 60px 0;
            background: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }

        .short-desc-v3 {
            font-size: 1.15rem;
            color: var(--text-secondary);
            margin-top: 10px;
            max-width: 800px;
            line-height: 1.6;
        }

        .rich-text-v3 {
            line-height: 1.8;
            color: var(--text-secondary);
        }

        .rich-text-v3 h1,
        .rich-text-v3 h2,
        .rich-text-v3 h3 {
            color: var(--text-primary);
            margin-top: 25px;
        }

        .rich-text-v3 ul {
            padding-left: 20px;
        }

        .rich-text-v3 li {
            margin-bottom: 8px;
        }

        /* Breadcrumbs */
        .breadcrumb-v3 {
            margin-bottom: 30px;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .breadcrumb-v3 a {
            color: var(--primary-color);
            text-decoration: none;
        }

        /* Header Section */
        .product-header-v3 {
            margin-bottom: 40px;
        }

        .product-header-v3 h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 10px;
        }

        .product-meta-v3 {
            display: flex;
            gap: 20px;
            align-items: center;
            color: var(--text-secondary);
        }

        .badge-v3 {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
            padding: 4px 12px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Main Layout */
        .product-layout-v3 {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 40px;
        }

        /* Gallery */
        .gallery-v3 {
            background: var(--bg-secondary);
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 40px;
            border: 1px solid var(--border-color);
        }

        .gallery-main {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }

        /* Tabs Section */
        .tabs-v3 {
            border-bottom: 1px solid var(--border-color);
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
        }

        .tab-btn-v3 {
            padding: 15px 0;
            border: none;
            background: none;
            font-weight: 700;
            color: var(--text-secondary);
            cursor: pointer;
            position: relative;
        }

        .tab-btn-v3.active {
            color: var(--primary-color);
        }

        .tab-btn-v3.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--primary-color);
        }

        /* Descriptions */
        .content-v3 {
            line-height: 1.8;
            color: var(--text-secondary);
        }

        .content-v3 h3 {
            color: var(--text-primary);
            margin-top: 50px;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .content-v3 ul {
            padding-left: 20px;
        }

        .content-v3 li {
            margin-bottom: 10px;
        }

        /* Features Grid */
        .features-grid-v3 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        .feature-item-v3 {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--bg-secondary);
            padding: 20px;
            border-radius: 16px;
            font-weight: 600;
            border: 1px solid var(--border-color);
            transition: transform 0.2s;
        }

        .feature-item-v3:hover {
            transform: translateY(-3px);
            border-color: var(--primary-color);
        }

        .feature-item-v3 i {
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        /* Sidebar / Pricing Card */
        .sidebar-v3 {
            position: sticky;
            top: 100px;
        }

        .pricing-card-v3 {
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 30px;
            background: var(--bg-secondary);
            box-shadow: var(--card-shadow);
        }

        .price-tag-v3 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 5px;
        }

        .price-original {
            text-decoration: line-through;
            color: var(--text-tertiary);
            font-size: 1.2rem;
            font-weight: 400;
        }

        .license-info {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-bottom: 25px;
        }

        .cta-button-v3 {
            display: block;
            width: 100%;
            padding: 18px;
            background: var(--primary-color);
            color: #fff;
            text-align: center;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            margin-bottom: 15px;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .cta-button-v3:hover {
            transform: translateY(-2px);
            background: var(--primary-dark);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);
        }

        .secondary-btn-v3 {
            display: block;
            width: 100%;
            padding: 15px;
            border: 2px solid var(--border-color);
            color: var(--text-primary);
            text-align: center;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
        }

        .secondary-btn-v3:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            background: rgba(99, 102, 241, 0.05);
        }

        /* Inquiry Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal-overlay.active {
            display: flex;
            opacity: 1;
        }

        .inquiry-modal {
            background: var(--bg-primary);
            width: 90%;
            max-width: 550px;
            border-radius: 24px;
            padding: 40px;
            position: relative;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transform: translateY(20px);
            transition: transform 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .modal-overlay.active .inquiry-modal {
            transform: translateY(0);
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--bg-tertiary);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-secondary);
            transition: all 0.2s;
        }

        .modal-close:hover {
            background: var(--danger-color);
            color: white;
            transform: rotate(90deg);
        }

        .modal-header {
            margin-bottom: 30px;
            text-align: center;
        }

        .modal-header h2 {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 10px;
            color: var(--text-primary);
        }

        .modal-header p {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .inquiry-form .form-group {
            margin-bottom: 20px;
        }

        .inquiry-form label {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 8px;
            color: var(--text-primary);
        }

        .inquiry-form .form-input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            background: var(--bg-secondary);
            color: var(--text-primary);
            font-size: 1rem;
            transition: all 0.2s;
        }

        .inquiry-form .form-input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .inquiry-form textarea.form-input {
            height: 120px;
            resize: none;
        }

        .modal-footer {
            margin-top: 30px;
        }

        .submit-btn {
            width: 100%;
            padding: 16px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .submit-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .tech-stack-v3 {
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid var(--border-color);
        }

        .tech-tag-v3 {
            display: inline-block;
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-right: 8px;
            margin-bottom: 8px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* Thumbnails */
        .thumbnails-v3 {
            display: flex;
            gap: 15px;
            margin-bottom: 40px;
            overflow-x: auto;
            padding-bottom: 10px;
        }

        .thumb-item {
            width: 100px;
            height: 75px;
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid transparent;
            cursor: pointer;
            flex-shrink: 0;
            transition: all 0.2s;
        }

        .thumb-item.active {
            border-color: var(--primary-color);
        }

        .thumb-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Software Showcase UI */
        .software-showcase-v3 {
            background: var(--bg-secondary);
            border-radius: 24px;
            padding: 40px;
            margin-bottom: 50px;
            border: 1px solid var(--border-color);
        }

        .showcase-tabs {
            display: flex;
            gap: 15px;
            overflow-x: auto;
            margin-bottom: 40px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .showcase-tab-btn {
            padding: 12px 25px;
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-secondary);
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.3s;
        }

        .showcase-tab-btn.active {
            background: var(--primary-color);
            color: #fff;
            border-color: var(--primary-color);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
        }

        .showcase-content-v3 {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 50px;
            align-items: center;
        }

        .showcase-text-v3 h2 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 25px;
            line-height: 1.3;
        }

        .showcase-features-v3 {
            list-style: none;
            padding: 0;
        }

        .showcase-features-v3 li {
            position: relative;
            padding-left: 35px;
            margin-bottom: 15px;
            color: var(--text-secondary);
            font-size: 1.05rem;
            line-height: 1.6;
        }

        .showcase-features-v3 li::before {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            left: 0;
            top: 3px;
            width: 24px;
            height: 24px;
            background: rgba(227, 91, 46, 0.1);
            color: #e35b2e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
        }

        .showcase-visual-v3 {
            background: #fff;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-color);
        }

        .showcase-visual-v3 img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .module-pane {
            display: none;
        }

        .module-pane.active {
            display: block;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @media (max-width: 991px) {
            .showcase-content-v3 {
                grid-template-columns: 1fr;
            }

            .software-showcase-v3 {
                padding: 25px;
            }
        }

        /* Tab Content Logic */
        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .specs-grid-v3 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-top: 30px;
        }

        .spec-section {
            background: var(--bg-tertiary);
            padding: 25px;
            border-radius: 16px;
            border: 1px solid var(--border-color);
        }

        .spec-section h3 {
            margin-top: 0 !important;
            margin-bottom: 20px !important;
            font-size: 1.2rem !important;
        }

        .tech-stack-v3 {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .tech-tag-v3 {
            display: inline-block;
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 500;
            max-width: 100%;
            word-break: break-all;
            white-space: normal;
        }

        @media (max-width: 768px) {
            .specs-grid-v3 {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="product-page-v3">
        <div class="container">
            <!-- Breadcrumbs -->
            <div class="breadcrumb-v3">
                <a href="/">Home</a> / <a href="/shop">Shop</a> / {{ $product->name }}
            </div>

            <!-- Header -->
            <div class="product-header-v3">
                <div class="product-meta-v3">
                    <span class="badge-v3">{{ $product->product_type }}</span>
                    <span><i class="fas fa-calendar-alt"></i> Updated: {{ $product->updated_at->format('M Y') }}</span>
                    <span><i class="fas fa-shopping-cart"></i> {{ $product->purchase_count }} Sales</span>
                </div>
                <h1>{{ $product->name }}</h1>
                <p class="short-desc-v3">{{ $product->short_description }}</p>
            </div>

            <div class="product-layout-v3">
                <!-- Left Content -->
                <div class="main-content-v3">
                    <!-- Primary Cover Media -->
                    <div class="gallery-v3">
                        <img src="{{ $product->cover_image_url }}" alt="{{ $product->name }}" class="gallery-main">
                    </div>


                    <!-- Details Tabs -->
                    <div class="tabs-v3">
                        <button class="tab-btn-v3 active" onclick="switchTab(event, 'overview')">Full Description</button>
                        <button class="tab-btn-v3" onclick="switchTab(event, 'features')">Technical Specs</button>
                        @if($product->requirements)
                            <button class="tab-btn-v3" onclick="switchTab(event, 'requirements')">Requirements</button>
                        @endif
                        @if($product->license_terms)
                            <button class="tab-btn-v3" onclick="switchTab(event, 'license')">License</button>
                        @endif
                    </div>

                    <div id="overview" class="content-v3 tab-pane active">
                        {!! $product->full_description !!}

                        @if(count($product->features) > 0)
                            <div style="margin-top: 40px;">
                                <h3 style="margin-bottom: 25px;">Key Features</h3>
                                <div class="features-grid-v3">
                                    @foreach($product->features as $feature)
                                        <div class="feature-item-v3">
                                            <i class="fas fa-check-circle"></i>
                                            {{ $feature }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div id="features" class="content-v3 tab-pane">
                        <div class="specs-grid-v3">
                            <div class="spec-section">
                                <h3>Technical Stack</h3>
                                <div class="tech-stack-v3">
                                    @foreach($product->tech_stack as $tech)
                                        <span class="tech-tag-v3">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            </div>

                            @if(count($product->dependencies) > 0)
                                <div class="spec-section">
                                    <h3>Core Dependencies</h3>
                                    <div class="tech-stack-v3">
                                        @foreach($product->dependencies as $dep)
                                            <span class="tech-tag-v3">{{ $dep }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($product->requirements)
                        <div id="requirements" class="content-v3 tab-pane">
                            <h3>System Requirements</h3>
                            <div class="rich-text-v3">
                                {!! $product->requirements !!}
                            </div>
                        </div>
                    @endif

                    @if($product->license_terms)
                        <div id="license" class="content-v3 tab-pane">
                            <h3>License Terms ({{ ucfirst(str_replace('_', ' ', $product->license_type)) }})</h3>
                            <div class="rich-text-v3">
                                {!! $product->license_terms !!}
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Sidebar -->
                <div class="sidebar-v3">
                    <div class="pricing-card-v3">
                        <div style="margin-bottom: 20px;">
                            @if($product->is_on_sale)
                                <span class="price-original">${{ number_format($product->base_price, 2) }}</span>
                            @endif
                            <div class="price-tag-v3">${{ number_format($product->current_price, 2) }}</div>
                            <p class="license-info">Extended Commercial License Included</p>
                        </div>

                        @if(\App\Models\SiteSetting::get('enable_shopping_cart', true))
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="cta-button-v3">
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </button>
                            </form>
                        @else
                            <button type="button" class="cta-button-v3" onclick="openInquiryModal()">
                                <i class="fas fa-paper-plane"></i> Submit Inquiry
                            </button>
                        @endif

                        @if($product->demo_url)
                            <a href="{{ $product->demo_url }}" target="_blank" class="secondary-btn-v3">
                                <i class="fas fa-external-link-alt"></i> Live Preview
                            </a>
                        @endif

                        @if($product->documentation_url)
                            <a href="{{ $product->documentation_url }}" target="_blank" class="secondary-btn-v3"
                                style="margin-top: 10px;">
                                <i class="fas fa-book"></i> Documentation
                            </a>
                        @endif

                        @if($product->github_url)
                            <a href="{{ $product->github_url }}" target="_blank" class="secondary-btn-v3"
                                style="margin-top: 10px;">
                                <i class="fab fa-github"></i> Repository
                            </a>
                        @endif

                        <div class="tech-stack-v3">
                            <h4 style="font-size: 0.9rem; margin-bottom: 15px; color: var(--text-primary);">Built with:</h4>
                            @php
                                $stacks = is_array($product->tech_stack) ? $product->tech_stack : explode("\n", str_replace(',', "\n", $product->tech_stack ?? ''));
                            @endphp
                            @foreach($stacks as $tech)
                                @if(trim($tech))
                                    <span class="tech-tag-v3">{{ trim($tech) }}</span>
                                @endif
                            @endforeach
                        </div>

                        <div style="margin-top: 30px; font-size: 0.85rem; color: var(--text-secondary);">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <span>Version:</span>
                                <span style="color: var(--text-primary); font-weight: 600;">{{ $product->version }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>Support:</span>
                                <span style="color: var(--text-primary); font-weight: 600;">6 Months Included</span>
                            </div>
                        </div>
                    </div>

                    <!-- Trust Badges -->
                    @if(\App\Models\SiteSetting::get('enable_shopping_cart', true))
                        <div style="margin-top: 20px; display: flex; gap: 15px; justify-content: center; opacity: 0.6;">
                            <i class="fab fa-cc-visa fa-2x"></i>
                            <i class="fab fa-cc-mastercard fa-2x"></i>
                            <i class="fab fa-cc-paypal fa-2x"></i>
                            <i class="fab fa-cc-stripe fa-2x"></i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Full Section Software Showcase (Gallery) -->
            @if(!empty($product->preview_images))
                <div class="software-showcase-v3" style="margin-top: 60px;">
                    <h2 style="margin-bottom: 35px; font-weight: 800; font-size: 2.2rem; text-align: center;">Explore Platform
                        Modules</h2>
                    <div class="showcase-tabs" style="justify-content: center;">
                        @foreach($product->preview_images as $index => $preview)
                            <button class="showcase-tab-btn {{ $index === 0 ? 'active' : '' }}"
                                onclick="switchModule(event, 'module-{{ $index }}')">
                                {{ !empty($preview['module']) ? $preview['module'] : ($preview['title'] ?? 'Module ' . ($index + 1)) }}
                            </button>
                        @endforeach
                    </div>

                    <div class="showcase-panes">
                        @foreach($product->preview_images as $index => $preview)
                            <div id="module-{{ $index }}" class="module-pane {{ $index === 0 ? 'active' : '' }}">
                                <div class="showcase-content-v3">
                                    <div class="showcase-text-v3">
                                        <h2>{{ $preview['title'] ?? ($preview['module'] ?? 'Software Module') }}</h2>
                                        <ul class="showcase-features-v3">
                                            @php
                                                $moduleFeatures = explode("\n", $preview['description'] ?? '');
                                            @endphp
                                            @foreach($moduleFeatures as $mFeature)
                                                @if(trim($mFeature))
                                                    <li>{{ trim($mFeature) }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="showcase-visual-v3">
                                        <img src="{{ $preview['url'] }}" alt="{{ $preview['title'] }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Inquiry Modal Overlay -->
    <div class="modal-overlay" id="inquiryModal">
        <div class="inquiry-modal">
            <button class="modal-close" onclick="closeInquiryModal()">
                <i class="fas fa-times"></i>
            </button>
            <div class="modal-header">
                <h2>Product Inquiry</h2>
                <p>Submit your inquiry for <strong>{{ $product->name }}</strong> and our team will get back to you shortly.
                </p>
            </div>
            <form id="productInquiryForm" class="inquiry-form">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="inquiry_type" value="product">
                <input type="hidden" name="subject" value="Inquiry for: {{ $product->name }}">

                <div class="grid-v3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label>Your Name</label>
                        <input type="text" name="name" class="form-input" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-input" placeholder="john@example.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Phone Number (Optional)</label>
                    <input type="text" name="phone" class="form-input"
                        placeholder="{{ \App\Models\SiteSetting::get('phone_number', '+91 0000000000') }}">
                </div>

                <div class="form-group">
                    <label>Your Message</label>
                    <textarea name="message" class="form-input" placeholder="How can we help you with this product?"
                        required></textarea>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="submit-btn" id="submitInquiryBtn">
                        <span class="btn-text">Send Inquiry</span>
                        <div class="loading-spinner" id="btnSpinner"></div>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function switchModule(evt, paneId) {
            document.querySelectorAll('.showcase-tab-btn').forEach(btn => btn.classList.remove('active'));
            if (evt) evt.currentTarget.classList.add('active');
            document.querySelectorAll('.module-pane').forEach(pane => pane.classList.remove('active'));
            const targetPane = document.getElementById(paneId);
            if (targetPane) targetPane.classList.add('active');
        }
        function switchTab(evt, tabId) {
            document.querySelectorAll('.tab-btn-v3').forEach(btn => btn.classList.remove('active'));
            if (evt) evt.currentTarget.classList.add('active');
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
            const targetTab = document.getElementById(tabId);
            if (targetTab) targetTab.classList.add('active');
        }

        // Modal Functions
        function openInquiryModal() {
            document.getElementById('inquiryModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeInquiryModal() {
            document.getElementById('inquiryModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Handle Form Submission
        document.getElementById('productInquiryForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const form = this;
            const btn = document.getElementById('submitInquiryBtn');
            const spinner = document.getElementById('btnSpinner');
            const btnText = btn.querySelector('.btn-text');

            // Disable button and show spinner
            btn.disabled = true;
            spinner.style.display = 'block';
            btnText.textContent = 'Sending...';

            const formData = new FormData(form);

            fetch('{{ route("contact.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Success
                        form.innerHTML = `
                                    <div style="text-align: center; padding: 20px;">
                                        <div style="width: 60px; height: 60px; background: var(--success-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 1.5rem;">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <h3 style="margin-bottom: 10px; color: var(--text-primary);">Inquiry Sent!</h3>
                                        <p style="color: var(--text-secondary);">${data.message}</p>
                                        <button type="button" class="cta-button-v3" style="margin-top: 25px;" onclick="closeInquiryModal()">Close</button>
                                    </div>
                                `;
                    } else {
                        // Validation Errors
                        let errorMsg = 'Please fix the following errors:\n';
                        if (data.errors) {
                            Object.values(data.errors).forEach(err => {
                                errorMsg += `- ${err}\n`;
                            });
                        }
                        alert(errorMsg);
                        btn.disabled = false;
                        spinner.style.display = 'none';
                        btnText.textContent = 'Send Inquiry';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Something went wrong. Please try again later.');
                    btn.disabled = false;
                    spinner.style.display = 'none';
                    btnText.textContent = 'Send Inquiry';
                });
        });

        // Close modal on click outside
        window.onclick = function (event) {
            const modal = document.getElementById('inquiryModal');
            if (event.target == modal) {
                closeInquiryModal();
            }
        }
    </script>
@endpush