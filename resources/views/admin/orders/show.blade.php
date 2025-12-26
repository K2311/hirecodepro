@extends('admin.layouts.app')

@section('title', 'Order Details | CodeCraft Studio')
@section('page-title', 'Order Details')

@section('content')
    <div class="page-header d-print-none mb-4">
        <div class="page-title">
            <h1 class="fw-bold">
                <a href="{{ route('admin.orders.index') }}" class="text-muted decoration-none me-2"><i
                        class="fas fa-arrow-left"></i></a>
                Order #{{ $order->order_number ?: substr($order->id, 0, 8) }}
            </h1>
            <p class="text-muted small">Placed on {{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
        </div>
        <div class="page-actions d-flex gap-2">
            @if($order->payment_status === 'paid' && !$order->file_delivered)
                <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="d-inline">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="completed">
                    <input type="hidden" name="payment_status" value="paid">
                    <input type="hidden" name="file_delivered" value="1">
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        <i class="fas fa-check me-2"></i> Deliver Content
                    </button>
                </form>
            @endif

            @if($order->invoice)
                <a href="{{ route('admin.invoices.show', $order->invoice) }}" class="btn btn-outline-primary rounded-pill px-4">
                    <i class="fas fa-file-invoice me-2"></i> View Invoice
                </a>
                <a href="{{ route('admin.invoices.show', $order->invoice) }}?print=true"
                    class="btn btn-outline-dark rounded-pill px-3" onclick="window.open(this.href); return false;">
                    <i class="fas fa-print"></i>
                </a>
            @else
                <form action="{{ route('admin.orders.generate-invoice', $order) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="fas fa-magic me-2"></i> Generate Invoice
                    </button>
                </form>
            @endif

            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                onsubmit="return confirm('Delete this order?');" class="d-inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-outline-danger rounded-pill px-3">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-8">
            <!-- Order Items Card -->
            <div class="premium-card border-0 shadow-sm mb-4">
                <div class="card-header-premium bg-white py-3 px-4">
                    <h3 class="m-0 fw-bold"><i class="fas fa-shopping-basket me-2 text-primary"></i>Ordered Items</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="premium-table">
                            <thead>
                                <tr>
                                    <th class="ps-4">Product Details</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Qty</th>
                                    <th class="pe-4 text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr class="align-middle">
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center py-2">
                                                @if($item->product && $item->product->thumbnail_url)
                                                    <img src="{{ asset($item->product->thumbnail_url) }}" class="item-thumb me-3">
                                                @else
                                                    <div class="item-thumb-placeholder me-3">
                                                        <i class="fas fa-box"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold text-dark fs-6">{{ $item->name }}</div>
                                                    <div class="small text-muted">{{ $item->item_type }}
                                                        #{{ $item->product_id ?: $item->service_id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center text-muted fw-medium">{{ $order->currency }}
                                            {{ number_format($item->price, 2) }}</td>
                                        <td class="text-center fw-bold">{{ $item->quantity }}</td>
                                        <td class="pe-4 text-end fw-bold text-dark">{{ $order->currency }}
                                            {{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light border-top">
                                <tr>
                                    <td colspan="3" class="text-end py-3 text-muted fw-bold">Subtotal</td>
                                    <td class="pe-4 text-end py-3 fw-bold">{{ $order->currency }}
                                        {{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                @if($order->tax_amount > 0)
                                    <tr>
                                        <td colspan="3" class="text-end py-2 text-muted fw-bold">Tax</td>
                                        <td class="pe-4 text-end py-2 fw-bold">{{ $order->currency }}
                                            {{ number_format($order->tax_amount, 2) }}</td>
                                    </tr>
                                @endif
                                @if($order->discount_amount > 0)
                                    <tr>
                                        <td colspan="3" class="text-end py-2 text-danger fw-bold">Discount</td>
                                        <td class="pe-4 text-end py-2 fw-bold text-danger">-{{ $order->currency }}
                                            {{ number_format($order->discount_amount, 2) }}</td>
                                    </tr>
                                @endif
                                <tr class="bg-dark text-white">
                                    <td colspan="3" class="text-end py-4 fs-5 fw-black">GRAND TOTAL</td>
                                    <td class="pe-4 text-end py-4 fs-3 fw-black">{{ $order->currency }}
                                        {{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Internal Notes -->
            <div class="premium-card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-3 text-dark"><i class="fas fa-sticky-note me-2 text-warning"></i>Internal Notes</h5>
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="{{ $order->status }}">
                    <input type="hidden" name="payment_status" value="{{ $order->payment_status }}">
                    <textarea name="notes" class="form-input-premium mb-3" rows="4"
                        placeholder="Private notes about this order..." style="height: auto;">{{ $order->notes }}</textarea>
                    <button type="submit" class="btn btn-dark rounded-pill px-4">Save Notes</button>
                </form>
            </div>
        </div>

        <div class="col-xl-4">
            <!-- Order Management Card -->
            <div class="premium-card border-0 shadow-sm p-4 mb-4">
                <h5 class="fw-bold mb-4 text-dark"><i class="fas fa-tasks me-2 text-primary"></i>Management</h5>

                @if(session('success'))
                    <div class="alert bg-soft-success border-0 small mb-4 py-2 px-3 rounded-3 text-success fw-bold">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="form-label small text-uppercase fw-bold text-muted ls-1 mb-2">Order Status</label>
                        <div class="select-wrapper">
                            <select name="status" class="form-select-premium fw-bold">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing
                                </option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                                <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>Refunded
                                </option>
                            </select>
                            <i class="fas fa-chevron-down select-icon"></i>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small text-uppercase fw-bold text-muted ls-1 mb-2">Payment Status</label>
                        <div class="select-wrapper">
                            <select name="payment_status" class="form-select-premium fw-bold">
                                <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed
                                </option>
                                <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded
                                </option>
                            </select>
                            <i class="fas fa-chevron-down select-icon"></i>
                        </div>
                    </div>
                    <div class="form-check form-switch mb-4 d-flex align-items-center gap-3 ps-0">
                        <input class="form-check-input ms-0" type="checkbox" name="file_delivered" id="file_delivered"
                            value="1" {{ $order->file_delivered ? 'checked' : '' }} style="width: 2.8rem; height: 1.4rem;">
                        <label class="form-check-label fw-bold text-dark" for="file_delivered">Delivery Content Sent</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm">Update
                        Order</button>
                </form>
            </div>

            <!-- Customer Details Card -->
            <div class="premium-card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-4 text-dark"><i class="fas fa-user-circle me-2 text-info"></i>Customer Information
                </h5>
                <div class="d-flex flex-column gap-3">
                    <div class="p-3 rounded-4 bg-light border border-white">
                        <label class="text-muted small text-uppercase fw-bold d-block mb-1">Full Name</label>
                        <div class="fw-bold text-dark fs-5">{{ $order->client_name }}</div>
                    </div>
                    <div class="p-3 rounded-4 bg-light border border-white">
                        <label class="text-muted small text-uppercase fw-bold d-block mb-1">Email Address</label>
                        <div class="fw-bold"><a href="mailto:{{ $order->client_email }}"
                                class="text-primary decoration-none">{{ $order->client_email }}</a></div>
                    </div>
                    @if($order->client_company)
                        <div class="p-3 rounded-4 bg-light border border-white">
                            <label class="text-muted small text-uppercase fw-bold d-block mb-1">Company</label>
                            <div class="fw-bold text-dark">{{ $order->client_company }}</div>
                        </div>
                    @endif
                    <div class="p-3 rounded-4 bg-light border border-white">
                        <label class="text-muted small text-uppercase fw-bold d-block mb-2">Payment Method</label>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill fw-bold text-uppercase"
                                style="font-size: 0.65rem;">
                                {{ str_replace('_', ' ', $order->payment_method) }}
                            </span>
                        </div>
                        @if($order->transaction_id)
                            <div class="small text-muted mt-2 font-monospace opacity-75" style="font-size: 0.7rem;">TXN:
                                {{ $order->transaction_id }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .decoration-none {
            text-decoration: none;
        }

        .ls-1 {
            letter-spacing: 1px;
        }

        .fw-black {
            font-weight: 900;
        }

        .bg-soft-success {
            background-color: rgba(16, 185, 129, 0.1) !important;
            color: #10b981 !important;
        }

        .bg-soft-primary {
            background-color: rgba(59, 130, 246, 0.1) !important;
            color: #3b82f6 !important;
        }

        .premium-card {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
        }

        body.dark-mode .premium-card {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
        }

        .card-header-premium {
            border-bottom: 1px solid #f1f5f9;
        }

        body.dark-mode .card-header-premium {
            border-color: var(--dark-border);
            background: transparent !important;
        }

        .premium-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .premium-table thead th {
            background: #f8fafc;
            padding: 14px 16px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom: 1px solid #f1f5f9;
        }

        body.dark-mode .premium-table thead th {
            background: rgba(255, 255, 255, 0.02);
            color: #94a3b8;
            border-color: var(--dark-border);
        }

        .premium-table tbody td {
            padding: 18px 16px;
            border-bottom: 1px solid #f1f5f9;
        }

        body.dark-mode .premium-table tbody td {
            border-color: var(--dark-border);
        }

        .item-thumb {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid #e2e8f0;
        }

        .item-thumb-placeholder {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #cbd5e1;
            font-size: 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .form-input-premium,
        .form-select-premium {
            width: 100%;
            height: 48px;
            padding: 10px 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.95rem;
            display: block;
            outline: none;
            transition: all 0.2s;
        }

        body.dark-mode .form-input-premium,
        body.dark-mode .form-select-premium {
            background: rgba(255, 255, 255, 0.03);
            border-color: var(--dark-border);
            color: var(--dark-text);
        }

        .select-wrapper {
            position: relative;
        }

        .select-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }

        .font-monospace {
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        }

        .status-badge {
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            display: inline-block;
            padding: 4px 12px;
        }

        .order-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .order-processing {
            background: #e0f2fe;
            color: #0369a1;
        }

        .order-completed,
        .order-paid {
            background: #dcfce7;
            color: #166534;
        }

        .order-cancelled,
        .order-failed {
            background: #fee2e2;
            color: #991b1b;
        }

        .order-refunded {
            background: #f3e8ff;
            color: #6b21a8;
        }
    </style>
@endsection