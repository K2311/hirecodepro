<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    /**
     * Display a listing of invoices.
     */
    public function index(Request $request)
    {
        $query = Invoice::with(['client', 'order'])->latest();

        // Filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($cq) use ($search) {
                        $cq->where('full_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $invoices = $query->paginate(15);

        return view('admin.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create(Request $request)
    {
        $clients = Client::orderBy('full_name')->get();
        $orders = Order::whereDoesntHave('invoice')->latest()->get();

        $order = null;
        if ($request->has('order_id')) {
            $order = Order::with('client')->find($request->order_id);
        }

        return view('admin.invoices.create', compact('clients', 'orders', 'order'));
    }

    /**
     * Store a newly created invoice in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'nullable|exists:orders,id',
            'client_id' => 'required|exists:clients,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'amount' => 'required|numeric|min:0',
            'tax_amount' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'status' => 'required|in:draft,sent,paid,overdue,cancelled',
            'notes' => 'nullable|string',
        ]);

        $invoiceData = $request->all();
        $invoiceData['invoice_number'] = 'INV-' . strtoupper(Str::random(8));

        $invoice = Invoice::create($invoiceData);

        if ($request->filled('order_id') && $request->status === 'paid') {
            $order = Order::find($request->order_id);
            if ($order && $order->payment_status !== 'paid') {
                $order->update(['payment_status' => 'paid', 'paid_at' => now()]);
            }
        }

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified invoice.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['client', 'order.items.product']);
        return view('admin.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified invoice.
     */
    public function edit(Invoice $invoice)
    {
        $clients = Client::orderBy('full_name')->get();
        return view('admin.invoices.edit', compact('invoice', 'clients'));
    }

    /**
     * Update the specified invoice in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'amount' => 'required|numeric|min:0',
            'tax_amount' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'status' => 'required|in:draft,sent,paid,overdue,cancelled',
            'notes' => 'nullable|string',
        ]);

        $invoice->update($request->all());

        if ($invoice->order_id && $request->status === 'paid') {
            $order = Order::find($invoice->order_id);
            if ($order && $order->payment_status !== 'paid') {
                $order->update(['payment_status' => 'paid', 'paid_at' => now()]);
            }
        }

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified invoice from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('admin.invoices.index')->with('success', 'Invoice deleted successfully.');
    }

    /**
     * Generate invoice from order.
     */
    public function generateFromOrder(Order $order)
    {
        if ($order->invoice) {
            return redirect()->route('admin.invoices.show', $order->invoice)->with('info', 'Invoice already exists for this order.');
        }

        $invoice = Invoice::create([
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
            'order_id' => $order->id,
            'client_id' => $order->client_id,
            'issue_date' => now(),
            'due_date' => now()->addDays(7),
            'amount' => $order->subtotal,
            'tax_amount' => $order->tax_amount,
            'total_amount' => $order->total_amount,
            'currency' => $order->currency,
            'status' => $order->payment_status === 'paid' ? 'paid' : 'sent',
            'paid_at' => $order->paid_at,
        ]);

        return redirect()->route('admin.invoices.show', $invoice)->with('success', 'Invoice generated from order.');
    }
}
