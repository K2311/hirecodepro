<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with('client')->latest();

        // Filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%")
                    ->orWhere('client_email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['client', 'items.product', 'invoice']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the specified order.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled,refunded',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'notes' => 'nullable|string',
        ]);

        $order->update($request->only(['status', 'payment_status', 'notes']));

        if ($request->has('file_delivered')) {
            $order->update([
                'file_delivered' => $request->boolean('file_delivered'),
                'delivered_at' => $request->boolean('file_delivered') ? now() : null,
            ]);
        }

        return redirect()->back()->with('success', 'Order updated successfully.');
    }

    /**
     * Bulk update orders.
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'action' => 'required|string',
        ]);

        $ids = $request->order_ids;
        $action = $request->action;

        $count = 0;
        foreach (Order::whereIn('id', $ids)->get() as $order) {
            switch ($action) {
                case 'mark_processing':
                    $order->update(['status' => 'processing']);
                    break;
                case 'mark_completed':
                    $order->update(['status' => 'completed']);
                    break;
                case 'mark_paid':
                    $order->update(['payment_status' => 'paid', 'paid_at' => now()]);
                    break;
                case 'mark_cancelled':
                    $order->update(['status' => 'cancelled']);
                    break;
            }
            $count++;
        }

        return redirect()->back()->with('success', "{$count} orders updated successfully.");
    }

    /**
     * Remove the specified order.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }
}
