<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Category;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return $this->staffDashboard();
    }

    /**
     * Admin Dashboard
     */
    private function adminDashboard()
    {
        // Calculate metrics
        $totalProducts = Product::count();
        $activeUsers = User::count();
        $totalRevenue = Sale::sum('revenue') ?? 0;
        $totalCategories = Category::count();
        $itemsSold = Sale::sum('quantity_sold') ?? 0;
        $lowStockCount = Product::whereRaw('stock <= min_stock')->count();
        
        // Average calculations
        $avgProductPrice = Product::avg('price') ?? 0;
        $totalInventoryValue = Product::selectRaw('SUM(price * stock) as value')->first()->value ?? 0;
        $avgDailySales = Sale::selectRaw('SUM(revenue) / NULLIF(COUNT(DISTINCT DATE(sold_at)), 0) as avg')
            ->first()->avg ?? 0;
        $staffCount = User::where('role', 'staff')->count();
        
        // Low stock products
        $lowStockProducts = Product::whereRaw('stock <= min_stock')
            ->with('category')
            ->orderBy('stock')
            ->get();

        // Recent activity
        $recentActivity = ActivityLog::with('user')
            ->latest('created_at')
            ->limit(8)
            ->get();

        // Chart data
        $last30Days = Sale::selectRaw('DATE(sold_at) as date, SUM(revenue) as revenue')
            ->where('sold_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartData = [
            'salesLabels' => $last30Days->pluck('date')->toArray(),
            'salesData' => $last30Days->pluck('revenue')->toArray(),
            'inventoryLabels' => Category::pluck('name')->toArray(),
            'inventoryData' => Category::withCount('products')->pluck('products_count')->toArray()
        ];

        return view('admin-dashboard', [
            'totalProducts' => $totalProducts,
            'activeUsers' => $activeUsers,
            'totalRevenue' => $totalRevenue,
            'totalCategories' => $totalCategories,
            'itemsSold' => $itemsSold,
            'lowStockCount' => $lowStockCount,
            'avgProductPrice' => $avgProductPrice,
            'totalInventoryValue' => $totalInventoryValue,
            'avgDailySales' => $avgDailySales,
            'staffCount' => $staffCount,
            'lowStockProducts' => $lowStockProducts,
            'recentActivity' => $recentActivity,
            'chartData' => $chartData
        ]);
    }

    /**
     * Staff Dashboard
     */
    private function staffDashboard()
    {
        // Calculate metrics
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $inventoryValue = Product::selectRaw('SUM(price * stock) as value')->first()->value ?? 0;
        $avgPrice = Product::avg('price');
        $totalSold = Sale::sum('quantity_sold');
        $totalRevenue = Sale::sum('revenue');
        
        // Last 30 days sales chart data (revenue)
        $last30Days = Sale::selectRaw('DATE(sold_at) as date, SUM(revenue) as revenue')
            ->where('sold_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Last 30 days items sold data
        $dailyItemsSold = Sale::selectRaw('DATE(sold_at) as date, SUM(quantity_sold) as quantity')
            ->where('sold_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Inventory status data for chart
        $totalProductCount = Product::count();
        $lowStockCount = Product::whereRaw('stock <= min_stock AND stock > 0')->count();
        $outOfStockCount = Product::where('stock', 0)->count();
        $inStockCount = $totalProductCount - $lowStockCount - $outOfStockCount;

        // Low stock products
        $lowStockProducts = Product::whereRaw('stock <= min_stock')
            ->with('category')
            ->limit(5)
            ->get();

        // Recent sales
        $recentSales = Sale::with('product')
            ->latest('sold_at')
            ->limit(10)
            ->get();

        // Stat boxes
        $stats = [
            [
                'label' => 'Current Inventory Value',
                'value' => $inventoryValue,
                'color' => '#27ae60'
            ],
            [
                'label' => 'No. of Product Types',
                'value' => $totalProducts,
                'color' => '#34495e'
            ],
            [
                'label' => 'Average Item Price',
                'value' => $avgPrice ?? 0,
                'color' => '#e67e22'
            ],
            [
                'label' => 'All Time Items Sold',
                'value' => $totalSold ?? 0,
                'color' => '#2980b9'
            ],
            [
                'label' => 'All Time Sales',
                'value' => $totalRevenue ?? 0,
                'color' => '#27ae60'
            ]
        ];

        return view('staffdashboard', [
            'stats' => $stats,
            'lowStockProducts' => $lowStockProducts,
            'recentSales' => $recentSales,
            'chartData' => $last30Days,
            'dailyItemsSold' => $dailyItemsSold,
            'inventoryStatus' => [
                'inStock' => $inStockCount,
                'lowStock' => $lowStockCount,
                'outOfStock' => $outOfStockCount
            ],
            'userRole' => auth()->user()?->role
        ]);
    }
}
