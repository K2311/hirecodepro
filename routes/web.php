<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\PortfolioProjectController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\ContactController;

// Public Routes
Route::get('/', function () {
    $products = \App\Models\Product::published()
        ->orderBy('is_featured', 'desc')
        ->latest()
        ->take(30)
        ->get();
    $services = \App\Models\Service::active()->ordered()->take(6)->get();
    $portfolioProjects = \App\Models\PortfolioProject::published()->featured()->orderBy('sort_order')->take(6)->get();
    $testimonials = \App\Models\ProjectTestimonial::with('project')->latest()->take(6)->get();
    $blogPosts = \App\Models\BlogPost::published()->latest()->take(3)->get();

    return view('home', compact('products', 'services', 'portfolioProjects', 'testimonials', 'blogPosts'));
});

// Blog Routes
Route::get('/blog', [\App\Http\Controllers\BlogPostController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [\App\Http\Controllers\BlogPostController::class, 'show'])->name('blog.show');

// Download route
Route::get('/download/{order}/{item}', [\App\Http\Controllers\DownloadController::class, 'download'])->name('download.order.item');

// Public product routes
Route::get('/shop', [\App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contact/success', [ContactController::class, 'success'])->name('contact.success');

Route::get('/get-quote', [\App\Http\Controllers\QuoteController::class, 'index'])->name('quote.index');
Route::post('/get-quote', [\App\Http\Controllers\QuoteController::class, 'store'])->name('quote.store');

// Cart Routes
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{id}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');

// Checkout Routes
Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{order}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Protected Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'App\Http\Middleware\IsAdmin'])->group(function () {

    // Dashboard
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');

    // Resources
    Route::resource('products', ProductController::class);
    Route::post('products/upload-media', [ProductController::class, 'uploadMedia'])->name('products.upload-media');
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::post('categories/{category}/toggle-active', [\App\Http\Controllers\Admin\CategoryController::class, 'toggleActive'])->name('categories.toggle-active');
    Route::post('products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
    Route::post('products/{product}/toggle-sale', [ProductController::class, 'toggleSale'])->name('products.toggle-sale');
    Route::post('products/bulk-action', [ProductController::class, 'bulkAction'])->name('products.bulk-action');
    Route::post('orders/bulk-update', [\App\Http\Controllers\Admin\OrderController::class, 'bulkUpdate'])->name('orders.bulk-update');
    Route::resource('orders', OrderController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('services', ServiceController::class);
    Route::post('services/{service}/toggle-featured', [ServiceController::class, 'toggleFeatured'])->name('services.toggle-featured');
    Route::post('services/{service}/toggle-active', [ServiceController::class, 'toggleActive'])->name('services.toggle-active');
    Route::resource('blog', BlogPostController::class)->names([
        'index' => 'blog-posts.index',
        'create' => 'blog-posts.create',
        'store' => 'blog-posts.store',
        'edit' => 'blog-posts.edit',
        'update' => 'blog-posts.update',
        'destroy' => 'blog-posts.destroy',
        'show' => 'blog-posts.show',
    ]);
    Route::post('blog/upload-media', [BlogPostController::class, 'uploadMedia'])->name('blog-posts.upload-media');
    Route::resource('blog-categories', \App\Http\Controllers\Admin\BlogCategoryController::class);
    Route::post('portfolio/upload-media', [PortfolioProjectController::class, 'uploadMedia'])->name('portfolio.upload-media');
    Route::resource('portfolio', PortfolioProjectController::class);
    // Emails & Templates
    Route::get('emails/templates', [\App\Http\Controllers\Admin\EmailController::class, 'templates'])->name('emails.templates');
    Route::get('emails/templates/create', [\App\Http\Controllers\Admin\EmailController::class, 'createTemplate'])->name('emails.templates.create');
    Route::post('emails/templates', [\App\Http\Controllers\Admin\EmailController::class, 'storeTemplate'])->name('emails.templates.store');
    Route::get('emails/templates/{id}/edit', [\App\Http\Controllers\Admin\EmailController::class, 'editTemplate'])->name('emails.templates.edit');
    Route::put('emails/templates/{id}', [\App\Http\Controllers\Admin\EmailController::class, 'updateTemplate'])->name('emails.templates.update');
    Route::delete('emails/templates/{id}', [\App\Http\Controllers\Admin\EmailController::class, 'deleteTemplate'])->name('emails.templates.delete');
    Route::resource('emails', \App\Http\Controllers\Admin\EmailController::class)->only(['index', 'show', 'destroy']);
    Route::resource('invoices', \App\Http\Controllers\Admin\InvoiceController::class);
    Route::post('orders/{order}/generate-invoice', [\App\Http\Controllers\Admin\InvoiceController::class, 'generateFromOrder'])->name('orders.generate-invoice');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('inquiries', InquiryController::class)->except(['create', 'store', 'edit', 'destroy']);
    Route::resource('quotes', \App\Http\Controllers\Admin\QuoteRequestController::class);

    // Quote specific routes
    Route::post('quotes/{quote}/assign', [\App\Http\Controllers\Admin\QuoteRequestController::class, 'assign'])->name('quotes.assign');
    Route::post('quotes/bulk-update', [\App\Http\Controllers\Admin\QuoteRequestController::class, 'bulkUpdate'])->name('quotes.bulk-update');

    // Inquiry specific routes
    Route::post('inquiries/{inquiry}/assign', [InquiryController::class, 'assign'])->name('inquiries.assign');
    Route::post('inquiries/{inquiry}/reply', [InquiryController::class, 'reply'])->name('inquiries.reply');
    Route::post('inquiries/bulk-update', [InquiryController::class, 'bulkUpdate'])->name('inquiries.bulk-update');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/reset-colors', [SettingController::class, 'resetColors'])->name('settings.reset-colors');
    Route::post('/settings/remove-image', [SettingController::class, 'removeImage'])->name('settings.remove-image');

    // Profile
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
});
