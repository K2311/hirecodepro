<style>
    :root {
        /* Light theme */
        --bg-primary: #ffffff;
        --bg-secondary: #f8f9fa;
        --bg-tertiary: #f1f3f5;
        --text-primary: #1a1a1a;
        --text-secondary: #666666;
        --text-tertiary: #888888;
        --border-color: #e1e4e8;
        --primary-color:
            {{ \App\Models\SiteSetting::get('primary_color') ?? '#6366f1' }}
        ;
        --primary-dark:
            {{ \App\Models\SiteSetting::get('primary_hover') ?? '#4f46e5' }}
        ;
        --secondary-color:
            {{ \App\Models\SiteSetting::get('secondary_color') ?? '#10b981' }}
        ;
        --accent-color:
            {{ \App\Models\SiteSetting::get('accent_color') ?? '#8b5cf6' }}
        ;
        --danger-color: #ef4444;
        --warning-color: #f59e0b;
        --success-color: #10b981;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --card-shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --radius: 8px;
        --radius-lg: 12px;
        --sidebar-width: 280px;
    }

    .dark-mode {
        /* Dark theme */
        --bg-primary: #0d1117;
        --bg-secondary: #161b22;
        --bg-tertiary: #21262d;
        --text-primary: #f0f6fc;
        --text-secondary: #c9d1d9;
        --text-tertiary: #8b949e;
        --border-color: #30363d;
        --primary-color:
            {{ \App\Models\SiteSetting::get('primary_color') ?? '#6366f1' }}
        ;
        --primary-dark:
            {{ \App\Models\SiteSetting::get('primary_hover') ?? '#4f46e5' }}
        ;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
        --card-shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--bg-primary);
        color: var(--text-primary);
        line-height: 1.6;
        transition: background-color 0.3s, color 0.3s;
    }

    .container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Dark Mode Utility Classes */
    body.dark-mode .show-on-light {
        display: none !important;
    }

    body.dark-mode .show-on-dark {
        display: inline-block !important;
    }

    body:not(.dark-mode) .show-on-light {
        display: inline-block !important;
    }

    body:not(.dark-mode) .show-on-dark {
        display: none !important;
    }

    /* Header & Navigation */
    header {
        background-color: var(--bg-primary);
        border-bottom: 1px solid var(--border-color);
        position: sticky;
        top: 0;
        z-index: 100;
        backdrop-filter: blur(10px);
        background-color: rgba(var(--bg-primary-rgb), 0.9);
    }

    nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
    }

    .logo {
        display: flex;
        align-items: center;
        font-size: 24px;
        font-weight: 700;
        color: var(--text-primary);
        text-decoration: none;
    }

    .logo span {
        color: var(--primary-color);
    }

    .logo i {
        margin-right: 10px;
        color: var(--primary-color);
    }

    .nav-links {
        display: flex;
        gap: 30px;
        align-items: center;
    }

    .nav-links a {
        color: var(--text-secondary);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
        position: relative;
    }

    .nav-links a:hover,
    .nav-links a.active {
        color: var(--primary-color);
    }

    .nav-links a.active::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: var(--primary-color);
    }

    .cart-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background-color: var(--danger-color);
        color: white;
        font-size: 10px;
        font-weight: 700;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid var(--bg-primary);
    }

    .nav-buttons {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .btn {
        padding: 10px 20px;
        border-radius: var(--radius);
        font-weight: 600;
        cursor: pointer;
        border: none;
        font-size: 14px;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);
    }

    .btn-outline {
        background-color: transparent;
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .btn-outline:hover {
        background-color: var(--bg-secondary);
        border-color: var(--primary-color);
    }

    .btn-secondary {
        background-color: var(--bg-secondary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .btn-secondary:hover {
        background-color: var(--bg-tertiary);
    }

    .btn-small {
        padding: 6px 12px;
        font-size: 13px;
    }

    .btn-large {
        padding: 14px 28px;
        font-size: 16px;
    }

    .theme-toggle {
        background: none;
        border: none;
        color: var(--text-secondary);
        cursor: pointer;
        font-size: 18px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s;
    }

    .theme-toggle:hover {
        background-color: var(--bg-secondary);
    }

    /* Hero Section */
    .hero {
        padding: 50px 0;
        background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
        position: relative;
        overflow: hidden;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 50%;
        height: 100%;
        background: radial-gradient(circle at top right, rgba(99, 102, 241, 0.1) 0%, transparent 70%);
    }

    .hero-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .hero-text h1 {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 20px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .hero-text p {
        font-size: 1.25rem;
        color: var(--text-secondary);
        margin-bottom: 30px;
    }

    .hero-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 30px;
    }

    .badge {
        background-color: var(--bg-tertiary);
        color: var(--text-primary);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .hero-buttons {
        display: flex;
        gap: 20px;
    }

    .hero-visual {
        position: relative;
    }

    .code-window {
        background-color: var(--bg-tertiary);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        overflow: hidden;
        box-shadow: var(--card-shadow-hover);
    }

    .window-header {
        background-color: var(--bg-secondary);
        padding: 15px 20px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .window-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .dot-red {
        background-color: #ff5f56;
    }

    .dot-yellow {
        background-color: #ffbd2e;
    }

    .dot-green {
        background-color: #27ca3f;
    }

    .window-content {
        padding: 25px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 14px;
        line-height: 1.8;
    }

    .code-comment {
        color: #94a3b8;
    }

    .code-keyword {
        color: var(--primary-color);
        font-weight: 600;
    }

    .code-function {
        color: var(--accent-color);
    }

    .code-string {
        color: var(--success-color);
    }

    .dark-mode .code-string {
        color: var(--success-color);
    }

    .dark-mode .code-keyword {
        color: var(--primary-color);
    }

    .dark-mode .code-function {
        color: var(--accent-color);
    }

    /* Sections */
    .section {
        padding: 100px 0;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
        text-align: center;
    }

    .section-subtitle {
        color: var(--text-secondary);
        font-size: 1.125rem;
        margin-bottom: 60px;
        text-align: center;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Services Section */
    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .service-card {
        background-color: var(--bg-secondary);
        border-radius: var(--radius-lg);
        padding: 40px 30px;
        border: 1px solid var(--border-color);
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--card-shadow-hover);
        border-color: var(--primary-color);
    }

    .service-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 28px;
        margin-bottom: 25px;
    }

    .service-card h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .service-card p {
        color: var(--text-secondary);
        margin-bottom: 25px;
    }

    .service-features {
        list-style: none;
        margin-bottom: 25px;
    }

    .service-features li {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .service-features li i {
        color: var(--success-color);
    }

    .service-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .service-footer {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    /* Products Section */
    .products-filter {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 50px;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 8px 20px;
        background: none;
        border: 1px solid var(--border-color);
        border-radius: 30px;
        color: var(--text-secondary);
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
    }

    .product-card {
        background-color: var(--bg-secondary);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        overflow: hidden;
        transition: all 0.3s;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-shadow-hover);
    }

    .product-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background-color: var(--primary-color);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        z-index: 2;
    }

    .product-image {
        height: 200px;
        background-color: var(--bg-tertiary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-tertiary);
        font-size: 3rem;
        position: relative;
        overflow: hidden;
    }

    .product-image img,
    .product-image video,
    .product-image iframe {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-content {
        padding: 25px;
    }

    .product-gallery-preview {
        display: flex;
        gap: 8px;
        margin: 15px 0;
        flex-wrap: wrap;
    }

    .gallery-item {
        width: 45px;
        height: 45px;
        border-radius: 6px;
        overflow: hidden;
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        position: relative;
        cursor: pointer;
        transition: all 0.2s;
    }

    .gallery-item:hover {
        transform: scale(1.1);
        border-color: var(--primary-color);
        z-index: 1;
    }

    .gallery-item img,
    .gallery-item video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .gallery-item-video-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 24px;
        height: 24px;
        background: rgba(0, 0, 0, 0.6);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 10px;
    }

    .product-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .product-header h3 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-right: 10px;
    }

    .product-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        white-space: nowrap;
    }

    .product-description {
        color: var(--text-secondary);
        margin-bottom: 20px;
    }

    .tech-stack {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 20px;
    }

    .tech-badge {
        background-color: var(--bg-tertiary);
        color: var(--text-primary);
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .product-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .product-stats {
        display: flex;
        gap: 15px;
        color: var(--text-tertiary);
        font-size: 14px;
    }

    .product-stat {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* About Section */
    .about-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .about-text h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .about-text p {
        color: var(--text-secondary);
        margin-bottom: 25px;
        font-size: 1.125rem;
    }

    .about-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 40px;
    }

    .about-stat {
        text-align: center;
    }

    .about-stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 5px;
    }

    .about-stat-label {
        color: var(--text-secondary);
        font-size: 14px;
    }

    .about-visual {
        position: relative;
    }

    .experience-card {
        background-color: var(--bg-secondary);
        border-radius: var(--radius-lg);
        padding: 30px;
        border: 1px solid var(--border-color);
        box-shadow: var(--card-shadow);
    }

    .experience-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .experience-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--primary-color);
    }

    .experience-info h4 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .experience-info p {
        color: var(--text-secondary);
    }

    /* Contact CTA */
    .contact-cta {
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        color: white;
        padding: 80px 0;
        text-align: center;
        border-radius: var(--radius-lg);
        margin: 100px auto;
        max-width: 1000px;
    }

    .contact-cta h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .contact-cta p {
        font-size: 1.25rem;
        margin-bottom: 40px;
        opacity: 0.9;
    }

    .cta-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
    }

    .btn-white {
        background-color: white;
        color: var(--primary-color);
    }

    .btn-white:hover {
        background-color: rgba(255, 255, 255, 0.9);
        transform: translateY(-2px);
    }

    .btn-transparent {
        background-color: transparent;
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn-transparent:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: white;
    }

    /* Footer */
    footer {
        background-color: var(--bg-tertiary);
        padding: 80px 0 30px;
        border-top: 1px solid var(--border-color);
    }

    .footer-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 50px;
        margin-bottom: 50px;
    }

    .footer-column h3 {
        font-size: 1.25rem;
        margin-bottom: 25px;
    }

    .footer-column p {
        color: var(--text-secondary);
        margin-bottom: 25px;
    }

    .social-links {
        display: flex;
        gap: 15px;
    }

    .social-link {
        width: 40px;
        height: 40px;
        background-color: var(--bg-secondary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-primary);
        text-decoration: none;
        transition: all 0.2s;
    }

    .social-link:hover {
        background-color: var(--primary-color);
        color: white;
        transform: translateY(-3px);
    }

    .footer-column ul {
        list-style: none;
    }

    .footer-column ul li {
        margin-bottom: 12px;
    }

    .footer-column ul li a {
        color: var(--text-secondary);
        text-decoration: none;
        transition: color 0.2s;
    }

    .footer-column ul li a:hover {
        color: var(--primary-color);
    }

    .copyright {
        text-align: center;
        padding-top: 30px;
        border-top: 1px solid var(--border-color);
        color: var(--text-tertiary);
        font-size: 14px;
    }

    /* Product Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background-color: var(--bg-primary);
        border-radius: var(--radius-lg);
        width: 100%;
        max-width: 900px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        border: 1px solid var(--border-color);
    }

    .modal-close {
        position: absolute;
        top: 20px;
        right: 20px;
        background: none;
        border: none;
        color: var(--text-secondary);
        font-size: 24px;
        cursor: pointer;
        z-index: 10;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s;
    }

    .modal-close:hover {
        background-color: var(--bg-secondary);
    }

    /* Responsive */
    @media (max-width: 992px) {

        .hero-content,
        .about-content {
            grid-template-columns: 1fr;
            gap: 50px;
        }

        .hero-text h1 {
            font-size: 2.8rem;
        }

        .nav-links {
            display: none;
        }

        .mobile-menu-btn {
            display: block;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .hero-text h1 {
            font-size: 2.2rem;
        }

        .hero-buttons,
        .cta-buttons {
            flex-direction: column;
            align-items: center;
        }

        .section-title {
            font-size: 2rem;
        }

        .services-grid,
        .products-grid {
            grid-template-columns: 1fr;
        }

        .about-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .hero-text h1 {
            font-size: 1.8rem;
        }

        .section {
            padding: 70px 0;
        }

        .about-stats {
            grid-template-columns: 1fr;
        }
    }

    /* Mobile Menu */
    .mobile-menu-btn {
        display: none;
        background: none;
        border: none;
        font-size: 24px;
        color: var(--text-primary);
        cursor: pointer;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s;
    }

    .mobile-menu-btn:hover {
        background-color: var(--bg-secondary);
    }

    .mobile-menu {
        display: none;
        position: fixed;
        top: 80px;
        left: 0;
        width: 100%;
        background-color: var(--bg-primary);
        border-bottom: 1px solid var(--border-color);
        padding: 20px;
        z-index: 99;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .mobile-menu.active {
        display: block;
    }

    .mobile-menu-links {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .mobile-menu-links a {
        color: var(--text-secondary);
        text-decoration: none;
        font-weight: 500;
        padding: 12px 0;
        border-bottom: 1px solid var(--border-color);
        transition: color 0.2s;
    }

    .mobile-menu-links a:hover,
    .mobile-menu-links a.active {
        color: var(--primary-color);
    }

    /* Utility */
    .text-center {
        text-align: center;
    }

    .mb-1 {
        margin-bottom: 10px;
    }

    .mb-2 {
        margin-bottom: 20px;
    }

    .mb-3 {
        margin-bottom: 30px;
    }

    .mb-4 {
        margin-bottom: 40px;
    }

    .mt-1 {
        margin-top: 10px;
    }

    .mt-2 {
        margin-top: 20px;
    }

    .mt-3 {
        margin-top: 30px;
    }

    .mt-4 {
        margin-top: 40px;
    }

    .flex {
        display: flex;
    }

    .flex-col {
        flex-direction: column;
    }

    .items-center {
        align-items: center;
    }

    .justify-between {
        justify-content: space-between;
    }

    .gap-1 {
        gap: 10px;
    }

    .gap-2 {
        gap: 20px;
    }

    .gap-3 {
        gap: 30px;
    }

    .hidden {
        display: none;
    }
</style>