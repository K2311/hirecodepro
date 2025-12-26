<header class="admin-header">
    <div class="header-left">
        <button class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="header-title">
            <h1>@yield('page-title', 'Dashboard')</h1>
        </div>
    </div>

    <div class="header-actions">
        <!-- Search -->
        <button class="header-action" title="Search">
            <i class="fas fa-search"></i>
        </button>

        <!-- Notifications -->
        <button class="header-action" id="notificationsBtn" title="Notifications">
            <i class="fas fa-bell"></i>
            <span class="notification-badge"></span>
        </button>

        <!-- Messages -->
        <button class="header-action" title="Messages">
            <i class="fas fa-envelope"></i>
        </button>

        <!-- Theme Toggle -->
        <button class="theme-toggle" id="themeToggle" title="Toggle Theme">
            <i class="fas fa-moon"></i>
        </button>

        <!-- User Menu -->
        <div class="user-menu">
            <button class="header-action" id="userMenuBtn">
                <div class="user-avatar">AM</div>
            </button>
            <div class="user-dropdown" id="userDropdown">
                <a href="{{ url('/admin/profile') }}" class="dropdown-item">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="{{ url('/admin/settings') }}" class="dropdown-item">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ url('/') }}" class="dropdown-item" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    <span>View Site</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ url('/logout') }}" class="dropdown-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </div>
</header>