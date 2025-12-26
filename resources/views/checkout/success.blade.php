@extends('layouts.app')

@section('title', 'Order Received | CodeCraft Studio')

@section('content')
    <!-- Success Hero -->
    <section class="success-hero-v2">
        <div class="container text-center">
            <div class="success-icon-wrapper mb-4">
                <div class="success-icon-circle">
                    <i class="fas fa-check"></i>
                </div>
                <div class="confetti-particles"></div>
            </div>

            <h1 class="success-title">Thank You for Your Order!</h1>
            <p class="success-subtitle">
                Your order <span class="order-id">#{{ $order->order_number }}</span> has been placed successfully and is now
                being handled with care.
            </p>

            <div class="hero-actions">
                <a href="{{ url('/') }}" class="btn-secondary-v2">Return Home</a>
                <a href="{{ url('/#products') }}" class="btn-primary-v2">Continue Shopping</a>
            </div>
        </div>
    </section>

    <section class="receipt-section pb-5" style="background: var(--bg-primary); position: relative; z-index: 1;">
        <div class="container">
            <div class="receipt-grid">

                <!-- Main Receipt Information -->
                <div class="receipt-main">
                    <div class="premium-card">
                        <div class="card-header-v2">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <h3>Receipt Information</h3>
                        </div>

                        <div class="receipt-meta">
                            <div class="meta-item">
                                <label>Order Number</label>
                                <div class="meta-value highlight">#{{ $order->order_number }}</div>
                            </div>
                            <div class="meta-item">
                                <label>Date Saved</label>
                                <div class="meta-value">{{ $order->created_at->format('M d, Y') }}</div>
                            </div>
                            <div class="meta-item full-width">
                                <label>Email Confirmation</label>
                                <div class="meta-value">{{ $order->client_email }}</div>
                            </div>
                            <div class="meta-item">
                                <label>Payment Status</label>
                                <div class="meta-value">
                                    <span class="status-badge {{ $order->payment_status }}">
                                        <i
                                            class="fas {{ $order->payment_status == 'paid' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if($order->payment_method == 'bank_transfer' && $order->payment_status != 'paid')
                            <div class="bank-transfer-box">
                                <div class="box-header">
                                    <i class="fas fa-university"></i>
                                    <h4>Bank Transfer Instructions</h4>
                                </div>
                                <p>Please use your order number as the transfer reference.</p>

                                <div class="bank-info-grid">
                                    <div class="bank-row">
                                        <span>Bank Name</span>
                                        <strong>{{ \App\Models\SiteSetting::get('bank_name', 'N/A') }}</strong>
                                    </div>
                                    <div class="bank-row">
                                        <span>Account Holder</span>
                                        <strong>{{ \App\Models\SiteSetting::get('bank_account_holder', 'N/A') }}</strong>
                                    </div>
                                    <div class="bank-row">
                                        <span>Account Number</span>
                                        <strong
                                            class="copyable">{{ \App\Models\SiteSetting::get('bank_account_number', 'N/A') }}</strong>
                                    </div>
                                    <div class="bank-row no-border">
                                        <span>SWIFT / BIC</span>
                                        <strong>{{ \App\Models\SiteSetting::get('bank_swift_code', 'N/A') }}</strong>
                                    </div>
                                </div>
                                <div class="bank-alert">
                                    <i class="fas fa-info-circle"></i>
                                    <span>Your licenses will be activated once payment is confirmed (1-3 business days).</span>
                                </div>
                            </div>
                        @else
                            <div class="confirmation-info">
                                <div class="info-icon">
                                    <i class="fas fa-envelope-open-text"></i>
                                </div>
                                <div class="info-text">
                                    A confirmation email has been sent to <strong>{{ $order->client_email }}</strong> with all
                                    relevant details for your purchase.
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Summary & Downloads -->
                <div class="receipt-sidebar">
                    @if($order->payment_status == 'paid' || $order->status == 'completed')
                        <div class="premium-card downloads-card">
                            <div class="card-header-v2 dark">
                                <i class="fas fa-cloud-download-alt"></i>
                                <h3>Instant Downloads</h3>
                            </div>
                            <div class="downloads-list">
                                @forelse($order->items as $item)
                                    @if($item->product && $item->product->product_type === 'service')
                                        <div class="download-item service">
                                            <div class="item-info">
                                                <i class="fas fa-magic"></i>
                                                <div class="item-text">
                                                    <span class="name">{{ \Illuminate\Support\Str::limit($item->name, 25) }}</span>
                                                    <span class="type">Service Active</span>
                                                </div>
                                            </div>
                                            <div class="service-badge">READY</div>
                                        </div>
                                    @else
                                        <a href="{{ route('download.order.item', [$order, $item]) }}" class="download-item link">
                                            <div class="item-info">
                                                <i class="fas fa-file-archive"></i>
                                                <div class="item-text">
                                                    <span class="name">{{ \Illuminate\Support\Str::limit($item->name, 25) }}</span>
                                                    <span class="type">Source Code</span>
                                                </div>
                                            </div>
                                            <div class="download-trigger">
                                                <i class="fas fa-arrow-down"></i>
                                            </div>
                                        </a>
                                    @endif
                                @empty
                                    <p class="text-muted">No items found.</p>
                                @endforelse
                            </div>
                        </div>
                    @endif

                    <div class="premium-card summary-card">
                        <div class="card-header-v2">
                            <i class="fas fa-shopping-bag"></i>
                            <h3>Order Summary</h3>
                        </div>

                        <div class="pricing-summary">
                            <div class="price-row">
                                <span>Subtotal</span>
                                <span>${{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="price-row">
                                <span>Tax</span>
                                <span>$0.00</span>
                            </div>
                            <div class="total-divider"></div>
                            <div class="price-row total">
                                <span>Total Paid</span>
                                <span class="amount">${{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>

                        <div class="payment-source">
                            <div class="source-icon">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <div class="source-details">
                                <span class="label">Payment Method</span>
                                <span class="value">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <style>
        .success-hero-v2 {
            padding: 100px 0 60px;
            background: radial-gradient(circle at top right, var(--bg-tertiary) 0%, var(--bg-primary) 100%);
        }

        .success-icon-wrapper {
            position: relative;
            display: inline-block;
        }

        .success-icon-circle {
            width: 80px;
            height: 80px;
            background: #10b981;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
            animation: bounceIn 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .success-title {
            font-size: 2.8rem;
            font-weight: 850;
            color: var(--text-primary);
            letter-spacing: -0.03em;
            margin-bottom: 1rem;
        }

        .success-subtitle {
            font-size: 1.15rem;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto 2.5rem;
            line-height: 1.6;
        }

        .order-id {
            color: var(--primary-color);
            font-weight: 700;
        }

        .hero-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn-primary-v2,
        .btn-secondary-v2 {
            padding: 12px 28px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary-v2 {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);
        }

        .btn-secondary-v2 {
            background: var(--bg-secondary);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .btn-primary-v2:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(99, 102, 241, 0.3);
            color: white;
        }

        /* Layout */
        .receipt-grid {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            text-align: left;
            align-items: start;
        }

        .receipt-sidebar {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .premium-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            width: 100%;
            overflow: hidden;
        }

        .card-header-v2 {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .card-header-v2 i {
            width: 45px;
            height: 45px;
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .card-header-v2 h3 {
            font-size: 1.35rem;
            font-weight: 800;
            margin: 0;
            letter-spacing: -0.02em;
        }

        /* Receipt Meta */
        .receipt-meta {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
            margin-bottom: 35px;
        }

        .meta-item label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            margin-bottom: 8px;
        }

        .meta-value {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .meta-value.highlight {
            color: var(--primary-color);
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .status-badge.paid {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .status-badge.unpaid {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        /* Bank Transfer */
        .bank-transfer-box {
            background: var(--bg-tertiary);
            border-radius: 20px;
            padding: 25px;
            border: 1px solid var(--border-color);
        }

        .box-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .box-header i {
            color: var(--primary-color);
        }

        .box-header h4 {
            font-weight: 800;
            margin: 0;
        }

        .bank-transfer-box p {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-bottom: 20px;
        }

        .bank-info-grid {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .bank-row {
            display: flex;
            justify-content: space-between;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.9rem;
        }

        .bank-row span {
            color: var(--text-tertiary);
        }

        .bank-row.no-border {
            border: none;
            padding-bottom: 0;
        }

        .bank-alert {
            margin-top: 20px;
            padding: 12px 15px;
            background: rgba(245, 158, 11, 0.05);
            border-radius: 12px;
            font-size: 0.85rem;
            color: #d97706;
            display: flex;
            gap: 10px;
        }

        .confirmation-info {
            display: flex;
            gap: 20px;
            align-items: center;
            background: rgba(59, 130, 246, 0.05);
            padding: 20px;
            border-radius: 20px;
        }

        .info-icon {
            width: 50px;
            height: 50px;
            background: #3b82f6;
            color: white;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .info-text {
            font-size: 0.95rem;
            line-height: 1.5;
            color: var(--text-secondary);
        }

        /* Sidebar Summary */
        .downloads-card {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            color: white !important;
            border: none !important;
            box-shadow: 0 20px 40px rgba(16, 185, 129, 0.2) !important;
        }

        .downloads-card .card-header-v2 i {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .downloads-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .download-item {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-decoration: none;
            color: white;
            transition: all 0.3s ease;
        }

        .download-item.link:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(5px);
        }

        .item-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .item-text {
            display: flex;
            flex-direction: column;
        }

        .item-text .name {
            font-weight: 700;
            font-size: 0.9rem;
        }

        .item-text .type {
            font-size: 0.75rem;
            opacity: 0.7;
        }

        .download-trigger {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .service-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 800;
        }

        /* Pricing Card */
        .pricing-summary {
            margin-bottom: 25px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 0.95rem;
        }

        .price-row span:first-child {
            color: var(--text-secondary);
        }

        .price-row span:last-child {
            font-weight: 700;
        }

        .total-divider {
            height: 1px;
            background: var(--border-color);
            border-bottom: 2px dashed var(--border-color);
            margin: 20px 0;
            opacity: 0.5;
        }

        .price-row.total {
            align-items: center;
            margin-bottom: 0;
        }

        .price-row.total span:first-child {
            font-weight: 800;
            color: var(--text-primary);
            font-size: 1.1rem;
        }

        .price-row.total .amount {
            font-size: 1.8rem;
            font-weight: 900;
            color: var(--primary-color);
            letter-spacing: -0.04em;
        }

        .payment-source {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: var(--bg-tertiary);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            margin-top: 25px;
        }

        .source-icon {
            font-size: 1.25rem;
            color: var(--text-tertiary);
        }

        .source-details {
            display: flex;
            flex-direction: column;
        }

        .source-details .label {
            font-size: 0.7rem;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--text-tertiary);
        }

        .source-details .value {
            font-weight: 800;
            font-size: 0.9rem;
            text-transform: capitalize;
        }

        /* Animations */
        @keyframes bounceIn {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }

            50% {
                transform: scale(1.05);
            }

            70% {
                transform: scale(0.9);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @media (max-width: 992px) {
            .receipt-grid {
                grid-template-columns: 1fr;
            }

            .success-hero-v2 {
                padding: 60px 0 40px;
            }

            .success-title {
                font-size: 2.2rem;
            }

            .receipt-meta {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }
    </style>
@endsection