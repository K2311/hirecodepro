<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Models\QuoteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // 1. Overview Statistics
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $totalOrders = Order::count();
        $totalClients = Client::count();
        $totalProducts = Product::count();

        // 2. Revenue Trends (Last 12 months)
        $revenueByMonth = Order::where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(12))
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // 3. Top Products
        $topProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();

        // 4. Recent Orders
        $recentOrders = Order::with('client')
            ->latest()
            ->take(10)
            ->get();

        // 5. Order Status Distribution
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // 6. Client Growth (Last 12 months)
        $clientGrowth = Client::where('created_at', '>=', now()->subMonths(12))
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // 7. Invoice Statistics
        $invoiceStats = [
            'total' => Invoice::count(),
            'paid' => Invoice::where('status', 'paid')->count(),
            'pending' => Invoice::where('status', 'sent')->count(),
            'overdue' => Invoice::where('status', 'overdue')->count(),
            'total_paid_amount' => Invoice::where('status', 'paid')->sum('total_amount'),
        ];

        // 8. Quote Request Statistics
        $quoteStats = [
            'total' => QuoteRequest::count(),
            'pending' => QuoteRequest::where('status', 'pending')->count(),
            'converted' => QuoteRequest::where('status', 'converted')->count(),
            'rejected' => QuoteRequest::where('status', 'rejected')->count(),
            'num_quotes_amount' => QuoteRequest::whereNotNull('quoted_amount')->count(),
            'total_quoted_amount' => QuoteRequest::sum('quoted_amount'),
        ];

        // 9. Service Distribution (from Quote Requests Project Types)
        $servicesRequested = QuoteRequest::select('project_type', DB::raw('count(*) as count'))
            ->groupBy('project_type')
            ->get();

        // 10. Individual Service Performance (Parsing services_needed array)
        $allQuoteRequests = QuoteRequest::whereNotNull('services_needed')->get();
        $serviceBreakdown = [];
        foreach ($allQuoteRequests as $req) {
            $services = is_array($req->services_needed) ? $req->services_needed : json_decode($req->services_needed, true) ?? [];
            foreach ($services as $service) {
                $serviceBreakdown[$service] = ($serviceBreakdown[$service] ?? 0) + 1;
            }
        }
        arsort($serviceBreakdown);
        $topAddonServices = array_slice($serviceBreakdown, 0, 8, true);

        // 11. Geographical Data (Clients by Country)
        $clientsByCountry = Client::select('country', DB::raw('count(*) as count'))
            ->whereNotNull('country')
            ->groupBy('country')
            ->orderBy('count', 'desc')
            ->take(6)
            ->get();

        // 12. Revenue by Country (Joined with Orders)
        $revenueByCountry = DB::table('orders')
            ->join('clients', 'orders.client_id', '=', 'clients.id')
            ->where('orders.status', 'completed')
            ->select('clients.country', DB::raw('SUM(orders.total_amount) as total_revenue'))
            ->groupBy('clients.country')
            ->orderBy('total_revenue', 'desc')
            ->take(5)
            ->get();

        // 13. Top Clients by Revenue (Fixed missing definition)
        $topClients = Client::withSum([
            'orders' => function ($query) {
                $query->where('status', 'completed');
            }
        ], 'total_amount')
            ->orderBy('orders_sum_total_amount', 'desc')
            ->take(5)
            ->get();

        return view('admin.analytics.index', compact(
            'totalRevenue',
            'totalOrders',
            'totalClients',
            'totalProducts',
            'revenueByMonth',
            'topProducts',
            'recentOrders',
            'ordersByStatus',
            'clientGrowth',
            'invoiceStats',
            'topClients',
            'quoteStats',
            'servicesRequested',
            'topAddonServices',
            'clientsByCountry',
            'revenueByCountry'
        ));
    }
}
