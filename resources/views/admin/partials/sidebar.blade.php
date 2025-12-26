<aside class="admin-sidebar" id="adminSidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <a href="{{ url('/admin') }}" class="sidebar-logo">
            <i class="fas fa-code"></i>
            <span>CodeCraft</span>
        </a>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="sidebar-nav">
        <!-- Dashboard Section -->
        <div class="nav-section">
            <div class="nav-section-title">Main</div>
            <ul class="nav-links">
                <li>
                    <a href="{{ url('/admin/dashboard') }}"
                        class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/analytics') }}"
                        class="nav-link {{ Request::is('admin/analytics') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Analytics</span>
                    </a>
                </li>

            </ul>
        </div>

        <!-- Sales Section -->
        <div class="nav-section">
            <div class="nav-section-title">Sales</div>
            <ul class="nav-links">
                <li>
                    <a href="{{ url('/admin/orders') }}"
                        class="nav-link {{ Request::is('admin/orders*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Orders</span>
                        @if(isset($pendingOrdersCount) && $pendingOrdersCount > 0)
                            <span class="nav-badge">{{ $pendingOrdersCount }}</span>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.invoices.index') }}"
                        class="nav-link {{ Request::is('admin/invoices*') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice"></i>
                        <span>Invoices</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.clients.index') }}"
                        class="nav-link {{ Request::is('admin/clients*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Clients</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Products Section -->
        <div class="nav-section">
            <div class="nav-section-title">Products</div>
            <ul class="nav-links">
                <li>
                    <a href="{{ url('/admin/products') }}"
                        class="nav-link {{ Request::is('admin/products*') ? 'active' : '' }}">
                        <i class="fas fa-box"></i>
                        <span>All Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/categories') }}"
                        class="nav-link {{ Request::is('admin/categories*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i>
                        <span>Categories</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Services Section -->
        <div class="nav-section">
            <div class="nav-section-title">Services</div>
            <ul class="nav-links">
                <li>
                    <a href="{{ url('/admin/services') }}"
                        class="nav-link {{ Request::is('admin/services*') ? 'active' : '' }}">
                        <i class="fas fa-briefcase"></i>
                        <span>All Services</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/quotes') }}"
                        class="nav-link {{ Request::is('admin/quotes*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i>
                        <span>Quote Requests</span>
                        @if(isset($newQuotesCount) && $newQuotesCount > 0)
                            <span class="nav-badge">{{ $newQuotesCount }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>

        <!-- Content Section -->
        <div class="nav-section">
            <div class="nav-section-title">Content</div>
            <ul class="nav-links">
                <li>
                    <a href="{{ url('/admin/portfolio') }}"
                        class="nav-link {{ Request::is('admin/portfolio*') ? 'active' : '' }}">
                        <i class="fas fa-folder-open"></i>
                        <span>Portfolio</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/blog') }}"
                        class="nav-link {{ Request::is('admin/blog*') ? 'active' : '' }}">
                        <i class="fas fa-blog"></i>
                        <span>Blog Posts</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/snippets') }}"
                        class="nav-link {{ Request::is('admin/snippets*') ? 'active' : '' }}">
                        <i class="fas fa-code"></i>
                        <span>Code Snippets</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Communication Section -->
        <div class="nav-section">
            <div class="nav-section-title">Communication</div>
            <ul class="nav-links">
                <li>
                    <a href="{{ url('/admin/inquiries') }}"
                        class="nav-link {{ Request::is('admin/inquiries*') ? 'active' : '' }}">
                        <i class="fas fa-envelope"></i>
                        <span>Inquiries</span>
                        @if(isset($newInquiriesCount) && $newInquiriesCount > 0)
                            <span class="nav-badge">{{ $newInquiriesCount }}</span>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/emails') }}"
                        class="nav-link {{ Request::is('admin/emails*') ? 'active' : '' }}">
                        <i class="fas fa-paper-plane"></i>
                        <span>Email History</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Settings Section -->
        <div class="nav-section">
            <div class="nav-section-title">Settings</div>
            <ul class="nav-links">
                <li>
                    <a href="{{ url('/admin/settings') }}"
                        class="nav-link {{ Request::is('admin/settings*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Site Settings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/users') }}"
                        class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}">
                        <i class="fas fa-user-shield"></i>
                        <span>Users</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">AM</div>
            <div class="user-details">
                <h4>{{ auth()->user()->full_name ?? 'Admin User' }}</h4>
                <p>{{ auth()->user()->role ?? 'Administrator' }}</p>
            </div>
        </div>
    </div>
</aside>