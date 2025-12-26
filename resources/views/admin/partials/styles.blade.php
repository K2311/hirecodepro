<style>
    :root {
        --primary:
            {{ \App\Models\SiteSetting::get('primary_color') ?? '#3b82f6' }}
        ;
        --primary-dark:
            {{ \App\Models\SiteSetting::get('primary_hover') ?? '#1d4ed8' }}
        ;
        --secondary:
            {{ \App\Models\SiteSetting::get('secondary_color') ?? '#8b5cf6' }}
        ;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --dark-bg: #0f172a;
        --dark-sidebar: #1e293b;
        --dark-card: #1e293b;
        --dark-text: #f1f5f9;
        --dark-muted: #94a3b8;
        --dark-border: #334155;
        --light-bg: #f8fafc;
        --light-sidebar: #ffffff;
        --light-card: #ffffff;
        --light-text: #0f172a;
        --light-muted: #64748b;
        --light-border: #e2e8f0;
        --border-radius: 8px;
        --border-radius-lg: 12px;
        --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        line-height: 1.5;
        background-color: var(--light-bg);
        color: var(--light-text);
        transition: var(--transition);
        height: 100vh;
        overflow: hidden;
    }

    body.dark-mode {
        background-color: var(--dark-bg);
        color: var(--dark-text);
    }

    .admin-container {
        display: flex;
        height: 100vh;
    }

    /* Sidebar */
    .admin-sidebar {
        width: 260px;
        background-color: var(--light-sidebar);
        border-right: 1px solid var(--light-border);
        display: flex;
        flex-direction: column;
        transition: var(--transition);
        z-index: 100;
    }

    body.dark-mode .admin-sidebar {
        background-color: var(--dark-sidebar);
        border-right: 1px solid var(--dark-border);
    }

    .sidebar-header {
        padding: 24px;
        border-bottom: 1px solid var(--light-border);
    }

    body.dark-mode .sidebar-header {
        border-bottom: 1px solid var(--dark-border);
    }

    .sidebar-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--primary);
    }

    .sidebar-logo span {
        color: var(--light-text);
    }

    body.dark-mode .sidebar-logo span {
        color: var(--dark-text);
    }

    .sidebar-logo i {
        font-size: 1.5rem;
    }

    .sidebar-nav {
        flex: 1;
        padding: 24px 0;
        overflow-y: auto;
    }

    .nav-section {
        margin-bottom: 24px;
    }

    .nav-section-title {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--light-muted);
        font-weight: 600;
        padding: 0 24px 12px;
    }

    body.dark-mode .nav-section-title {
        color: var(--dark-muted);
    }

    .nav-links {
        list-style: none;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 24px;
        color: var(--light-text);
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
        border-left: 3px solid transparent;
    }

    body.dark-mode .nav-link {
        color: var(--dark-text);
    }

    .nav-link:hover {
        background-color: rgba(59, 130, 246, 0.05);
        color: var(--primary);
    }

    body.dark-mode .nav-link:hover {
        background-color: rgba(59, 130, 246, 0.1);
    }

    .nav-link.active {
        background-color: rgba(59, 130, 246, 0.1);
        color: var(--primary);
        border-left: 3px solid var(--primary);
    }

    .nav-link i {
        font-size: 1.125rem;
        width: 24px;
        text-align: center;
    }

    .nav-badge {
        margin-left: auto;
        background-color: var(--primary);
        color: white;
        font-size: 0.75rem;
        padding: 2px 8px;
        border-radius: 12px;
        font-weight: 600;
    }

    .sidebar-footer {
        padding: 24px;
        border-top: 1px solid var(--light-border);
    }

    body.dark-mode .sidebar-footer {
        border-top: 1px solid var(--dark-border);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
    }

    .user-details h4 {
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 2px;
    }

    .user-details p {
        font-size: 0.8rem;
        color: var(--light-muted);
    }

    body.dark-mode .user-details p {
        color: var(--dark-muted);
    }

    /* Main Content */
    .admin-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .admin-header {
        padding: 0 32px;
        height: 72px;
        background-color: var(--light-sidebar);
        border-bottom: 1px solid var(--light-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    body.dark-mode .admin-header {
        background-color: var(--dark-sidebar);
        border-bottom: 1px solid var(--dark-border);
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .menu-toggle {
        display: none;
        background: none;
        border: none;
        font-size: 1.25rem;
        color: var(--light-text);
        cursor: pointer;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        align-items: center;
        justify-content: center;
    }

    body.dark-mode .menu-toggle {
        color: var(--dark-text);
    }

    .menu-toggle:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    body.dark-mode .menu-toggle:hover {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .header-title h1 {
        font-size: 1.5rem;
        font-weight: 700;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .header-action {
        position: relative;
        background: none;
        border: none;
        color: var(--light-text);
        font-size: 1.125rem;
        cursor: pointer;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
    }

    body.dark-mode .header-action {
        color: var(--dark-text);
    }

    .header-action:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    body.dark-mode .header-action:hover {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .notification-badge {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 8px;
        height: 8px;
        background-color: var(--danger);
        border-radius: 50%;
        border: 2px solid var(--light-sidebar);
    }

    body.dark-mode .notification-badge {
        border-color: var(--dark-sidebar);
    }

    .theme-toggle {
        background: none;
        border: none;
        color: var(--light-text);
        font-size: 1.25rem;
        cursor: pointer;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }

    body.dark-mode .theme-toggle {
        color: var(--dark-text);
    }

    .theme-toggle:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    body.dark-mode .theme-toggle:hover {
        background-color: rgba(255, 255, 255, 0.05);
    }

    /* User Menu Dropdown */
    .user-menu {
        position: relative;
    }

    .user-dropdown {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        background-color: var(--light-card);
        border: 1px solid var(--light-border);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        min-width: 200px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: var(--transition);
        z-index: 1000;
    }

    body.dark-mode .user-dropdown {
        background-color: var(--dark-card);
        border: 1px solid var(--dark-border);
    }

    .user-dropdown.active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: var(--light-text);
        text-decoration: none;
        transition: var(--transition);
    }

    body.dark-mode .dropdown-item {
        color: var(--dark-text);
    }

    .dropdown-item:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    body.dark-mode .dropdown-item:hover {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .dropdown-divider {
        height: 1px;
        background-color: var(--light-border);
        margin: 8px 0;
    }

    body.dark-mode .dropdown-divider {
        background-color: var(--dark-border);
    }

    /* Admin Content */
    .admin-content {
        flex: 1;
        padding: 32px;
        overflow-y: auto;
    }

    /* Dashboard Overview */
    .overview-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .overview-card {
        background-color: var(--light-card);
        border-radius: var(--border-radius-lg);
        padding: 24px;
        box-shadow: var(--shadow);
        transition: var(--transition);
        border: 1px solid var(--light-border);
    }

    body.dark-mode .overview-card {
        background-color: var(--dark-card);
        border: 1px solid var(--dark-border);
    }

    .overview-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
    }

    .card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .icon-revenue {
        background-color: rgba(59, 130, 246, 0.1);
        color: var(--primary);
    }

    .icon-orders {
        background-color: rgba(139, 92, 246, 0.1);
        color: var(--secondary);
    }

    .icon-products {
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }

    .icon-clients {
        background-color: rgba(245, 158, 11, 0.1);
        color: var(--warning);
    }

    .card-trend {
        font-size: 0.875rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .trend-up {
        color: var(--success);
    }

    .trend-down {
        color: var(--danger);
    }

    .card-value {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 8px;
    }

    .card-label {
        color: var(--light-muted);
        font-size: 0.875rem;
    }

    body.dark-mode .card-label {
        color: var(--dark-muted);
    }

    /* Buttons */
    .btn {
        padding: 10px 20px;
        border-radius: var(--border-radius);
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: var(--transition);
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        box-shadow: var(--shadow);
    }

    .btn-secondary {
        background-color: transparent;
        color: var(--primary);
        border: 1px solid var(--primary);
    }

    .btn-secondary:hover {
        background-color: rgba(59, 130, 246, 0.1);
    }

    .btn-success {
        background-color: var(--success);
        color: white;
    }

    .btn-success:hover {
        background-color: #0da271;
        box-shadow: var(--shadow);
    }

    .btn-danger {
        background-color: var(--danger);
        color: white;
    }

    .btn-danger:hover {
        background-color: #dc2626;
        box-shadow: var(--shadow);
    }

    /* Outline button variants used in admin views */
    .btn-outline-secondary {
        background: transparent;
        color: var(--light-text);
        border: 1px solid var(--light-border);
    }

    .btn-outline-secondary:hover {
        background: rgba(0, 0, 0, 0.03);
    }

    .btn-outline-warning {
        background: transparent;
        color: var(--warning);
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .btn-outline-danger {
        background: transparent;
        color: var(--danger);
        border: 1px solid rgba(239, 68, 68, 0.15);
    }

    .btn-outline-primary {
        background: transparent;
        color: var(--primary);
        border: 1px solid rgba(59, 130, 246, 0.12);
    }

    .btn-outline-info {
        background: transparent;
        color: var(--secondary);
        border: 1px solid rgba(139, 92, 246, 0.1);
    }

    /* Tables */
    .table-card {
        background-color: var(--light-card);
        border-radius: var(--border-radius-lg);
        padding: 24px;
        box-shadow: var(--shadow);
        border: 1px solid var(--light-border);
        margin-bottom: 32px;
    }

    body.dark-mode .table-card {
        background-color: var(--dark-card);
        border: 1px solid var(--dark-border);
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .table-title {
        font-size: 1.25rem;
        font-weight: 700;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background-color: rgba(0, 0, 0, 0.02);
        border-bottom: 1px solid var(--light-border);
    }

    body.dark-mode thead {
        background-color: rgba(255, 255, 255, 0.02);
        border-bottom: 1px solid var(--dark-border);
    }

    th {
        padding: 16px;
        text-align: left;
        font-weight: 600;
        color: var(--light-muted);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    body.dark-mode th {
        color: var(--dark-muted);
    }

    td {
        padding: 16px;
        border-bottom: 1px solid var(--light-border);
    }

    body.dark-mode td {
        border-bottom: 1px solid var(--dark-border);
    }

    tr:last-child td {
        border-bottom: none;
    }

    tr:hover {
        background-color: rgba(0, 0, 0, 0.01);
    }

    /* Checkbox and table small-screen adjustments */
    .form-check-input {
        width: 18px;
        height: 18px;
        margin-top: 0;
    }

    /* Ensure header select-all checkbox lines up */
    thead th:first-child,
    tbody td:first-child {
        width: 48px;
        text-align: center;
        padding-left: 12px;
        padding-right: 12px;
    }

    /* Make tables responsive on small screens */
    @media (max-width: 768px) {
        table thead {
            display: none;
        }

        table,
        tbody,
        tr,
        td {
            display: block;
            width: 100%;
        }

        tbody tr {
            margin-bottom: 16px;
            border: 1px solid var(--light-border);
            border-radius: 8px;
            padding: 12px;
        }

        tbody td {
            padding: 8px 12px;
            border-bottom: none;
        }

        tbody td::before {
            content: attr(data-label);
            display: block;
            font-weight: 600;
            color: var(--light-muted);
            margin-bottom: 6px;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
    }

    body.dark-mode tr:hover {
        background-color: rgba(255, 255, 255, 0.01);
    }

    /* Status Badges */
    .status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }

    .status-active,
    .status-paid,
    .status-published {
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }

    .status-pending,
    .status-draft {
        background-color: rgba(245, 158, 11, 0.1);
        color: var(--warning);
    }

    .status-inactive,
    .status-failed,
    .status-cancelled {
        background-color: rgba(239, 68, 68, 0.1);
        color: var(--danger);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .admin-sidebar {
            position: fixed;
            left: -260px;
            height: 100vh;
            z-index: 1000;
        }

        .admin-sidebar.active {
            left: 0;
        }

        .menu-toggle {
            display: flex !important;
        }

        .overview-cards {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .admin-content {
            padding: 16px;
        }

        .admin-header {
            padding: 0 16px;
        }

        .overview-cards {
            grid-template-columns: 1fr;
        }

        .header-title h1 {
            font-size: 1.25rem;
        }
    }

    /* Utility Classes */
    .mb-1 {
        margin-bottom: 8px;
    }

    .mb-2 {
        margin-bottom: 16px;
    }

    .mb-3 {
        margin-bottom: 24px;
    }

    .mb-4 {
        margin-bottom: 32px;
    }

    .mt-1 {
        margin-top: 8px;
    }

    .mt-2 {
        margin-top: 16px;
    }

    .mt-3 {
        margin-top: 24px;
    }

    .mt-4 {
        margin-top: 32px;
    }

    .text-muted {
        color: var(--light-muted);
    }

    body.dark-mode .text-muted {
        color: var(--dark-muted);
    }

    .text-success {
        color: var(--success);
    }

    .text-danger {
        color: var(--danger);
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--light-border);
    }

    body.dark-mode .page-header {
        border-bottom: 1px solid var(--dark-border);
    }

    .page-title h1 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 4px 0;
        color: var(--light-text);
    }

    body.dark-mode .page-title h1 {
        color: var(--dark-text);
    }

    .page-title p {
        margin: 0;
        color: var(--light-muted);
    }

    body.dark-mode .page-title p {
        color: var(--dark-muted);
    }

    .page-actions {
        display: flex;
        gap: 12px;
    }

    /* Cards */
    .card {
        background-color: var(--light-card);
        border: 1px solid var(--light-border);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    body.dark-mode .card {
        background-color: var(--dark-card);
        border-color: var(--dark-border);
    }

    .card-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--light-border);
        background-color: rgba(0, 0, 0, 0.02);
    }

    body.dark-mode .card-header {
        border-bottom-color: var(--dark-border);
        background-color: rgba(255, 255, 255, 0.02);
    }

    .card-header h3 {
        margin: 0;
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--light-text);
    }

    body.dark-mode .card-header h3 {
        color: var(--dark-text);
    }

    .card-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-body {
        padding: 24px;
    }

    /* Compact filter card used on index pages */
    .filter-card .card-body {
        padding: 14px 18px;
    }

    .filter-card .form-label {
        margin-bottom: 6px;
        font-size: 0.875rem;
    }

    .filter-card .form-control,
    .filter-card .form-select {
        padding: 8px 10px;
        font-size: 0.875rem;
    }

    .filter-card .row.g-3>[class*='col-'] {
        margin-bottom: 8px;
    }

    .filter-card .card-header {
        padding: 10px 18px;
    }

    /* Inline filter form layout */
    .filter-form {
        gap: 12px;
    }

    .filter-item {
        display: flex;
        flex-direction: column;
        min-width: 120px;
    }

    .filter-actions {
        display: flex;
        align-items: center;
    }

    @media (max-width: 768px) {
        .filter-form {
            gap: 8px;
        }

        .filter-item {
            min-width: 100%;
        }

        .filter-actions {
            width: 100%;
        }
    }

    /* Match inquiries-style filter layout: wide search, inline selects, actions on separate row */
    .filter-form {
        align-items: flex-start;
    }

    .filter-item {
        margin-right: 18px;
    }

    .filter-item label {
        margin-bottom: 6px;
    }

    .filter-item input.form-control[type="text"] {
        min-width: 420px;
    }

    /* More specific rules to override inline widths and bootstrap utilities */
    .filter-card .filter-form {
        display: flex;
        align-items: flex-end;
        gap: 18px;
        flex-wrap: wrap;
    }

    /* Search should grow to fill space */
    .filter-card .filter-form .filter-item:first-child {
        flex: 1 1 480px;
        min-width: 260px;
    }

    /* Ensure selects remain compact even when inline styles exist */
    .filter-card .filter-form .filter-item .form-select {
        width: 220px !important;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* Make the action buttons sit on a separate row under the search input */
    .filter-card .filter-form .filter-actions {
        flex-basis: 100%;
        margin-top: 14px;
        display: flex;
        justify-content: flex-start;
    }

    /* On smaller screens, stack controls */
    @media (max-width: 768px) {
        .filter-card .filter-form .filter-item:first-child {
            min-width: 100%;
        }

        .filter-card .filter-form .filter-item .form-select {
            width: 100% !important;
        }

        .filter-card .filter-form .filter-actions {
            justify-content: flex-start;
        }
    }

    /* Make the filter form flexible: search expands, selects remain compact */
    .filter-form {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    /* Treat the first filter-item as the main search field and allow it to grow */
    .filter-form .filter-item:first-child {
        flex: 1 1 480px;
        min-width: 280px;
    }

    /* Keep select controls compact and consistent */
    .filter-form .filter-item .form-select {
        width: 220px;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* Make actions occupy full width under controls (like inquiries layout) */
    .filter-actions {
        flex-basis: 100%;
        margin-top: 12px;
    }

    /* Tighten button position to align with left edge of form */
    .filter-actions .btn {
        min-width: 100px;
    }

    @media (max-width: 1200px) {
        .filter-item input.form-control[type="text"] {
            min-width: 320px;
        }
    }

    @media (max-width: 768px) {
        .filter-form .filter-item .form-select {
            width: 100%;
        }

        .filter-form .filter-item:first-child {
            min-width: 100%;
        }
    }

    /* Product form specific polish */
    .product-form .card {
        border-radius: 10px;
    }

    .product-form .card+.card {
        margin-top: 0.75rem;
    }

    .product-form .card-body {
        padding: 14px;
    }

    /* Make sidebar sticky and visually separate */
    .product-form .col-lg-4 {
        display: flex;
        flex-direction: column;
    }

    .product-form .col-lg-4>.card {
        flex: 0 0 auto;
    }

    .product-form .col-lg-4 {
        gap: 12px;
    }

    @media (min-width: 992px) {
        .product-form .col-lg-4 {
            position: sticky;
            top: 90px;
            align-self: flex-start;
        }
    }

    /* Align action buttons and add spacing */
    .product-form .card.mt-4 .btn-group {
        gap: 8px;
    }

    .product-form .card.mt-4 .btn {
        min-width: 120px;
    }

    /* Tech stack tags styling */
    .product-form #tech-stack-tags span.badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 10px;
        font-size: 0.85rem;
    }

    /* Make tech-stack tags look like pills with subtle border/background and a small close button */
    .product-form #tech-stack-tags .badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 10px;
        font-size: 0.9rem;
        border-radius: 6px;
        border: 1px solid rgba(59, 130, 246, 0.12);
        background: rgba(59, 130, 246, 0.04);
        color: var(--primary);
        font-weight: 600;
        margin-right: 8px;
        margin-bottom: 8px;
    }

    .product-form #tech-stack-tags .badge .btn-close {
        background: transparent;
        border: none;
        width: 18px;
        height: 18px;
        padding: 0;
        margin-left: 6px;
        opacity: 0.9;
    }

    .product-form #tech-stack-tags .tag-remove {
        background: transparent;
        border: none;
        font-size: 14px;
        line-height: 1;
        margin-left: 8px;
        color: rgba(0, 0, 0, 0.6);
        cursor: pointer;
        padding: 0 6px;
        border-radius: 4px;
    }

    .product-form #tech-stack-tags .tag-remove:hover {
        background: rgba(0, 0, 0, 0.03);
        color: rgba(0, 0, 0, 0.9);
    }

    .product-form #tech-stack-tags input[type="hidden"] {
        display: none !important;
    }

    /* Reduce large margins inside product-form for compact layout */
    .product-form .mb-3 {
        margin-bottom: 8px;
    }

    /* Tighter form controls for product form */
    .product-form .form-label {
        margin-bottom: 6px;
    }

    .product-form .form-control,
    .product-form .form-select,
    .product-form textarea.form-control {
        padding: 8px 10px;
        font-size: 0.92rem;
        height: 40px;
    }

    /* Ensure selects behave like inputs and fill their columns */
    .product-form .form-select {
        width: 100%;
        box-sizing: border-box;
    }

    .product-form textarea.form-control {
        height: auto;
        padding-top: 8px;
        padding-bottom: 8px;
    }

    .product-form .form-control:focus,
    .product-form .form-select:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.06);
    }

    @media (max-width: 991px) {
        .product-form .card-body {
            padding: 14px;
        }

        .product-form .col-lg-8,
        .product-form .col-lg-4 {
            width: 100%;
        }

        .product-form .col-lg-4 {
            position: static;
        }
    }

    /* Ensure inputs take full width and labels are aligned */
    .product-form .form-group,
    .product-form .mb-3 {
        width: 100%;
        display: block;
    }

    .product-form .form-label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .product-form .form-control {
        width: 100%;
        box-sizing: border-box;
    }

    .product-form textarea.form-control {
        min-height: 120px;
        height: auto;
    }

    /* Page header tweaks for consistency */
    .page-header {
        margin-bottom: 18px;
    }

    .page-header .page-header-content {
        display: inline-block;
        vertical-align: middle;
    }

    .page-header .page-header-actions {
        float: right;
        margin-top: 6px;
    }

    @media (max-width: 991px) {
        .page-header .page-header-actions {
            float: none;
            margin-top: 12px;
        }
    }

    /* Forms */
    .form {
        max-width: none;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--light-text);
        font-size: 0.875rem;
    }

    body.dark-mode .form-label {
        color: var(--dark-text);
    }

    .form-control {
        padding: 10px 12px;
        border: 1px solid var(--light-border);
        border-radius: var(--border-radius);
        background-color: var(--light-card);
        color: var(--light-text);
        font-size: 0.875rem;
        transition: var(--transition);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    body.dark-mode .form-control {
        background-color: var(--dark-card);
        border-color: var(--dark-border);
        color: var(--dark-text);
    }

    .form-select {
        padding: 10px 12px;
        border: 1px solid var(--light-border);
        border-radius: var(--border-radius);
        background-color: var(--light-card);
        color: var(--light-text);
        font-size: 0.875rem;
        transition: var(--transition);
        cursor: pointer;
    }

    .form-select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    body.dark-mode .form-select {
        background-color: var(--dark-card);
        border-color: var(--dark-border);
        color: var(--dark-text);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 32px;
        padding-top: 20px;
        border-top: 1px solid var(--light-border);
    }

    body.dark-mode .form-actions {
        border-top-color: var(--dark-border);
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        cursor: pointer;
        font-size: 0.875rem;
        color: var(--light-text);
    }

    body.dark-mode .checkbox-label {
        color: var(--dark-text);
    }

    .checkbox-label input[type="checkbox"] {
        margin-right: 8px;
    }

    /* Status Badges */
    .status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }

    .status-active,
    .status-paid,
    .status-published {
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }

    .status-pending,
    .status-draft {
        background-color: rgba(245, 158, 11, 0.1);
        color: var(--warning);
    }

    .status-inactive,
    .status-failed,
    .status-cancelled {
        background-color: rgba(239, 68, 68, 0.1);
        color: var(--danger);
    }

    .status-admin {
        background-color: rgba(139, 92, 246, 0.1);
        color: var(--secondary);
    }

    .status-developer {
        background-color: rgba(59, 130, 246, 0.1);
        color: var(--primary);
    }

    .status-client {
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }

    /* Buttons */
    .btn {
        padding: 10px 20px;
        border-radius: var(--border-radius);
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: var(--transition);
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        box-shadow: var(--shadow);
    }

    .btn-secondary {
        background-color: transparent;
        color: var(--primary);
        border: 1px solid var(--primary);
    }

    .btn-secondary:hover {
        background-color: var(--primary);
        color: white;
    }

    .btn-danger {
        background-color: var(--danger);
        color: white;
    }

    .btn-danger:hover {
        background-color: #dc2626;
        box-shadow: var(--shadow);
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 0.75rem;
    }

    /* Tables */
    .table-responsive {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        padding: 16px;
        text-align: left;
        font-weight: 600;
        color: var(--light-muted);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 1px solid var(--light-border);
    }

    body.dark-mode .data-table th {
        color: var(--dark-muted);
        border-bottom-color: var(--dark-border);
    }

    .data-table td {
        padding: 16px;
        border-bottom: 1px solid var(--light-border);
    }

    body.dark-mode .data-table td {
        border-bottom-color: var(--dark-border);
    }

    .data-table tr:last-child td {
        border-bottom: none;
    }

    .data-table tr:hover {
        background-color: rgba(0, 0, 0, 0.01);
    }

    body.dark-mode .data-table tr:hover {
        background-color: rgba(255, 255, 255, 0.01);
    }

    /* User Cells */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-placeholder {
        width: 100%;
        height: 100%;
        background-color: var(--light-border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--light-muted);
        font-weight: 600;
        font-size: 1rem;
    }

    body.dark-mode .avatar-placeholder {
        background-color: var(--dark-border);
        color: var(--dark-muted);
    }

    .user-info {
        min-width: 0;
    }

    .user-info .user-name {
        font-weight: 600;
        color: var(--light-text);
        margin-bottom: 2px;
        font-size: 0.875rem;
    }

    body.dark-mode .user-info .user-name {
        color: var(--dark-text);
    }

    .user-info .user-email {
        color: var(--light-muted);
        font-size: 0.75rem;
    }

    body.dark-mode .user-info .user-email {
        color: var(--dark-muted);
    }

    /* User Profile */
    .user-profile {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .user-avatar-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
    }

    .user-avatar-large img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-placeholder-large {
        width: 100%;
        height: 100%;
        background-color: var(--light-border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--light-muted);
        font-weight: 600;
        font-size: 2rem;
    }

    body.dark-mode .avatar-placeholder-large {
        background-color: var(--dark-border);
        color: var(--dark-muted);
    }

    .user-details {
        flex: 1;
    }

    .user-details .user-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--light-text);
        margin: 0 0 4px 0;
    }

    body.dark-mode .user-details .user-name {
        color: var(--dark-text);
    }

    .user-details .user-email {
        color: var(--light-text);
        margin: 0 0 4px 0;
        font-size: 1rem;
    }

    body.dark-mode .user-details .user-email {
        color: var(--dark-text);
    }

    .user-details .user-username {
        color: var(--light-muted);
        margin: 0 0 12px 0;
        font-size: 0.875rem;
    }

    body.dark-mode .user-details .user-username {
        color: var(--dark-muted);
    }

    .user-meta {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    /* Info Lists */
    .info-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    body.dark-mode .info-item {
        border-bottom-color: rgba(255, 255, 255, 0.05);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 500;
        color: var(--light-muted);
        font-size: 0.875rem;
    }

    body.dark-mode .info-label {
        color: var(--dark-muted);
    }

    .info-value {
        font-weight: 600;
        color: var(--light-text);
        font-size: 0.875rem;
    }

    body.dark-mode .info-value {
        color: var(--dark-text);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 16px;
    }

    .stat-item {
        text-align: center;
        padding: 20px;
        background-color: rgba(0, 0, 0, 0.02);
        border-radius: var(--border-radius);
    }

    body.dark-mode .stat-item {
        background-color: rgba(255, 255, 255, 0.02);
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--light-text);
        display: block;
        margin-bottom: 4px;
    }

    body.dark-mode .stat-value {
        color: var(--dark-text);
    }

    .stat-label {
        color: var(--light-muted);
        font-size: 0.875rem;
        font-weight: 500;
    }

    body.dark-mode .stat-label {
        color: var(--dark-muted);
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
    }

    /* Align bulk action controls vertically center inside card */
    .card>.card-body .row.align-items-center {
        align-items: center;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--light-muted);
    }

    body.dark-mode .empty-state {
        color: var(--dark-muted);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--light-text);
    }

    body.dark-mode .empty-state h3 {
        color: var(--dark-text);
    }

    .empty-state p {
        margin-bottom: 24px;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 24px;
    }

    .pagination {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .page-item {
        margin: 0;
    }

    .page-item:first-child .page-link {
        border-top-left-radius: var(--border-radius);
        border-bottom-left-radius: var(--border-radius);
    }

    .page-item:last-child .page-link {
        border-top-right-radius: var(--border-radius);
        border-bottom-right-radius: var(--border-radius);
    }

    .page-link {
        display: block;
        padding: 8px 12px;
        color: var(--light-text);
        text-decoration: none;
        background-color: var(--light-card);
        border: 1px solid var(--light-border);
        transition: var(--transition);
        font-weight: 500;
        min-width: 40px;
        text-align: center;
    }

    body.dark-mode .page-link {
        color: var(--dark-text);
        background-color: var(--dark-card);
        border-color: var(--dark-border);
    }

    .page-link:hover {
        color: var(--primary);
        background-color: rgba(59, 130, 246, 0.05);
        border-color: rgba(59, 130, 246, 0.2);
    }

    body.dark-mode .page-link:hover {
        background-color: rgba(59, 130, 246, 0.1);
        border-color: rgba(59, 130, 246, 0.3);
    }

    .page-item.active .page-link {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
        font-weight: 600;
    }

    .page-item.disabled .page-link {
        color: var(--light-muted);
        background-color: var(--light-sidebar);
        border-color: var(--light-border);
        cursor: not-allowed;
    }

    body.dark-mode .page-item.disabled .page-link {
        color: var(--dark-muted);
        background-color: var(--dark-sidebar);
        border-color: var(--dark-border);
    }

    @media (max-width: 768px) {
        .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }

        .page-link {
            padding: 6px 8px;
            font-size: 0.875rem;
        }

        .page-item:not(.active):not(:first-child):not(:last-child) {
            display: none;
        }
    }

    /* Filters */
    .filters-form {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        align-items: flex-end;
    }

    .filters-form .form-group {
        flex: 1;
        min-width: 200px;
    }

    .filters-form .form-group:first-child {
        flex: 2;
        min-width: 300px;
    }

    .filters-form .form-group:last-child {
        flex: none;
        min-width: auto;
    }

    .search-input {
        min-width: 300px;
    }

    .filter-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    @media (max-width: 768px) {
        .filters-form {
            flex-direction: column;
            align-items: stretch;
        }

        .filters-form .form-group {
            flex: none;
            min-width: auto;
        }

        .search-input {
            min-width: auto;
        }

        .filter-actions {
            justify-content: flex-start;
            margin-top: 8px;
        }
    }

    /* Grid Utilities */
    .grid {
        display: grid;
        gap: 24px;
    }

    .grid-cols-2 {
        grid-template-columns: repeat(2, 1fr);
    }

    @media (max-width: 768px) {
        .grid-cols-2 {
            grid-template-columns: 1fr;
        }
    }

    .grid-cols-3 {
        grid-template-columns: repeat(3, 1fr);
    }

    @media (max-width: 1024px) {
        .grid-cols-3 {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .grid-cols-3 {
            grid-template-columns: 1fr;
        }
    }

    .col-span-2 {
        grid-column: span 2;
    }

    .col-span-3 {
        grid-column: span 3;
    }

    .gap-6 {
        gap: 1.5rem;
    }

    /* Inline Form */
    .inline-form {
        display: inline;
    }

    /* Alerts */
    .alert {
        padding: 12px 16px;
        border-radius: var(--border-radius);
        margin-bottom: 20px;
        font-size: 0.875rem;
    }

    .alert-success {
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--success);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .alert-danger {
        background-color: rgba(239, 68, 68, 0.1);
        color: var(--danger);
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .alert ul {
        margin: 8px 0 0 0;
        padding-left: 20px;
    }

    .alert li {
        margin-bottom: 4px;
    }

    /* Inquiries Page Styles */
    .stats-summary {
        display: flex;
        gap: 24px;
        align-items: center;
    }

    .stat-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 8px 16px;
        background-color: rgba(0, 0, 0, 0.02);
        border-radius: var(--border-radius);
        min-width: 60px;
    }

    body.dark-mode .stat-item {
        background-color: rgba(255, 255, 255, 0.02);
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--light-text);
        line-height: 1;
    }

    body.dark-mode .stat-value {
        color: var(--dark-text);
    }

    .stat-label {
        font-size: 0.75rem;
        color: var(--light-muted);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 2px;
    }

    body.dark-mode .stat-label {
        color: var(--dark-muted);
    }

    /* Inquiry Table Styles */
    .inquiry-checkbox {
        margin-right: 12px;
    }

    .contact-name {
        font-weight: 600;
        color: var(--light-text);
    }

    body.dark-mode .contact-name {
        color: var(--dark-text);
    }

    .contact-email {
        color: var(--light-muted);
        font-size: 0.875rem;
    }

    body.dark-mode .contact-email {
        color: var(--dark-muted);
    }

    .contact-company {
        color: var(--light-muted);
        font-size: 0.75rem;
        font-style: italic;
    }

    body.dark-mode .contact-company {
        color: var(--dark-muted);
    }

    .unread-row {
        background-color: rgba(59, 130, 246, 0.05);
    }

    body.dark-mode .unread-row {
        background-color: rgba(59, 130, 246, 0.1);
    }

    .new-badge {
        background-color: var(--danger);
        color: white;
        padding: 2px 6px;
        border-radius: 10px;
        font-size: 0.7rem;
        font-weight: 600;
        margin-left: 8px;
    }

    .subject-cell {
        display: flex;
        align-items: center;
    }

    .subject-text {
        flex: 1;
    }

    .type-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .type-general {
        background-color: rgba(156, 163, 175, 0.1);
        color: #6b7280;
    }

    .type-service {
        background-color: rgba(59, 130, 246, 0.1);
        color: var(--primary);
    }

    .type-support {
        background-color: rgba(245, 158, 11, 0.1);
        color: var(--warning);
    }

    .type-partnership {
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }

    .assignee-name {
        color: var(--light-text);
        font-weight: 500;
    }

    body.dark-mode .assignee-name {
        color: var(--dark-text);
    }

    /* Contact Cell Styles */
    .contact-cell {
        display: flex;
        align-items: center;
    }

    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .contact-name {
        font-weight: 600;
        color: var(--light-text);
        font-size: 0.875rem;
    }

    body.dark-mode .contact-name {
        color: var(--dark-text);
    }

    .contact-email {
        color: var(--light-muted);
        font-size: 0.75rem;
    }

    body.dark-mode .contact-email {
        color: var(--dark-muted);
    }

    .contact-company {
        color: var(--light-muted);
        font-size: 0.7rem;
        font-style: italic;
    }

    body.dark-mode .contact-company {
        color: var(--dark-muted);
    }

    /* Bulk Actions Styles */
    .bulk-actions-container {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .bulk-action-select,
    .assign-user-select {
        width: auto;
        min-width: 120px;
    }

    .assign-user-select {
        display: none;
    }

    @media (max-width: 768px) {
        .bulk-actions-container {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .bulk-action-select,
        .assign-user-select {
            width: 100%;
        }
    }

    /* Handmade Modal Styles (Custom) */
    .handmade-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1000;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .handmade-modal-backdrop {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .handmade-modal-content {
        background-color: var(--light-card);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-xl);
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        z-index: 1001;
        margin: 20px;
        position: relative;
    }

    body.dark-mode .handmade-modal-content {
        background-color: var(--dark-card);
    }

    .handmade-modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--light-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    body.dark-mode .handmade-modal-header {
        border-bottom: 1px solid var(--dark-border);
    }

    .handmade-modal-header h3 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .handmade-modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: var(--light-muted);
        cursor: pointer;
        padding: 0;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
    }

    .handmade-modal-close:hover {
        background-color: rgba(0, 0, 0, 0.05);
        color: var(--light-text);
    }

    body.dark-mode .handmade-modal-close:hover {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .handmade-modal-body {
        padding: 24px;
    }

    .handmade-modal-footer {
        padding: 16px 24px 24px;
        border-top: 1px solid var(--light-border);
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    body.dark-mode .handmade-modal-footer {
        border-top: 1px solid var(--dark-border);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--light-muted);
    }

    body.dark-mode .empty-state {
        color: var(--dark-muted);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--light-text);
    }

    body.dark-mode .empty-state h3 {
        color: var(--dark-text);
    }

    .empty-state p {
        margin: 0;
        font-size: 0.875rem;
    }

    /* Status Badges Container */
    .status-badges {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    /* extra */

    /* Row and Column Grid System */
    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    /* Clearfix for rows */
    .row::after {
        content: "";
        display: table;
        clear: both;
    }

    /* Column base styles */
    [class*="col-"] {
        position: relative;
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        box-sizing: border-box;
    }

    /* Extra Small Devices (phones, less than 576px) */
    .col-1 {
        flex: 0 0 8.333333%;
        max-width: 8.333333%;
    }

    .col-2 {
        flex: 0 0 16.666667%;
        max-width: 16.666667%;
    }

    .col-3 {
        flex: 0 0 25%;
        max-width: 25%;
    }

    .col-4 {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }

    .col-5 {
        flex: 0 0 41.666667%;
        max-width: 41.666667%;
    }

    .col-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }

    .col-7 {
        flex: 0 0 58.333333%;
        max-width: 58.333333%;
    }

    .col-8 {
        flex: 0 0 66.666667%;
        max-width: 66.666667%;
    }

    .col-9 {
        flex: 0 0 75%;
        max-width: 75%;
    }

    .col-10 {
        flex: 0 0 83.333333%;
        max-width: 83.333333%;
    }

    .col-11 {
        flex: 0 0 91.666667%;
        max-width: 91.666667%;
    }

    .col-12 {
        flex: 0 0 100%;
        max-width: 100%;
    }

    /* Small devices (tablets, 576px and up) */
    @media (min-width: 576px) {
        .col-sm-1 {
            flex: 0 0 8.333333%;
            max-width: 8.333333%;
        }

        .col-sm-2 {
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }

        .col-sm-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }

        .col-sm-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .col-sm-5 {
            flex: 0 0 41.666667%;
            max-width: 41.666667%;
        }

        .col-sm-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-sm-7 {
            flex: 0 0 58.333333%;
            max-width: 58.333333%;
        }

        .col-sm-8 {
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
        }

        .col-sm-9 {
            flex: 0 0 75%;
            max-width: 75%;
        }

        .col-sm-10 {
            flex: 0 0 83.333333%;
            max-width: 83.333333%;
        }

        .col-sm-11 {
            flex: 0 0 91.666667%;
            max-width: 91.666667%;
        }

        .col-sm-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    /* Medium devices (tablets, 768px and up) */
    @media (min-width: 768px) {
        .col-md-1 {
            flex: 0 0 8.333333%;
            max-width: 8.333333%;
        }

        .col-md-2 {
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }

        .col-md-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }

        .col-md-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .col-md-5 {
            flex: 0 0 41.666667%;
            max-width: 41.666667%;
        }

        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-md-7 {
            flex: 0 0 58.333333%;
            max-width: 58.333333%;
        }

        .col-md-8 {
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
        }

        .col-md-9 {
            flex: 0 0 75%;
            max-width: 75%;
        }

        .col-md-10 {
            flex: 0 0 83.333333%;
            max-width: 83.333333%;
        }

        .col-md-11 {
            flex: 0 0 91.666667%;
            max-width: 91.666667%;
        }

        .col-md-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    /* Large devices (desktops, 992px and up) */
    @media (min-width: 992px) {
        .col-lg-1 {
            flex: 0 0 8.333333%;
            max-width: 8.333333%;
        }

        .col-lg-2 {
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }

        .col-lg-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }

        .col-lg-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .col-lg-5 {
            flex: 0 0 41.666667%;
            max-width: 41.666667%;
        }

        .col-lg-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-lg-7 {
            flex: 0 0 58.333333%;
            max-width: 58.333333%;
        }

        .col-lg-8 {
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
        }

        .col-lg-9 {
            flex: 0 0 75%;
            max-width: 75%;
        }

        .col-lg-10 {
            flex: 0 0 83.333333%;
            max-width: 83.333333%;
        }

        .col-lg-11 {
            flex: 0 0 91.666667%;
            max-width: 91.666667%;
        }

        .col-lg-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    /* Extra large devices (large desktops, 1200px and up) */
    @media (min-width: 1200px) {
        .col-xl-1 {
            flex: 0 0 8.333333%;
            max-width: 8.333333%;
        }

        .col-xl-2 {
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }

        .col-xl-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }

        .col-xl-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .col-xl-5 {
            flex: 0 0 41.666667%;
            max-width: 41.666667%;
        }

        .col-xl-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-xl-7 {
            flex: 0 0 58.333333%;
            max-width: 58.333333%;
        }

        .col-xl-8 {
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
        }

        .col-xl-9 {
            flex: 0 0 75%;
            max-width: 75%;
        }

        .col-xl-10 {
            flex: 0 0 83.333333%;
            max-width: 83.333333%;
        }

        .col-xl-11 {
            flex: 0 0 91.666667%;
            max-width: 91.666667%;
        }

        .col-xl-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    /* XX-Large devices (larger desktops, 1400px and up) */
    @media (min-width: 1400px) {
        .col-xxl-1 {
            flex: 0 0 8.333333%;
            max-width: 8.333333%;
        }

        .col-xxl-2 {
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }

        .col-xxl-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }

        .col-xxl-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .col-xxl-5 {
            flex: 0 0 41.666667%;
            max-width: 41.666667%;
        }

        .col-xxl-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-xxl-7 {
            flex: 0 0 58.333333%;
            max-width: 58.333333%;
        }

        .col-xxl-8 {
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
        }

        .col-xxl-9 {
            flex: 0 0 75%;
            max-width: 75%;
        }

        .col-xxl-10 {
            flex: 0 0 83.333333%;
            max-width: 83.333333%;
        }

        .col-xxl-11 {
            flex: 0 0 91.666667%;
            max-width: 91.666667%;
        }

        .col-xxl-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    /* Column offset classes */
    .offset-1 {
        margin-left: 8.333333%;
    }

    .offset-2 {
        margin-left: 16.666667%;
    }

    .offset-3 {
        margin-left: 25%;
    }

    .offset-4 {
        margin-left: 33.333333%;
    }

    .offset-5 {
        margin-left: 41.666667%;
    }

    .offset-6 {
        margin-left: 50%;
    }

    .offset-7 {
        margin-left: 58.333333%;
    }

    .offset-8 {
        margin-left: 66.666667%;
    }

    .offset-9 {
        margin-left: 75%;
    }

    .offset-10 {
        margin-left: 83.333333%;
    }

    .offset-11 {
        margin-left: 91.666667%;
    }

    /* Responsive offset classes */
    @media (min-width: 576px) {
        .offset-sm-0 {
            margin-left: 0;
        }

        .offset-sm-1 {
            margin-left: 8.333333%;
        }

        .offset-sm-2 {
            margin-left: 16.666667%;
        }

        .offset-sm-3 {
            margin-left: 25%;
        }

        .offset-sm-4 {
            margin-left: 33.333333%;
        }

        .offset-sm-5 {
            margin-left: 41.666667%;
        }

        .offset-sm-6 {
            margin-left: 50%;
        }

        .offset-sm-7 {
            margin-left: 58.333333%;
        }

        .offset-sm-8 {
            margin-left: 66.666667%;
        }

        .offset-sm-9 {
            margin-left: 75%;
        }

        .offset-sm-10 {
            margin-left: 83.333333%;
        }

        .offset-sm-11 {
            margin-left: 91.666667%;
        }
    }

    @media (min-width: 768px) {
        .offset-md-0 {
            margin-left: 0;
        }

        .offset-md-1 {
            margin-left: 8.333333%;
        }

        .offset-md-2 {
            margin-left: 16.666667%;
        }

        .offset-md-3 {
            margin-left: 25%;
        }

        .offset-md-4 {
            margin-left: 33.333333%;
        }

        .offset-md-5 {
            margin-left: 41.666667%;
        }

        .offset-md-6 {
            margin-left: 50%;
        }

        .offset-md-7 {
            margin-left: 58.333333%;
        }

        .offset-md-8 {
            margin-left: 66.666667%;
        }

        .offset-md-9 {
            margin-left: 75%;
        }

        .offset-md-10 {
            margin-left: 83.333333%;
        }

        .offset-md-11 {
            margin-left: 91.666667%;
        }
    }

    @media (min-width: 992px) {
        .offset-lg-0 {
            margin-left: 0;
        }

        .offset-lg-1 {
            margin-left: 8.333333%;
        }

        .offset-lg-2 {
            margin-left: 16.666667%;
        }

        .offset-lg-3 {
            margin-left: 25%;
        }

        .offset-lg-4 {
            margin-left: 33.333333%;
        }

        .offset-lg-5 {
            margin-left: 41.666667%;
        }

        .offset-lg-6 {
            margin-left: 50%;
        }

        .offset-lg-7 {
            margin-left: 58.333333%;
        }

        .offset-lg-8 {
            margin-left: 66.666667%;
        }

        .offset-lg-9 {
            margin-left: 75%;
        }

        .offset-lg-10 {
            margin-left: 83.333333%;
        }

        .offset-lg-11 {
            margin-left: 91.666667%;
        }
    }

    @media (min-width: 1200px) {
        .offset-xl-0 {
            margin-left: 0;
        }

        .offset-xl-1 {
            margin-left: 8.333333%;
        }

        .offset-xl-2 {
            margin-left: 16.666667%;
        }

        .offset-xl-3 {
            margin-left: 25%;
        }

        .offset-xl-4 {
            margin-left: 33.333333%;
        }

        .offset-xl-5 {
            margin-left: 41.666667%;
        }

        .offset-xl-6 {
            margin-left: 50%;
        }

        .offset-xl-7 {
            margin-left: 58.333333%;
        }

        .offset-xl-8 {
            margin-left: 66.666667%;
        }

        .offset-xl-9 {
            margin-left: 75%;
        }

        .offset-xl-10 {
            margin-left: 83.333333%;
        }

        .offset-xl-11 {
            margin-left: 91.666667%;
        }
    }

    /* Order classes */
    .order-first {
        order: -1;
    }

    .order-last {
        order: 13;
    }

    .order-0 {
        order: 0;
    }

    .order-1 {
        order: 1;
    }

    .order-2 {
        order: 2;
    }

    .order-3 {
        order: 3;
    }

    .order-4 {
        order: 4;
    }

    .order-5 {
        order: 5;
    }

    .order-6 {
        order: 6;
    }

    .order-7 {
        order: 7;
    }

    .order-8 {
        order: 8;
    }

    .order-9 {
        order: 9;
    }

    .order-10 {
        order: 10;
    }

    .order-11 {
        order: 11;
    }

    .order-12 {
        order: 12;
    }

    /* Responsive order classes */
    @media (min-width: 576px) {
        .order-sm-first {
            order: -1;
        }

        .order-sm-last {
            order: 13;
        }

        .order-sm-0 {
            order: 0;
        }

        .order-sm-1 {
            order: 1;
        }

        .order-sm-2 {
            order: 2;
        }

        .order-sm-3 {
            order: 3;
        }

        .order-sm-4 {
            order: 4;
        }

        .order-sm-5 {
            order: 5;
        }

        .order-sm-6 {
            order: 6;
        }

        .order-sm-7 {
            order: 7;
        }

        .order-sm-8 {
            order: 8;
        }

        .order-sm-9 {
            order: 9;
        }

        .order-sm-10 {
            order: 10;
        }

        .order-sm-11 {
            order: 11;
        }

        .order-sm-12 {
            order: 12;
        }
    }

    @media (min-width: 768px) {
        .order-md-first {
            order: -1;
        }

        .order-md-last {
            order: 13;
        }

        .order-md-0 {
            order: 0;
        }

        .order-md-1 {
            order: 1;
        }

        .order-md-2 {
            order: 2;
        }

        .order-md-3 {
            order: 3;
        }

        .order-md-4 {
            order: 4;
        }

        .order-md-5 {
            order: 5;
        }

        .order-md-6 {
            order: 6;
        }

        .order-md-7 {
            order: 7;
        }

        .order-md-8 {
            order: 8;
        }

        .order-md-9 {
            order: 9;
        }

        .order-md-10 {
            order: 10;
        }

        .order-md-11 {
            order: 11;
        }

        .order-md-12 {
            order: 12;
        }
    }

    @media (min-width: 992px) {
        .order-lg-first {
            order: -1;
        }

        .order-lg-last {
            order: 13;
        }

        .order-lg-0 {
            order: 0;
        }

        .order-lg-1 {
            order: 1;
        }

        .order-lg-2 {
            order: 2;
        }

        .order-lg-3 {
            order: 3;
        }

        .order-lg-4 {
            order: 4;
        }

        .order-lg-5 {
            order: 5;
        }

        .order-lg-6 {
            order: 6;
        }

        .order-lg-7 {
            order: 7;
        }

        .order-lg-8 {
            order: 8;
        }

        .order-lg-9 {
            order: 9;
        }

        .order-lg-10 {
            order: 10;
        }

        .order-lg-11 {
            order: 11;
        }

        .order-lg-12 {
            order: 12;
        }
    }

    @media (min-width: 1200px) {
        .order-xl-first {
            order: -1;
        }

        .order-xl-last {
            order: 13;
        }

        .order-xl-0 {
            order: 0;
        }

        .order-xl-1 {
            order: 1;
        }

        .order-xl-2 {
            order: 2;
        }

        .order-xl-3 {
            order: 3;
        }

        .order-xl-4 {
            order: 4;
        }

        .order-xl-5 {
            order: 5;
        }

        .order-xl-6 {
            order: 6;
        }

        .order-xl-7 {
            order: 7;
        }

        .order-xl-8 {
            order: 8;
        }

        .order-xl-9 {
            order: 9;
        }

        .order-xl-10 {
            order: 10;
        }

        .order-xl-11 {
            order: 11;
        }

        .order-xl-12 {
            order: 12;
        }
    }

    /* Column auto sizing */
    .col-auto {
        flex: 0 0 auto;
        width: auto;
        max-width: 100%;
    }

    /* Responsive column auto sizing */
    @media (min-width: 576px) {
        .col-sm-auto {
            flex: 0 0 auto;
            width: auto;
            max-width: 100%;
        }
    }

    @media (min-width: 768px) {
        .col-md-auto {
            flex: 0 0 auto;
            width: auto;
            max-width: 100%;
        }
    }

    @media (min-width: 992px) {
        .col-lg-auto {
            flex: 0 0 auto;
            width: auto;
            max-width: 100%;
        }
    }

    @media (min-width: 1200px) {
        .col-xl-auto {
            flex: 0 0 auto;
            width: auto;
            max-width: 100%;
        }
    }

    /* No gutters */
    .no-gutters {
        margin-right: 0;
        margin-left: 0;
    }

    .no-gutters>[class*="col-"] {
        padding-right: 0;
        padding-left: 0;
    }

    /* Alignment classes */
    .align-items-start {
        align-items: flex-start;
    }

    .align-items-center {
        align-items: center;
    }

    .align-items-end {
        align-items: flex-end;
    }

    .align-items-stretch {
        align-items: stretch;
    }

    .align-items-baseline {
        align-items: baseline;
    }

    .justify-content-start {
        justify-content: flex-start;
    }

    .justify-content-center {
        justify-content: center;
    }

    .justify-content-end {
        justify-content: flex-end;
    }

    .justify-content-between {
        justify-content: space-between;
    }

    .justify-content-around {
        justify-content: space-around;
    }

    .justify-content-evenly {
        justify-content: space-evenly;
    }

    /* Responsive alignment */
    @media (min-width: 576px) {
        .align-items-sm-start {
            align-items: flex-start;
        }

        .align-items-sm-center {
            align-items: center;
        }

        .align-items-sm-end {
            align-items: flex-end;
        }

        .align-items-sm-stretch {
            align-items: stretch;
        }

        .align-items-sm-baseline {
            align-items: baseline;
        }

        .justify-content-sm-start {
            justify-content: flex-start;
        }

        .justify-content-sm-center {
            justify-content: center;
        }

        .justify-content-sm-end {
            justify-content: flex-end;
        }

        .justify-content-sm-between {
            justify-content: space-between;
        }

        .justify-content-sm-around {
            justify-content: space-around;
        }

        .justify-content-sm-evenly {
            justify-content: space-evenly;
        }
    }

    @media (min-width: 768px) {
        .align-items-md-start {
            align-items: flex-start;
        }

        .align-items-md-center {
            align-items: center;
        }

        .align-items-md-end {
            align-items: flex-end;
        }

        .align-items-md-stretch {
            align-items: stretch;
        }

        .align-items-md-baseline {
            align-items: baseline;
        }

        .justify-content-md-start {
            justify-content: flex-start;
        }

        .justify-content-md-center {
            justify-content: center;
        }

        .justify-content-md-end {
            justify-content: flex-end;
        }

        .justify-content-md-between {
            justify-content: space-between;
        }

        .justify-content-md-around {
            justify-content: space-around;
        }

        .justify-content-md-evenly {
            justify-content: space-evenly;
        }
    }

    @media (min-width: 992px) {
        .align-items-lg-start {
            align-items: flex-start;
        }

        .align-items-lg-center {
            align-items: center;
        }

        .align-items-lg-end {
            align-items: flex-end;
        }

        .align-items-lg-stretch {
            align-items: stretch;
        }

        .align-items-lg-baseline {
            align-items: baseline;
        }

        .justify-content-lg-start {
            justify-content: flex-start;
        }

        .justify-content-lg-center {
            justify-content: center;
        }

        .justify-content-lg-end {
            justify-content: flex-end;
        }

        .justify-content-lg-between {
            justify-content: space-between;
        }

        .justify-content-lg-around {
            justify-content: space-around;
        }

        .justify-content-lg-evenly {
            justify-content: space-evenly;
        }
    }

    @media (min-width: 1200px) {
        .align-items-xl-start {
            align-items: flex-start;
        }

        .align-items-xl-center {
            align-items: center;
        }

        .align-items-xl-end {
            align-items: flex-end;
        }

        .align-items-xl-stretch {
            align-items: stretch;
        }

        .align-items-xl-baseline {
            align-items: baseline;
        }

        .justify-content-xl-start {
            justify-content: flex-start;
        }

        .justify-content-xl-center {
            justify-content: center;
        }

        .justify-content-xl-end {
            justify-content: flex-end;
        }

        .justify-content-xl-between {
            justify-content: space-between;
        }

        .justify-content-xl-around {
            justify-content: space-around;
        }

        .justify-content-xl-evenly {
            justify-content: space-evenly;
        }
    }

    /* Column wrapping */
    .flex-nowrap {
        flex-wrap: nowrap;
    }

    .flex-wrap {
        flex-wrap: wrap;
    }

    .flex-wrap-reverse {
        flex-wrap: wrap-reverse;
    }

    /* Responsive wrapping */
    @media (min-width: 576px) {
        .flex-sm-nowrap {
            flex-wrap: nowrap;
        }

        .flex-sm-wrap {
            flex-wrap: wrap;
        }

        .flex-sm-wrap-reverse {
            flex-wrap: wrap-reverse;
        }
    }

    @media (min-width: 768px) {
        .flex-md-nowrap {
            flex-wrap: nowrap;
        }

        .flex-md-wrap {
            flex-wrap: wrap;
        }

        .flex-md-wrap-reverse {
            flex-wrap: wrap-reverse;
        }
    }

    @media (min-width: 992px) {
        .flex-lg-nowrap {
            flex-wrap: nowrap;
        }

        .flex-lg-wrap {
            flex-wrap: wrap;
        }

        .flex-lg-wrap-reverse {
            flex-wrap: wrap-reverse;
        }
    }

    @media (min-width: 1200px) {
        .flex-xl-nowrap {
            flex-wrap: nowrap;
        }

        .flex-xl-wrap {
            flex-wrap: wrap;
        }

        .flex-xl-wrap-reverse {
            flex-wrap: wrap-reverse;
        }
    }

    /* Grid container */
    .container,
    .container-fluid,
    .container-sm,
    .container-md,
    .container-lg,
    .container-xl,
    .container-xxl {
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }

    @media (min-width: 576px) {

        .container,
        .container-sm {
            max-width: 540px;
        }
    }

    @media (min-width: 768px) {

        .container,
        .container-sm,
        .container-md {
            max-width: 720px;
        }
    }

    @media (min-width: 992px) {

        .container,
        .container-sm,
        .container-md,
        .container-lg {
            max-width: 960px;
        }
    }

    @media (min-width: 1200px) {

        .container,
        .container-sm,
        .container-md,
        .container-lg,
        .container-xl {
            max-width: 1140px;
        }
    }

    @media (min-width: 1400px) {

        .container,
        .container-sm,
        .container-md,
        .container-lg,
        .container-xl,
        .container-xxl {
            max-width: 1320px;
        }
    }

    /* Utility classes for rows */
    .row-cols-1>* {
        flex: 0 0 100%;
        max-width: 100%;
    }

    .row-cols-2>* {
        flex: 0 0 50%;
        max-width: 50%;
    }

    .row-cols-3>* {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }

    .row-cols-4>* {
        flex: 0 0 25%;
        max-width: 25%;
    }

    .row-cols-5>* {
        flex: 0 0 20%;
        max-width: 20%;
    }

    .row-cols-6>* {
        flex: 0 0 16.666667%;
        max-width: 16.666667%;
    }

    /* Responsive row columns */
    @media (min-width: 576px) {
        .row-cols-sm-1>* {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .row-cols-sm-2>* {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .row-cols-sm-3>* {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .row-cols-sm-4>* {
            flex: 0 0 25%;
            max-width: 25%;
        }

        .row-cols-sm-5>* {
            flex: 0 0 20%;
            max-width: 20%;
        }

        .row-cols-sm-6>* {
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }
    }

    @media (min-width: 768px) {
        .row-cols-md-1>* {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .row-cols-md-2>* {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .row-cols-md-3>* {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .row-cols-md-4>* {
            flex: 0 0 25%;
            max-width: 25%;
        }

        .row-cols-md-5>* {
            flex: 0 0 20%;
            max-width: 20%;
        }

        .row-cols-md-6>* {
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }
    }

    @media (min-width: 992px) {
        .row-cols-lg-1>* {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .row-cols-lg-2>* {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .row-cols-lg-3>* {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .row-cols-lg-4>* {
            flex: 0 0 25%;
            max-width: 25%;
        }

        .row-cols-lg-5>* {
            flex: 0 0 20%;
            max-width: 20%;
        }

        .row-cols-lg-6>* {
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }
    }

    @media (min-width: 1200px) {
        .row-cols-xl-1>* {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .row-cols-xl-2>* {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .row-cols-xl-3>* {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .row-cols-xl-4>* {
            flex: 0 0 25%;
            max-width: 25%;
        }

        .row-cols-xl-5>* {
            flex: 0 0 20%;
            max-width: 20%;
        }

        .row-cols-xl-6>* {
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }
    }

    /* Additional spacing utilities for grid */
    .mb-row {
        margin-bottom: 1rem;
    }

    .mt-row {
        margin-top: 1rem;
    }

    /* Vertical alignment in rows */
    .row.align-items-center {
        align-items: center;
    }

    .row.align-items-start {
        align-items: flex-start;
    }

    .row.align-items-end {
        align-items: flex-end;
    }

    /* Horizontal alignment in rows */
    .row.justify-content-center {
        justify-content: center;
    }

    .row.justify-content-start {
        justify-content: flex-start;
    }

    .row.justify-content-end {
        justify-content: flex-end;
    }

    .row.justify-content-between {
        justify-content: space-between;
    }

    .row.justify-content-around {
        justify-content: space-around;
    }

    /* Equal height columns */
    .row.row-eq-height {
        display: flex;
        flex-wrap: wrap;
    }

    .row.row-eq-height>[class*="col-"] {
        display: flex;
        flex-direction: column;
    }

    /* Vertical gutters (row spacing) */
    .row.g-0 {
        margin-right: 0;
        margin-left: 0;
    }

    .row.g-0>[class*="col-"] {
        padding-right: 0;
        padding-left: 0;
    }

    .row.g-1 {
        margin-right: -0.25rem;
        margin-left: -0.25rem;
    }

    .row.g-1>[class*="col-"] {
        padding-right: 0.25rem;
        padding-left: 0.25rem;
    }

    .row.g-2 {
        margin-right: -0.5rem;
        margin-left: -0.5rem;
    }

    .row.g-2>[class*="col-"] {
        padding-right: 0.5rem;
        padding-left: 0.5rem;
    }

    .row.g-3 {
        margin-right: -1rem;
        margin-left: -1rem;
    }

    .row.g-3>[class*="col-"] {
        padding-right: 1rem;
        padding-left: 1rem;
    }

    .row.g-4 {
        margin-right: -1.5rem;
        margin-left: -1.5rem;
    }

    .row.g-4>[class*="col-"] {
        padding-right: 1.5rem;
        padding-left: 1.5rem;
    }

    .row.g-5 {
        margin-right: -3rem;
        margin-left: -3rem;
    }

    .row.g-5>[class*="col-"] {
        padding-right: 3rem;
        padding-left: 3rem;
    }
</style>