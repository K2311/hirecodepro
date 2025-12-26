@extends('admin.layouts.app')

@section('title', 'Create Invoice | CodeCraft Studio')
@section('page-title', 'Create Invoice')

@section('content')
    <div class="page-headermb-4">
            <div class="page-title">
                <h1 class="fw-bold"><i class="fas fa-file-invoice-dollar me-2 text-primary"></i>Create New Invoice</h1>
                <p class="text-muted">Issue a professional billing statement to your client</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to List
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <form action="{{ route('admin.invoices.store') }}" method="POST" id="invoiceForm">
                    @csrf
                    <div class="premium-card">
                        <div class="card-header-premium">
                            <h3><i class="fas fa-info-circle me-2"></i>Invoice Information</h3>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <!-- Order Selection -->
                                <div class="col-md-12">
                                    <div class="form-group-premium">
                                        <label class="form-label-premium">Link to Existing Order <span class="text-muted small">(Optional)</span></label>
                                        <div class="select-wrapper">
                                            <select name="order_id" id="order_id" class="form-select-premium" onchange="fillFromOrder(this)">
                                                <option value="">-- Manual Invoice (No Order) --</option>
                                                @foreach($orders as $o)
                                                    <option value="{{ $o->id }}" 
                                                        data-client="{{ $o->client_id }}"
                                                        data-subtotal="{{ $o->subtotal }}"
                                                        data-tax="{{ $o->tax_amount }}"
                                                        data-total="{{ $o->total_amount }}"
                                                        data-currency="{{ $o->currency }}"
                                                        {{ (isset($order) && $order->id == $o->id) ? 'selected' : '' }}>
                                                        #{{ $o->order_number ?: substr($o->id, 0, 8) }} - {{ $o->client_name }} ({{ $o->currency }} {{ number_format($o->total_amount, 2) }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <i class="fas fa-chevron-down select-icon"></i>
                                        </div>
                                        <p class="mt-2 small text-muted"><i class="fas fa-magic me-1"></i> Selecting an order will automatically populate client and pricing data.</p>
                                    </div>
                                </div>

                                <!-- Client Selection -->
                                <div class="col-md-12">
                                    <div class="form-group-premium">
                                        <label class="form-label-premium">Recipient Client *</label>
                                        <div class="select-wrapper">
                                            <select name="client_id" id="client_id" class="form-select-premium" required>
                                                <option value="">-- Choose a Client --</option>
                                                @foreach($clients as $client)
                                                    <option value="{{ $client->id }}" 
                                                        {{ (isset($order) && $order->client_id == $client->id) ? 'selected' : '' }}>
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
                                            <input type="date" name="issue_date" class="form-input-premium" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-premium">
                                        <label class="form-label-premium">Due Date *</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fas fa-calendar-check input-icon"></i>
                                            <input type="date" name="due_date" class="form-input-premium" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group-premium">
                                        <label class="form-label-premium">Subtotal *</label>
                                        <div class="input-group-premium">
                                            <span class="currency-symbol">$</span>
                                            <input type="number" step="0.01" name="amount" id="amount" class="form-input-premium ps-5" 
                                                value="{{ isset($order) ? $order->subtotal : '0.00' }}" required oninput="calculateTotal()">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-premium">
                                        <label class="form-label-premium">Tax Amount</label>
                                        <div class="input-group-premium">
                                            <span class="currency-symbol">$</span>
                                            <input type="number" step="0.01" name="tax_amount" id="tax_amount" class="form-input-premium ps-5" 
                                                value="{{ isset($order) ? $order->tax_amount : '0.00' }}" oninput="calculateTotal()">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-premium">
                                        <label class="form-label-premium">Total Amount</label>
                                        <div class="input-group-premium">
                                            <span class="currency-symbol bg-primary-light text-primary fw-bold">$</span>
                                            <input type="number" step="0.01" name="total_amount" id="total_amount" class="form-input-premium ps-5 fw-bold text-primary" 
                                                value="{{ isset($order) ? $order->total_amount : '0.00' }}" required readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group-premium">
                                        <label class="form-label-premium">Currency</label>
                                        <div class="input-icon-wrapper">
                                            <i class="fas fa-money-bill-wave input-icon"></i>
                                            <input type="text" name="currency" id="currency" class="form-input-premium" value="{{ isset($order) ? $order->currency : 'USD' }}" required maxlength="3">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group-premium">
                                        <label class="form-label-premium">Invoice Status</label>
                                        <div class="select-wrapper">
                                            <select name="status" class="form-select-premium" required>
                                                <option value="draft">Draft</option>
                                                <option value="sent" selected>Sent</option>
                                                <option value="paid">Paid</option>
                                                <option value="overdue">Overdue</option>
                                                <option value="cancelled">Cancelled</option>
                                            </select>
                                            <i class="fas fa-tags select-icon"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group-premium">
                                        <label class="form-label-premium">Notes & Terms</label>
                                        <textarea name="notes" class="form-input-premium h-auto py-3" rows="4" placeholder="Thank you for your business! Please pay within 7 days..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer-premium p-4 d-flex justify-content-between align-items-center">
                            <span class="text-muted small"><i class="fas fa-shield-alt me-1"></i> Records are securely stored and immutable once generated.</span>
                            <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill shadow-lg">
                                <i class="fas fa-paper-plane me-2"></i> Generate & Save Invoice
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-4">
                <div class="premium-card mb-4 bg-primary text-white border-0 shadow-primary">
                    <div class="card-header-premium border-white-50">
                        <h3 class="text-white"><i class="fas fa-lightbulb me-2"></i>Quick Help</h3>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3 d-flex gap-3">
                                <i class="fas fa-link mt-1 opacity-75"></i>
                                <span class="small">Linking an order creates a direct connection for easier accounting.</span>
                            </li>
                            <li class="mb-3 d-flex gap-3">
                                <i class="fas fa-sync mt-1 opacity-75"></i>
                                <span class="small">Marking an invoice as <b>Paid</b> will automatically update the linked Order's status.</span>
                            </li>
                            <li class="d-flex gap-3">
                                <i class="fas fa-calculator mt-1 opacity-75"></i>
                                <span class="small">The <b>Total</b> is calculated in real-time as you adjust subtotal and taxes.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                @if(isset($order))
                    <div class="premium-card sticky-top shadow-lg" style="top: 2rem;">
                        <div class="card-header-premium bg-light">
                            <h3 class="text-dark"><i class="fas fa-receipt me-2"></i>Order Summary</h3>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Order ID</span>
                                <span class="fw-bold text-dark">#{{ $order->order_number ?: substr($order->id, 0, 8) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                                <span class="text-muted small">Client</span>
                                <span class="fw-bold text-dark text-truncate ms-3" style="max-width: 150px;">{{ $order->client_name }}</span>
                            </div>

                            <div class="mb-3">
                                <p class="text-uppercase small fw-bold text-muted mb-2 ls-1" style="font-size: 0.65rem;">Line Items</p>
                                @foreach($order->items as $item)
                                    <div class="d-flex justify-content-between align-items-center mb-2 animate-fade-in">
                                        <div class="d-flex align-items-center flex-1">
                                            <div class="item-dot me-2 bg-primary"></div>
                                            <span class="small text-dark text-truncate pe-2" style="max-width: 130px;">{{ $item->product_name }}</span>
                                            <span class="badge bg-light text-muted fw-normal">x{{ $item->quantity }}</span>
                                        </div>
                                        <span class="small fw-bold text-dark">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="p-3 bg-light rounded-lg">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="small text-muted">Subtotal</span>
                                    <span class="small fw-bold text-dark">${{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small text-muted">Estimated Tax</span>
                                    <span class="small fw-bold text-dark">${{ number_format($order->tax_amount, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between border-top pt-2 mt-2">
                                    <span class="fw-bold text-dark">Total</span>
                                    <span class="fw-bold text-primary fs-5">${{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <style>
            .ls-1 { letter-spacing: 1px; }
            .rounded-lg { border-radius: 12px; }
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
            .bg-primary-light { background-color: rgba(59, 130, 246, 0.1) !important; }

            .item-dot { width: 6px; height: 6px; border-radius: 50%; }
            .shadow-primary { box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3), 0 4px 6px -2px rgba(59, 130, 246, 0.1); }

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
            body.dark-mode .card-header-premium { border-color: var(--dark-border); }
            .card-header-premium h3 { font-size: 1.1rem; font-weight: 700; margin: 0; color: inherit; }

            .card-footer-premium { border-top: 1px solid var(--light-border); }
            body.dark-mode .card-footer-premium { border-color: var(--dark-border); }

            .form-group-premium { margin-bottom: 0px; }
            .form-label-premium { 
                display: block; 
                font-size: 0.85rem; 
                font-weight: 600; 
                margin-bottom: 8px; 
                color: var(--light-muted);
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            body.dark-mode .form-label-premium { color: var(--dark-muted); }

            .form-input-premium, .form-select-premium {
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
            body.dark-mode .form-input-premium, body.dark-mode .form-select-premium {
                background: rgba(255, 255, 255, 0.03);
                border-color: var(--dark-border);
                color: var(--dark-text);
            }

            .form-input-premium:focus, .form-select-premium:focus {
                background: #ffffff;
                border-color: var(--primary);
                box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            }
            body.dark-mode .form-input-premium:focus, body.dark-mode .form-select-premium:focus {
                background: rgba(255, 255, 255, 0.05);
                border-color: var(--primary);
            }

            .select-wrapper, .input-icon-wrapper, .input-group-premium { position: relative; }
            .select-icon, .input-icon {
                position: absolute;
                right: 16px;
                top: 50%;
                transform: translateY(-50%);
                color: var(--light-muted);
                pointer-events: none;
                opacity: 0.7;
            }
            .input-icon { left: 16px; right: auto; }
            .input-icon + .form-input-premium { padding-left: 45px; }

            .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(5px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>

        <script>
            function fillFromOrder(select) {
                const option = select.options[select.selectedIndex];
                if (!option.value) return;

                // Animate changes
                const fields = ['client_id', 'amount', 'tax_amount', 'total_amount', 'currency'];
                fields.forEach(id => {
                    const el = document.getElementById(id);
                    el.style.transition = 'none';
                    el.style.backgroundColor = 'rgba(59, 130, 246, 0.15)';
                    setTimeout(() => {
                        el.style.transition = 'background-color 0.8s ease';
                        el.style.backgroundColor = '';
                    }, 50);
                });

                document.getElementById('client_id').value = option.dataset.client;
                document.getElementById('amount').value = option.dataset.subtotal;
                document.getElementById('tax_amount').value = option.dataset.tax;
                document.getElementById('total_amount').value = option.dataset.total;
                document.getElementById('currency').value = option.dataset.currency;

                // Trigger total calculation just in case
                calculateTotal();

                // Refresh the page with the order_id to show the sidebar if not already present
                if (!window.location.search.includes('order_id=' + option.value)) {
                    window.location.href = "{{ route('admin.invoices.create') }}?order_id=" + option.value;
                }
            }

            function calculateTotal() {
                const amountField = document.getElementById('amount');
                const taxField = document.getElementById('tax_amount');
                const totalField = document.getElementById('total_amount');

                const amount = parseFloat(amountField.value) || 0;
                const tax = parseFloat(taxField.value) || 0;
                const total = (amount + tax).toFixed(2);

                totalField.value = total;

                // Visual feedback for total change
                totalField.parentElement.style.transform = 'scale(1.02)';
                setTimeout(() => {
                    totalField.parentElement.style.transform = 'scale(1)';
                }, 100);
            }
        </script>
@endsection
