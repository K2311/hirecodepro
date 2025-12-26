<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart contents.
     */
    public function index()
    {
        if (!\App\Models\SiteSetting::get('enable_shopping_cart', true)) {
            return redirect()->route('products.index')->with('info', 'Shopping cart is currently disabled. Please use the inquiry form for any product requests.');
        }

        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Product $product, Request $request)
    {
        if (!\App\Models\SiteSetting::get('enable_shopping_cart', true)) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Shopping cart is currently disabled.'
                ], 403);
            }
            return redirect()->route('products.index')->with('error', 'Shopping cart is currently disabled.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->current_price,
                "image" => $product->cover_image_url,
                "id" => $product->id
            ];
        }

        session()->put('cart', $cart);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cart_count' => count($cart)
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, $id)
    {
        if ($id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
        return redirect()->back();
    }

    /**
     * Remove item from cart.
     */
    public function remove($id)
    {
        if ($id) {
            $cart = session()->get('cart');
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
        return redirect()->back();
    }
}
