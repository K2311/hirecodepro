<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * Download a file from an order.
     */
    public function download(Request $request, Order $order, OrderItem $item)
    {
        // 1. Verify security (Order must belong to the email provided during checkout if guest, 
        // or just verify order status and association for this simple implementation)

        // Ensure order is paid/completed
        if ($order->payment_status !== 'paid' && $order->status !== 'completed') {
            abort(403, 'Order not paid or completed.');
        }

        // Verify item belongs to order
        if ($item->order_id !== $order->id) {
            abort(404, 'Item not found in this order.');
        }

        // Get the main file for the product
        $file = ProductFile::where('product_id', $item->product_id)
            ->where('is_main_file', true)
            ->first();

        if (!$file) {
            // Check if there are any files if no main file is marked
            $file = ProductFile::where('product_id', $item->product_id)->first();
        }

        if (!$file || !$file->file_path) {
            abort(404, 'No download file found for this product.');
        }

        // Increment download count
        $file->incrementDownloadCount();
        $item->product->increment('download_count');

        // Check if file is stored in public or storage
        // Assuming asset based URLs were used in previous implementation, 
        // they might be in public/uploads/

        $path = $file->file_path;

        // If it's a full URL, we might need to handle it differently, 
        // but ideally it's a path.
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return redirect($path);
        }

        if (Storage::disk('public')->exists($path)) {
            $fullPath = Storage::disk('public')->path($path);
            return response()->download($fullPath, $file->file_name);
        }

        return redirect($path); // Fallback to redirection if it's a URL or direct path
    }
}
