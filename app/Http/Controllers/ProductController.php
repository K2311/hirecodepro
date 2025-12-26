<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products (Shop page).
     */
    public function index(Request $request)
    {
        $query = Product::published();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('tech_stack', 'like', "%{$search}%");
            });
        }

        // Category/Type filter
        if ($request->filled('type')) {
            $query->where('product_type', $request->type);
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('base_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('base_price', '<=', $request->max_price);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('base_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('base_price', 'desc');
                break;
            case 'popular':
                $query->orderBy('download_count', 'desc');
                break;
            default:
                $query->orderBy('is_featured', 'desc')->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        // Get unique types for filter sidebar
        $productTypes = Product::published()->distinct()->pluck('product_type')->filter();

        return view('products.index', compact('products', 'productTypes'));
    }

    /**
     * Display the public product page.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'variations', 'files']);
        return view('products.show', compact('product'));
    }
}
