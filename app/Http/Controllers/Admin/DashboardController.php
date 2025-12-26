<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Overview Statistics
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $totalOrders = Order::count();
        $totalClients = Client::count();
        $totalProducts = Product::count();

        // Revenue Trends (Last 12 months)
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

        // Top Products
        $topProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();

        // Recent Orders
        $recentOrders = Order::with('client')
            ->latest()
            ->take(10)
            ->get();

        // Order Status Distribution
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Client Growth (Last 12 months)
        $clientGrowth = Client::where('created_at', '>=', now()->subMonths(12))
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Invoice Statistics
        $invoiceStats = [
            'total' => Invoice::count(),
            'paid' => Invoice::where('status', 'paid')->count(),
            'pending' => Invoice::where('status', 'sent')->count(),
            'overdue' => Invoice::where('status', 'overdue')->count(),
            'total_paid_amount' => Invoice::where('status', 'paid')->sum('total_amount'),
        ];

        // Top Clients by Revenue
        $topClients = Client::withSum([
            'orders' => function ($query) {
                $query->where('status', 'completed');
            }
        ], 'total_amount')
            ->orderBy('orders_sum_total_amount', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
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
            'topClients'
        ));
    }

    public function profile()
    {
        return view('admin.profile');
    }
}
