<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'creator']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        // Filter by featured
        if ($request->has('featured') && $request->featured === '1') {
            $query->where('is_featured', true);
        }

        // Sort functionality
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        $query->orderBy($sortBy, $sortDirection);

        $products = $query->paginate(15);
        $categories = ProductCategory::active()->ordered()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::active()->ordered()->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'short_description' => 'required|string|max:300',
            'full_description' => 'nullable|string',
            'category_id' => 'required|exists:product_categories,id',
            'product_type' => 'required|in:code,template,api,plugin,tool,ebook',
            'base_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'is_featured' => 'boolean',
            'is_on_sale' => 'boolean',
            'status' => 'required|in:draft,active,archived',
            'tech_stack' => 'nullable|array',
            'tech_stack.*' => 'string|max:100',
            'features' => 'nullable|string',
            'dependencies' => 'nullable|string',
            'requirements' => 'nullable|string',
            'version' => 'required|string|max:20',
            'changelog' => 'nullable|string',
            'cover_image_url' => 'nullable|string',
            'demo_url' => 'nullable|url',
            'documentation_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'preview_images' => 'nullable',
            'license_type' => 'required|string|max:50',
            'license_terms' => 'nullable|string',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:300',
            'meta_keywords' => 'nullable|string|max:500',
            'published_at' => 'nullable|date',
        ]);

        // Additional validation: sale price should be less than base price
        if ($request->has('sale_price') && $request->sale_price > 0) {
            if ($request->sale_price >= $request->base_price) {
                return redirect()->back()
                    ->withErrors(['sale_price' => 'Sale price must be less than base price'])
                    ->withInput();
            }
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Ensure unique slug
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Product::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        $validated['created_by'] = auth()->id();

        // Handle preview_images (gallery) - encode as JSON
        if ($request->has('preview_images')) {
            try {
                $previewImages = json_decode($request->input('preview_images'), true);
                if (is_array($previewImages)) {
                    $validated['preview_images'] = json_encode($previewImages);
                }
            } catch (\Exception $e) {
                // If JSON decode fails, use empty array
                $validated['preview_images'] = json_encode([]);
            }
        }

        // Handle tech_stack - encode as JSON
        if ($request->has('tech_stack')) {
            $techStack = $request->input('tech_stack');
            if (is_array($techStack)) {
                // Filter out empty values and encode as JSON
                $techStack = array_values(array_filter($techStack, function ($item) {
                    return !empty(trim($item));
                }));
                $validated['tech_stack'] = json_encode($techStack);
            }
        }

        // Set published_at if status is active and not set
        if ($validated['status'] === 'active' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Convert checkbox values to boolean
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_on_sale'] = $request->has('is_on_sale');

        // Handle nullable fields - set to null if empty
        $nullableFields = [
            'sale_price',
            'cost_price',
            'dependencies',
            'requirements',
            'changelog',
            'demo_url',
            'documentation_url',
            'github_url',
            'license_terms',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'full_description',
            'features'
        ];

        foreach ($nullableFields as $field) {
            if (isset($validated[$field]) && empty(trim($validated[$field]))) {
                $validated[$field] = null;
            }
        }

        // Set defaults
        $validated['view_count'] = 0;
        $validated['download_count'] = 0;
        $validated['purchase_count'] = 0;
        $validated['average_rating'] = 0;

        // Ensure version has a default if empty
        if (empty($validated['version'])) {
            $validated['version'] = '1.0.0';
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'creator', 'variations', 'files']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::active()->ordered()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('products')->ignore($product->id)],
            'short_description' => 'required|string|max:300',
            'full_description' => 'nullable|string',
            'category_id' => 'required|exists:product_categories,id',
            'product_type' => 'required|in:code,template,api,plugin,tool,ebook',
            'base_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'is_featured' => 'boolean',
            'is_on_sale' => 'boolean',
            'status' => 'required|in:draft,active,archived',
            'tech_stack' => 'nullable|array',
            'tech_stack.*' => 'string|max:100',
            'features' => 'nullable|string',
            'dependencies' => 'nullable|string',
            'requirements' => 'nullable|string',
            'version' => 'required|string|max:20',
            'changelog' => 'nullable|string',
            'cover_image_url' => 'nullable|string',
            'demo_url' => 'nullable|url',
            'documentation_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'preview_images' => 'nullable',
            'license_type' => 'required|string|max:50',
            'license_terms' => 'nullable|string',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:300',
            'meta_keywords' => 'nullable|string|max:500',
            'published_at' => 'nullable|date',
        ]);

        // Additional validation: sale price should be less than base price
        if ($request->has('sale_price') && $request->sale_price > 0) {
            if ($request->sale_price >= $request->base_price) {
                return redirect()->back()
                    ->withErrors(['sale_price' => 'Sale price must be less than base price'])
                    ->withInput();
            }
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Ensure unique slug
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Product::where('slug', $validated['slug'])->where('id', '!=', $product->id)->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle preview_images - decode JSON if it's a string
        if ($request->has('preview_images')) {
            try {
                $previewImages = $request->input('preview_images');
                if (is_string($previewImages)) {
                    $previewImages = json_decode($previewImages, true);
                }
                if (is_array($previewImages)) {
                    $validated['preview_images'] = json_encode($previewImages);
                }
            } catch (\Exception $e) {
                $validated['preview_images'] = json_encode([]);
            }
        }

        // Handle tech_stack - encode as JSON
        if ($request->has('tech_stack')) {
            $techStack = $request->input('tech_stack');
            if (is_array($techStack)) {
                // Filter out empty values and encode as JSON
                $techStack = array_values(array_filter($techStack, function ($item) {
                    return !empty(trim($item));
                }));
                $validated['tech_stack'] = json_encode($techStack);
            }
        } else {
            $validated['tech_stack'] = null;
        }

        // Set published_at if status is active and not set
        if ($validated['status'] === 'active' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Convert checkbox values to boolean
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_on_sale'] = $request->has('is_on_sale');

        // Handle nullable fields
        $nullableFields = [
            'sale_price',
            'cost_price',
            'dependencies',
            'requirements',
            'changelog',
            'demo_url',
            'documentation_url',
            'github_url',
            'license_terms',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'full_description',
            'features'
        ];

        foreach ($nullableFields as $field) {
            if (isset($validated[$field]) && empty(trim($validated[$field]))) {
                $validated[$field] = null;
            }
        }

        // Ensure version has a value
        if (empty($validated['version'])) {
            $validated['version'] = '1.0.0';
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Check if product has orders
        if ($product->orderItems()->exists()) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Cannot delete product with existing orders.');
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);

        return response()->json([
            'success' => true,
            'is_featured' => $product->is_featured,
            'message' => $product->is_featured ? 'Product marked as featured.' : 'Product removed from featured.'
        ]);
    }

    /**
     * Toggle sale status
     */
    public function toggleSale(Product $product)
    {
        $product->update(['is_on_sale' => !$product->is_on_sale]);

        return response()->json([
            'success' => true,
            'is_on_sale' => $product->is_on_sale,
            'message' => $product->is_on_sale ? 'Product put on sale.' : 'Product removed from sale.'
        ]);
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:delete,activate,deactivate,feature,unfeature',
            'products' => 'required|array',
            'products.*' => 'exists:products,id'
        ]);

        $products = Product::whereIn('id', $request->products)->get();

        switch ($request->action) {
            case 'delete':
                // Check if any products have orders
                $productsWithOrders = $products->filter(function ($product) {
                    return $product->orderItems()->exists();
                });

                if ($productsWithOrders->count() > 0) {
                    return redirect()->back()
                        ->with('error', 'Cannot delete products with existing orders.');
                }

                Product::whereIn('id', $request->products)->delete();
                $message = 'Products deleted successfully.';
                break;

            case 'activate':
                Product::whereIn('id', $request->products)
                    ->update(['status' => 'active', 'published_at' => now()]);
                $message = 'Products activated successfully.';
                break;

            case 'deactivate':
                Product::whereIn('id', $request->products)
                    ->update(['status' => 'inactive']);
                $message = 'Products deactivated successfully.';
                break;

            case 'feature':
                Product::whereIn('id', $request->products)
                    ->update(['is_featured' => true]);
                $message = 'Products marked as featured.';
                break;

            case 'unfeature':
                Product::whereIn('id', $request->products)
                    ->update(['is_featured' => false]);
                $message = 'Products removed from featured.';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Handle media file upload via AJAX
     */
    public function uploadMedia(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,webp,mp4,webm,ogg|max:51200', // 50MB
        ]);

        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                // Store the file in 'public/uploads/products'
                $path = Storage::disk('public')->putFileAs('products', $file, $filename);

                // Return the URL using asset() which handles port/host correctly
                $url = asset('uploads/' . $path);

                return response()->json([
                    'success' => true,
                    'url' => $url, // Now returns full absolute URL matching current host
                    'message' => 'File uploaded successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No file provided'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload error: ' . $e->getMessage()
            ], 500);
        }
    }
}

