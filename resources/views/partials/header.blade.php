<header>
    <div class="container">
        <nav>
            <a href="{{ url('/') }}" class="logo">
                @php
                    $logoLight = \App\Models\SiteSetting::get('site_logo_light');
                    $logoDark = \App\Models\SiteSetting::get('site_logo_dark');
                    $siteName = \App\Models\SiteSetting::get('site_name', 'CodeCraft');
                @endphp

                @if($logoLight && $logoDark)
                    <img src="{{ asset($logoLight) }}" alt="{{ $siteName }}" class="show-on-light"
                        style="height: 40px; width: auto;">
                    <img src="{{ asset($logoDark) }}" alt="{{ $siteName }}" class="show-on-dark"
                        style="height: 40px; width: auto;">
                @elseif($logoLight)
                    <img src="{{ asset($logoLight) }}" alt="{{ $siteName }}" style="height: 40px; width: auto;">
                @elseif($logoDark)
                    <img src="{{ asset($logoDark) }}" alt="{{ $siteName }}" style="height: 40px; width: auto;">
                @else
                    @if($siteName === 'CodeCraft')
                        <i class="fas fa-code"></i>Code<span>Craft</span>
                    @else
                        {{ $siteName }}
                    @endif
                @endif
            </a>

            <div class="nav-links">
                <a href="{{ url('/#home') }}" class="{{ Request::is('/') ? 'active' : '' }}">Home</a>
                <a href="{{ url('/#services') }}">Services</a>
                <a href="{{ url('/#products') }}">Products</a>
                <a href="{{ url('/#about') }}">About</a>
                <a href="{{ url('/#contact') }}">Contact</a>
            </div>

            <div class="nav-buttons">
                @if(\App\Models\SiteSetting::get('enable_shopping_cart', true))
                    <a href="{{ route('cart.index') }}" class="cart-link"
                        style="position: relative; margin-right: 15px; font-size: 1.2rem; color: var(--text-primary);">
                        <i class="fas fa-shopping-cart"></i>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="cart-badge">{{ count(session('cart')) }}</span>
                        @endif
                    </a>
                @endif
                <button class="theme-toggle" id="themeToggle">
                    <i class="fas fa-moon"></i>
                </button>
                <a href="{{ route('quote.index') }}" class="btn btn-primary">Get a Quote</a>
                <button class="mobile-menu-btn" id="mobileMenuBtn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </nav>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-links">
            <a href="{{ url('/#home') }}" class="{{ Request::is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ url('/#services') }}">Services</a>
            <a href="{{ url('/#products') }}">Products</a>
            <a href="{{ url('/#about') }}">About</a>
            <a href="{{ url('/#contact') }}">Contact</a>
            <a href="{{ route('quote.index') }}">Get a Quote</a>
        </div>
    </div>
</header>