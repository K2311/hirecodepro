<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('admin.partials.sidebar', function ($view) {
            $view->with('newInquiriesCount', \App\Models\ContactInquiry::where('status', 'new')->count());
            $view->with('newQuotesCount', \App\Models\QuoteRequest::where('status', 'new')->count());
            $view->with('pendingOrdersCount', \App\Models\Order::where('status', 'pending')->count());
        });
    }
}
