<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-column">
                @php
                    $logoLight = \App\Models\SiteSetting::get('site_logo_light');
                    $logoDark = \App\Models\SiteSetting::get('site_logo_dark');
                    $siteName = \App\Models\SiteSetting::get('site_name', 'HireCadePro');
                @endphp

                <a href="{{ url('/') }}" class="footer-logo"
                    style="display: block; margin-bottom: 1.5rem; text-decoration: none; color: var(--text-primary); font-size: 1.5rem; font-weight: 700;">
                    @if($logoLight && $logoDark)
                        <img src="{{ asset($logoLight) }}" alt="{{ $siteName }}" class="show-on-light"
                            style="height: 50px; width: auto;">
                        <img src="{{ asset($logoDark) }}" alt="{{ $siteName }}" class="show-on-dark"
                            style="height: 50px; width: auto;">
                    @elseif($logoLight)
                        <img src="{{ asset($logoLight) }}" alt="{{ $siteName }}" style="height: 50px; width: auto;">
                    @elseif($logoDark)
                        <img src="{{ asset($logoDark) }}" alt="{{ $siteName }}" style="height: 50px; width: auto;">
                    @else
                        {{ $siteName }}
                    @endif
                </a>
                <p>Full-stack development services and premium code products for startups and businesses.</p>

                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-github"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-dev"></i></a>
                </div>
            </div>

            <div class="footer-column">
                <h3>Services</h3>
                <ul>
                    <li><a href="{{ url('/#services') }}">SaaS Development</a></li>
                    <li><a href="{{ url('/#services') }}">API Development</a></li>
                    <li><a href="{{ url('/#services') }}">AI Integration</a></li>
                    <li><a href="{{ url('/#services') }}">Consulting</a></li>
                    <li><a href="{{ url('/#services') }}">Code Review</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>Products</h3>
                <ul>
                    <li><a href="{{ url('/#products') }}">SaaS Templates</a></li>
                    <li><a href="{{ url('/#products') }}">APIs</a></li>
                    <li><a href="{{ url('/#products') }}">WordPress Plugins</a></li>
                    <li><a href="{{ url('/#products') }}">Developer Tools</a></li>
                    <li><a href="{{ url('/#products') }}">UI Components</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>Contact</h3>
                <ul>
                    <li><i class="fas fa-envelope"></i> {{ \App\Models\SiteSetting::get('contact_email',
                        'hello@hirecodepro.dev') }}</li>
                    <li><i class="fas fa-phone"></i>
                        {{ \App\Models\SiteSetting::get('contact_phone', '+1 (555) 123-4567') }}</li>
                    <li><i class="fas fa-map-marker-alt"></i>
                        {{ \App\Models\SiteSetting::get('contact_address', 'San Francisco, CA') }}</li>
                </ul>
            </div>
        </div>

        <div class="copyright">
            <p>&copy; {{ date('Y') }} {{ $siteName }}. All rights reserved. | Built with <i class="fas fa-heart"
                    style="color: #ef4444;"></i></p>
        </div>
    </div>
</footer>