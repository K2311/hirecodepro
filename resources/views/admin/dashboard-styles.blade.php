<style>
    /* Page Header */
    .dashboard-header {
        padding: 1.5rem 0;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1e293b;
    }

    body.dark-mode .page-title {
        color: #f1f5f9;
    }

    /* Metric Cards */
    .metric-card {
        background: white;
        border-radius: 20px;
        padding: 1.75rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        height: 100%;
    }

    .metric-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px -8px rgba(0, 0, 0, 0.12);
    }

    body.dark-mode .metric-card {
        background: var(--dark-card);
        border-color: var(--dark-border);
    }

    .metric-icon {
        width: 70px;
        height: 70px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        flex-shrink: 0;
    }

    .metric-revenue .metric-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .metric-orders .metric-icon {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .metric-clients .metric-icon {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .metric-products .metric-icon {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }

    .metric-content {
        flex: 1;
    }

    .metric-label {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .metric-value {
        font-size: 2rem;
        font-weight: 800;
        color: #1e293b;
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    body.dark-mode .metric-value {
        color: #f1f5f9;
    }

    .metric-trend {
        font-size: 0.8rem;
        font-weight: 600;
    }

    .trend-up {
        color: #10b981;
    }

    .trend-down {
        color: #ef4444;
    }

    .trend-neutral {
        color: #94a3b8;
    }

    /* Dashboard Cards */
    .dashboard-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    body.dark-mode .dashboard-card {
        background: var(--dark-card);
        border-color: var(--dark-border);
    }

    .dashboard-card .card-body {
        flex: 1;
        overflow: hidden;
    }

    .card-header-dash {
        padding: 1.5rem;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    body.dark-mode .card-header-dash {
        border-bottom-color: var(--dark-border);
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
    }

    body.dark-mode .card-title {
        color: #f1f5f9;
    }

    /* Chart Container */
    .chart-container {
        position: relative;
        width: 100%;
    }

    .chart-container canvas {
        max-height: 100%;
        width: 100% !important;
        height: 100% !important;
    }

    /* Tables */
    .dashboard-table {
        width: 100%;
        border-collapse: collapse;
    }

    .dashboard-table thead th {
        background: #f8fafc;
        padding: 1rem 1.5rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        border-bottom: 2px solid #e2e8f0;
    }

    body.dark-mode .dashboard-table thead th {
        background: rgba(255, 255, 255, 0.02);
        border-bottom-color: var(--dark-border);
    }

    .dashboard-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .dashboard-table tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.03);
    }

    .dashboard-table tbody td {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
    }

    body.dark-mode .dashboard-table tbody td {
        border-bottom-color: var(--dark-border);
    }

    .product-avatar,
    .client-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    /* Status Legend */
    .status-legend {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .legend-label {
        flex: 1;
        font-size: 0.9rem;
        color: #64748b;
    }

    .legend-value {
        font-weight: 700;
        color: #1e293b;
    }

    body.dark-mode .legend-value {
        color: #f1f5f9;
    }

    .status-pending {
        background: #f59e0b;
    }

    .status-completed {
        background: #10b981;
    }

    .status-cancelled {
        background: #ef4444;
    }

    .status-processing {
        background: #3b82f6;
    }

    /* Invoice Stats */
    .invoice-stats {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .invoice-stat-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 12px;
    }

    body.dark-mode .invoice-stat-item {
        background: rgba(255, 255, 255, 0.02);
    }

    .invoice-stat-item .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .stat-details {
        flex: 1;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1e293b;
        line-height: 1;
        margin-bottom: 0.25rem;
    }

    body.dark-mode .stat-value {
        color: #f1f5f9;
    }

    .stat-label {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-amount {
        font-size: 0.85rem;
        color: #10b981;
        font-weight: 700;
        margin-top: 0.25rem;
    }

    /* Utility Classes */
    .bg-soft-primary {
        background-color: rgba(59, 130, 246, 0.1);
    }

    .bg-soft-success {
        background-color: rgba(16, 185, 129, 0.1);
    }

    .bg-soft-warning {
        background-color: rgba(245, 158, 11, 0.1);
    }

    .bg-soft-danger {
        background-color: rgba(239, 68, 68, 0.1);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.5rem;
        }

        .metric-card {
            flex-direction: column;
            text-align: center;
        }

        .metric-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }

        .metric-value {
            font-size: 1.5rem;
        }

        .card-header-dash {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }
    }
</style>