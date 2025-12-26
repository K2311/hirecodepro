@extends('admin.layouts.app')

@section('title', 'Edit Invoice | CodeCraft Studio')
@section('page-title', 'Edit Invoice')

@section('content')
    <div class="page-header mb-4">
        <div class="page-title">
            <h1 class="fw-bold"><i class="fas fa-edit me-2 text-primary"></i>Edit Invoice #{{ $invoice->invoice_number }}
            </h1>
            <p class="text-muted">Modify statement issued on {{ $invoice->issue_date->format('M d, Y') }}</p>
        </div>
        <div class="page-actions d-flex gap-2">
            <a href="{{ route('admin.invoices.show', $invoice) }}" class="btn btn-outline-primary">
                <i class="fas fa-eye me-2"></i> View
            </a>
            <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <form action="{{ route('admin.invoices.update', $invoice) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="premium-card">
                    <div class="card-header-premium">
                        <h3><i class="fas fa-info-circle me-2"></i>Update Invoice Details</h3>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <!-- Client Selection -->
                            <div class="col-md-12">
                                <div class="form-group-premium">
                                    <label class="form-label-premium">Recipient Client *</label>
                                    <div class="select-wrapper">
                                        <select name="client_id" id="client_id" class="form-select-premium" required>
                                            @foreach($clients as $client)
                                                <option value="{{ $client->id }}" {{ $invoice->client_id == $client->id ? 'selected' : '' }}>
                                                    {{ $client->full_name }} ({{ $client->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <i class="fas fa-user-tie select-icon"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-premium">
                                    <label class="form-label-premium">Issue Date *</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-calendar-alt input-icon"></i>
                                        <input type="date" name="issue_date" class="form-input-premium"
                                            value="{{ $invoice->issue_date->format('Y-m-d') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-premium">
                                    <label class="form-label-premium">Due Date *</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-calendar-check input-icon"></i>
                                        <input type="date" name="due_date" class="form-input-premium"
                                            value="{{ $invoice->due_date->format('Y-m-d') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group-premium">
                                    <label class="form-label-premium">Subtotal *</label>
                                    <div class="input-group-premium">
                                        <span class="currency-symbol">$</span>
                                        <input type="number" step="0.01" name="amount" id="amount"
                                            class="form-input-premium ps-5" value="{{ $invoice->amount }}" required
                                            oninput="calculateTotal()">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group-premium">
                                    <label class="form-label-premium">Tax Amount</label>
                                    <div class="input-group-premium">
                                        <span class="currency-symbol">$</span>
                                        <input type="number" step="0.01" name="tax_amount" id="tax_amount"
                                            class="form-input-premium ps-5" value="{{ $invoice->tax_amount }}"
                                            oninput="calculateTotal()">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group-premium">
                                    <label class="form-label-premium">Total Amount</label>
                                    <div class="input-group-premium">
                                        <span class="currency-symbol bg-primary-light text-primary fw-bold">$</span>
                                        <input type="number" step="0.01" name="total_amount" id="total_amount"
                                            class="form-input-premium ps-5 fw-bold text-primary"
                                            value="{{ $invoice->total_amount }}" required readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-premium">
                                    <label class="form-label-premium">Currency</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-money-bill-wave input-icon"></i>
                                        <input type="text" name="currency" id="currency" class="form-input-premium"
                                            value="{{ $invoice->currency }}" required maxlength="3">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-premium">
                                    <label class="form-label-premium">Invoice Status</label>
                                    <div class="select-wrapper">
                                        <select name="status" class="form-select-premium" required>
                                            <option value="draft" {{ $invoice->status == 'draft' ? 'selected' : '' }}>Draft
                                            </option>
                                            <option value="sent" {{ $invoice->status == 'sent' ? 'selected' : '' }}>Sent
                                            </option>
                                            <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Paid
                                            </option>
                                            <option value="overdue" {{ $invoice->status == 'overdue' ? 'selected' : '' }}>
                                                Overdue</option>
                                            <option value="cancelled" {{ $invoice->status == 'cancelled' ? 'selected' : '' }}>
                                                Cancelled</option>
                                        </select>
                                        <i class="fas fa-tags select-icon"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group-premium">
                                    <label class="form-label-premium">Notes & Terms</label>
                                    <textarea name="notes" class="form-input-premium h-auto py-3" rows="4"
                                        placeholder="Additional information...">{{ $invoice->notes }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer-premium p-4 text-end">
                        <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill shadow-lg">
                            <i class="fas fa-save me-2"></i> Update Invoice
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            @if($invoice->order)
                <div class="premium-card mb-4 border-0 shadow-lg">
                    <div class="card-header-premium bg-dark text-white d-flex justify-content-between align-items-center">
                        <h3 class="text-white mb-0"><i class="fas fa-link me-2"></i>Linked Order</h3>
                        <a href="{{ route('admin.orders.show', $invoice->order) }}"
                            class="btn btn-sm btn-outline-light py-1">View</a>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                            <span class="text-muted small">Order Number</span>
                            <span
                                class="fw-bold text-dark">#{{ $invoice->order->order_number ?: substr($invoice->order->id, 0, 8) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                            <span class="text-muted small">Order Status</span>
                            <span
                                class="status-badge status-{{ $invoice->order->status }}">{{ ucfirst($invoice->order->status) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-0 pb-0">
                            <span class="text-muted small">Payment Status</span>
                            <span
                                class="status-badge pay-{{ $invoice->order->payment_status }}">{{ ucfirst($invoice->order->payment_status) }}</span>
                        </div>
                    </div>
                </div>

                <div class="premium-card bg-light border-0">
                    <div class="card-body p-4 text-center">
                        <i class="fas fa-info-circle text-primary mb-3 fs-3"></i>
                        <h4 class="fw-bold mb-2">Did you know?</h4>
                        <p class="small text-muted mb-0">Changes to the subtotal here do not affect the original order data, but
                            marking this as paid will update the order's payment status.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .rounded-lg {
            border-radius: 12px;
        }

        .currency-symbol {
            position: absolute;
            left: 1px;
            top: 1px;
            bottom: 1px;
            width: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            border-right: 1px solid var(--light-border);
            border-radius: 8px 0 0 8px;
            color: var(--light-muted);
            z-index: 5;
        }

        .bg-primary-light {
            background-color: rgba(59, 130, 246, 0.1) !important;
        }

        /* Premium Components */
        .premium-card {
            background: #ffffff;
            border: 1px solid var(--light-border);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        body.dark-mode .premium-card {
            background: var(--dark-card);
            border-color: var(--dark-border);
        }

        .card-header-premium {
            padding: 20px 24px;
            border-bottom: 1px solid var(--light-border);
        }

        body.dark-mode .card-header-premium {
            border-color: var(--dark-border);
        }

        .card-header-premium h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
            color: inherit;
        }

        .card-footer-premium {
            border-top: 1px solid var(--light-border);
        }

        body.dark-mode .card-footer-premium {
            border-color: var(--dark-border);
        }

        .form-group-premium {
            margin-bottom: 0px;
        }

        .form-label-premium {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--light-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        body.dark-mode .form-label-premium {
            color: var(--dark-muted);
        }

        .form-input-premium,
        .form-select-premium {
            width: 100%;
            height: 48px;
            padding: 10px 16px;
            background: #f8fafc;
            border: 1px solid var(--light-border);
            border-radius: 10px;
            font-size: 0.95rem;
            color: var(--light-text);
            transition: all 0.2s;
            outline: none;
        }

        body.dark-mode .form-input-premium,
        body.dark-mode .form-select-premium {
            background: rgba(255, 255, 255, 0.03);
            border-color: var(--dark-border);
            color: var(--dark-text);
        }

        .form-input-premium:focus,
        .form-select-premium:focus {
            background: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        body.dark-mode .form-input-premium:focus,
        body.dark-mode .form-select-premium:focus {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--primary);
        }

        .select-wrapper,
        .input-icon-wrapper,
        .input-group-premium {
            position: relative;
        }

        .select-icon,
        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--light-muted);
            pointer-events: none;
            opacity: 0.7;
        }

        .input-icon {
            left: 16px;
            right: auto;
        }

        .input-icon+.form-input-premium {
            padding-left: 45px;
        }

        /* Badge compatibility */
        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .status-pending {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-processing {
            background: #fef3c7;
            color: #92400e;
        }

        .status-completed {
            background: #d1fae5;
            color: #065f46;
        }

        .pay-paid {
            background: #dcfce7;
            color: #166534;
        }

        .pay-pending {
            background: #fef9c3;
            color: #854d0e;
        }
    </style>

    <script>
        function calculateTotal() {
            const amount = parseFloat(document.getElementById('amount').value) || 0;
            const tax = parseFloat(document.getElementById('tax_amount').value) || 0;
            document.getElementById('total_amount').value = (amount + tax).toFixed(2);
        }
    </script>
@endsection