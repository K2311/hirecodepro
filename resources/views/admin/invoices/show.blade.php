@extends('admin.layouts.app')

@section('title', 'Invoice Details | CodeCraft Studio')
@section('page-title', 'Invoice Details')

@section('content')
    <div class="page-header d-print-none mb-4">
        <div class="page-title">
            <h1 class="fw-bold"><i class="fas fa-file-invoice me-2 text-primary"></i>Invoice #{{ $invoice->invoice_number }}
            </h1>
            <p class="text-muted small">Issued on {{ $invoice->issue_date->format('M d, Y') }}</p>
        </div>
        <div class="page-actions d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-dark px-4 rounded-pill">
                <i class="fas fa-print me-2"></i> Print PDF
            </button>
            <a href="{{ route('admin.invoices.edit', $invoice) }}" class="btn btn-primary px-4 rounded-pill shadow-sm">
                <i class="fas fa-edit me-2"></i> Edit Invoice
            </a>
            <a href="{{ route('admin.invoices.index') }}" class="btn btn-link text-muted text-decoration-none">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="invoice-wrapper mx-auto" style="max-width: 1000px;">
        <div class="premium-invoice-card shadow-lg border-0 rounded-4 overflow-hidden mb-5 bg-white">
            <!-- Header section with modern design -->
            <div class="invoice-header p-5 border-bottom position-relative">
                <div class="header-accent"
                    style="position: absolute; top: 0; left: 0; right: 0; height: 6px; background: linear-gradient(90deg, #3b82f6 0%, #a855f7 100%);">
                </div>
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="invoice-brand d-flex align-items-center mb-2">
                            <div class="brand-box me-3 bg-primary text-white p-2 rounded-3">
                                <i class="fas fa-code-branch fs-3"></i>
                            </div>
                            <div>
                                <h3 class="fw-black mb-0 text-dark" style="font-weight: 900; letter-spacing: -0.5px;">
                                    CODECRAFT <span class="text-primary">STUDIO</span></h3>
                                <p class="text-muted small fw-bold mb-0 text-uppercase ls-1" style="letter-spacing: 1px;">
                                    Elite Web Solutions</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h1 class="text-uppercase fw-black text-muted opacity-25 mb-0"
                            style="font-weight: 900; letter-spacing: 2px;">INVOICE</h1>
                        <div class="fw-bold fs-4 text-dark mb-1">#{{ $invoice->invoice_number }}</div>
                        <span class="status-badge-lg inv-{{ $invoice->status }} px-3 py-1 rounded-pill fw-bold small"
                            style="letter-spacing: 1.5px; text-transform: uppercase;">
                            {{ $invoice->status }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Client & Vendor details -->
            <div class="p-5">
                <div class="row g-4 mb-5">
                    <div class="col-sm-6">
                        <h6 class="text-primary text-uppercase small fw-black mb-4 ls-1"
                            style="font-weight: 900; letter-spacing: 1px;">From Business</h6>
                        <div class="vendor-details p-4 rounded-4 border bg-light">
                            <h5 class="fw-bold text-dark mb-2">CodeCraft Studio Inc.</h5>
                            <ul class="list-unstyled mb-0 text-muted small">
                                <li class="mb-1"><i class="fas fa-map-marker-alt me-2 text-primary opacity-50"></i> 123 Tech
                                    Avenue, Silicon Valley, CA 94025</li>
                                <li class="mb-1"><i class="fas fa-envelope me-2 text-primary opacity-50"></i>
                                    billing@codecraft.com</li>
                                <li><i class="fas fa-globe me-2 text-primary opacity-50"></i> www.codecraft-studio.com</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h6 class="text-primary text-uppercase small fw-black mb-4 ls-1"
                            style="font-weight: 900; letter-spacing: 1px;">Bill To Client</h6>
                        <div class="client-details p-4 rounded-4 border border-primary bg-white shadow-sm"
                            style="--bs-border-opacity: .2;">
                            <h5 class="fw-bold text-dark mb-2">
                                {{ $invoice->client->full_name ?? ($invoice->order->client_name ?? 'N/A') }}
                            </h5>
                            <ul class="list-unstyled mb-0 text-muted small">
                                <li class="mb-1"><i class="fas fa-envelope me-2 text-primary opacity-50"></i>
                                    {{ $invoice->client->email ?? ($invoice->order->client_email ?? 'N/A') }}</li>
                                @if($invoice->client && $invoice->client->company)
                                    <li class="mb-1"><i class="fas fa-building me-2 text-primary opacity-50"></i>
                                        {{ $invoice->client->company }}</li>
                                @elseif($invoice->order && $invoice->order->client_company)
                                    <li class="mb-1"><i class="fas fa-building me-2 text-primary opacity-50"></i>
                                        {{ $invoice->order->client_company }}</li>
                                @endif
                                <li><i class="fas fa-tag me-2 text-primary opacity-50"></i> ID:
                                    C-{{ str_pad($invoice->client_id ?? 0, 4, '0', STR_PAD_LEFT) }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Meta bar -->
                <div class="invoice-meta-bar row g-0 rounded-4 overflow-hidden mb-5 border shadow-sm">
                    <div class="col-md-3 border-end">
                        <div class="p-4 text-center">
                            <div class="text-muted small text-uppercase fw-bold mb-1">Issue Date</div>
                            <div class="fw-bold text-dark">{{ $invoice->issue_date->format('M d, Y') }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 border-end">
                        <div class="p-4 text-center">
                            <div class="text-muted small text-uppercase fw-bold mb-1">Due Date</div>
                            <div class="fw-bold text-dark">{{ $invoice->due_date->format('M d, Y') }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 border-end">
                        <div class="p-4 text-center">
                            <div class="text-muted small text-uppercase fw-bold mb-1">Pay Method</div>
                            <div class="fw-bold text-dark">
                                @if($invoice->order)
                                    {{ strtoupper(str_replace('_', ' ', $invoice->order->payment_method)) }}
                                @else
                                    <span class="text-muted opacity-50">MANUAL</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-4 text-center bg-primary text-white">
                            <div class="small text-uppercase fw-bold mb-1 opacity-75">Related Order</div>
                            <div class="fw-bold">
                                @if($invoice->order)
                                    #{{ $invoice->order->order_number ?: substr($invoice->order->id, 0, 8) }}
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product table -->
                <div class="table-responsive mb-5">
                    <table class="table premium-summary-table align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Description of Service</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end pe-4">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($invoice->order && $invoice->order->items->count() > 0)
                                @foreach($invoice->order->items as $item)
                                    <tr>
                                        <td class="ps-4 py-4">
                                            <div class="fw-bold text-dark">{{ $item->product_name }}</div>
                                            <span class="text-muted small">Standard Platform License</span>
                                        </td>
                                        <td class="text-center text-dark fw-medium">{{ $item->quantity }}</td>
                                        <td class="text-end text-muted font-monospace">${{ number_format($item->price, 2) }}</td>
                                        <td class="text-end pe-4 fw-bold text-dark font-monospace">
                                            ${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="ps-4 py-4">
                                        <div class="fw-bold text-dark">Custom Services / Solutions</div>
                                        <span class="text-muted small">Consulting and technical implementation</span>
                                    </td>
                                    <td class="text-center text-dark fw-medium">1</td>
                                    <td class="text-end text-muted font-monospace">${{ number_format($invoice->amount, 2) }}
                                    </td>
                                    <td class="text-end pe-4 fw-bold text-dark font-monospace">
                                        ${{ number_format($invoice->amount, 2) }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Totals section -->
                <div class="row justify-content-between align-items-center mt-5">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        @if($invoice->notes)
                            <div class="notes-box p-4 rounded-4 bg-light border border-dashed">
                                <h6 class="text-dark fw-bold text-uppercase small mb-2"><i
                                        class="fas fa-info-circle me-2 text-primary"></i>Terms & Conditions</h6>
                                <p class="text-muted small mb-0 lh-base" style="font-style: italic;">{{ $invoice->notes }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-5">
                        <div class="total-summary p-4 rounded-4 bg-dark text-white shadow-lg">
                            <div class="d-flex justify-content-between mb-3 opacity-75 small">
                                <span>SUBTOTAL</span>
                                <span class="fw-bold font-monospace">${{ number_format($invoice->amount, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 opacity-75 small">
                                <span>TAX ESTIMATE (0%)</span>
                                <span class="fw-bold font-monospace">${{ number_format($invoice->tax_amount, 2) }}</span>
                            </div>
                            <div class="border-top border-secondary my-3 opacity-25"></div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold fs-5">TOTAL DUE</span>
                                <div class="text-end">
                                    <div class="fs-3 fw-bold">{{ $invoice->currency }}
                                        {{ number_format($invoice->total_amount, 2) }}
                                    </div>
                                    <span class="badge bg-primary rounded-pill small px-3">SECURE</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer with contact info -->
            <div class="p-5 bg-light border-top d-print-none">
                <div class="row text-center text-md-start">
                    <div class="col-md-8 mb-3 mb-md-0">
                        <h6 class="fw-bold text-dark mb-1">Need assistance with this invoice?</h6>
                        <p class="text-muted small mb-0">Please contact our finance team at support@codecraft-studio.com</p>
                    </div>
                    <div class="col-md-4 text-md-end text-muted">
                        <div class="d-flex justify-content-md-end gap-3">
                            <i class="fab fa-linkedin fs-5"></i>
                            <i class="fab fa-twitter fs-5"></i>
                            <i class="fab fa-github fs-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .inv-paid {
            background: #dcfce7;
            color: #166534;
        }

        .inv-sent {
            background: #e0f2fe;
            color: #0369a1;
        }

        .inv-overdue {
            background: #fee2e2;
            color: #991b1b;
        }

        .inv-draft {
            background: #f1f5f9;
            color: #475569;
        }

        .premium-summary-table thead th {
            border: 0;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 1px;
            color: #64748b;
        }

        .font-monospace {
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
        }

        @media print {

            /* Hide UI elements */
            .admin-sidebar,
            .admin-header,
            .page-header,
            .d-print-none,
            .sidebar-footer,
            .admin-footer,
            .sidebar,
            .navbar {
                display: none !important;
            }

            /* Reset layout for print */
            body,
            html {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
                height: auto !important;
                overflow: visible !important;
            }

            .admin-container {
                display: block !important;
                height: auto !important;
            }

            .admin-main {
                margin: 0 !important;
                padding: 0 !important;
                display: block !important;
                height: auto !important;
            }

            .admin-content {
                padding: 0 !important;
                margin: 0 !important;
                overflow: visible !important;
                display: block !important;
            }

            .invoice-wrapper {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
            }

            .premium-invoice-card {
                box-shadow: none !important;
                border: 0 !important;
                border-radius: 0 !important;
                margin: 0 !important;
            }

            .rounded-4 {
                border-radius: 0 !important;
            }

            .p-5 {
                padding: 2rem !important;
            }

            /* Ensure colors print correctly */
            .bg-dark {
                background-color: #1e293b !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .bg-primary {
                background-color: #3b82f6 !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .text-primary {
                color: #3b82f6 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .bg-light {
                background-color: #f8fafc !important;
                color: #0f172a !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            @page {
                margin: 1cm;
                size: portrait;
            }
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.has('print')) {
                    setTimeout(() => { window.print(); }, 500);
                }
            });
        </script>
    @endpush
@endsection