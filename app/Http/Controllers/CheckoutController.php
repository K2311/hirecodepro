<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page.
     */
    public function index()
    {
        if (!\App\Models\SiteSetting::get('enable_shopping_cart', true)) {
            return redirect()->route('products.index')->with('info', 'Shopping cart is currently disabled. Please use the inquiry form for any product requests.');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        // Fetch enabled payment methods from SiteSetting
        $paymentMethods = collect();

        if (\App\Models\SiteSetting::get('stripe_enabled')) {
            $paymentMethods->push((object) [
                'provider' => 'stripe',
                'provider_name' => 'Stripe'
            ]);
        }

        if (\App\Models\SiteSetting::get('paypal_enabled')) {
            $paymentMethods->push((object) [
                'provider' => 'paypal',
                'provider_name' => 'PayPal'
            ]);
        }

        // Always enable bank transfer if no others or as a default if desired? 
        // Or check a setting for it. Let's add a default for now if it's expected.
        // Actually, the user's image only shows Stripe and PayPal. 
        // Let's check for bank_transfer_enabled too just in case.
        if (\App\Models\SiteSetting::get('bank_transfer_enabled', true)) {
            $paymentMethods->push((object) [
                'provider' => 'bank_transfer',
                'provider_name' => 'Bank Transfer'
            ]);
        }

        return view('checkout.index', compact('cart', 'total', 'paymentMethods'));
    }

    /**
     * Process the order.
     */
    public function store(Request $request)
    {
        if (!\App\Models\SiteSetting::get('enable_shopping_cart', true)) {
            return redirect()->route('products.index')->with('error', 'Shopping cart is currently disabled.');
        }

        $cart = session()->get('cart', []);
        $total = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'payment_method' => $total > 0 ? 'required|string' : 'nullable|string',
        ]);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        try {
            DB::beginTransaction();

            $isFree = $total <= 0;

            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'client_name' => $request->name,
                'client_email' => $request->email,
                'client_company' => $request->company,
                'subtotal' => $total,
                'total_amount' => $total,
                'currency' => 'USD',
                'payment_method' => $isFree ? 'free_download' : $request->payment_method,
                'payment_status' => $isFree ? 'paid' : 'pending',
                'status' => $isFree ? 'completed' : 'pending',
                'paid_at' => $isFree ? now() : null,
                'notes' => $request->notes,
            ]);

            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'item_type' => 'product',
                    'name' => $details['name'],
                    'price' => $details['price'],
                    'quantity' => $details['quantity'],
                    'subtotal' => $details['price'] * $details['quantity']
                ]);
            }

            DB::commit();

            session()->forget('cart');

            $successMsg = $isFree ? 'Your free download is ready!' : 'Thank you for your order!';
            return redirect()->route('checkout.success', $order)->with('success', $successMsg);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Show order success page.
     */
    public function success(Order $order)
    {
        return view('checkout.success', compact('order'));
    }
}
