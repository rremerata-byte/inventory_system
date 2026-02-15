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
        $user = auth()->user();

        if ($user && $user->role === 'admin') {
            return $this->adminDashboard();
        }

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
        $totalRevenue = Sale::selectRaw('SUM(quantity * sale_price) as revenue')->value('revenue') ?? 0;
        $totalCategories = Category::count();
        $itemsSold = Sale::sum('quantity') ?? 0;
        $lowStockCount = Product::where('quantity', '<=', 10)->count();
        
        // Average calculations
        $avgProductPrice = Product::avg('unit_cost') ?? 0;
        $totalInventoryValue = Product::selectRaw('SUM(unit_cost * quantity) as value')->first()->value ?? 0;
        $avgDailySales = Sale::selectRaw('SUM(quantity * sale_price) / NULLIF(COUNT(DISTINCT DATE(created_at)), 0) as avg')
            ->first()->avg ?? 0;
        $staffCount = User::where('role', 'staff')->count();
        
        // Low stock products
        $lowStockProducts = Product::where('quantity', '<=', 10)
            ->with('category')
            ->orderBy('quantity')
            ->get();

        // Recent activity
        $recentActivity = ActivityLog::with('user')
            ->latest('created_at')
            ->limit(8)
            ->get();

        // Last 30 days items sold data
        $dailyItemsSold = Sale::selectRaw('DATE(created_at) as date, SUM(quantity) as quantity')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Inventory status data for chart
        $totalProductCount = Product::count();
        $lowStockCountChart = Product::where('quantity', '>', 0)->where('quantity', '<=', 10)->count();
        $outOfStockCount = Product::where('quantity', 0)->count();
        $inStockCount = $totalProductCount - $lowStockCountChart - $outOfStockCount;

        // Chart data
        $last30Days = Sale::selectRaw('DATE(created_at) as date, SUM(quantity * sale_price) as revenue')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartData = [
            'salesLabels' => $last30Days->pluck('date')->toArray(),
            'salesData' => $last30Days->pluck('revenue')->toArray(),
            'inventoryLabels' => Category::pluck('name')->toArray(),
            'inventoryData' => Category::withCount('products')->pluck('products_count')->toArray()
        ];

        // Stat boxes
        $stats = [
            [
                'label' => 'Current Inventory Value',
                'value' => $totalInventoryValue,
                'color' => '#27ae60'
            ],
            [
                'label' => 'No. of Product Types',
                'value' => $totalProducts,
                'color' => '#34495e'
            ],
            [
                'label' => 'Average Item Cost',
                'value' => $avgProductPrice ?? 0,
                'color' => '#e67e22'
            ],
            [
                'label' => 'All Time Items Sold',
                'value' => $itemsSold ?? 0,
                'color' => '#2980b9'
            ],
            [
                'label' => 'All Time Sales',
                'value' => $totalRevenue ?? 0,
                'color' => '#27ae60'
            ]
        ];

        return view('admin.dashboard', [
            'stats' => $stats,
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
            'chartData' => $chartData,
            'dailyItemsSold' => $dailyItemsSold,
            'inventoryStatus' => [
                'inStock' => $inStockCount,
                'lowStock' => $lowStockCountChart,
                'outOfStock' => $outOfStockCount
            ]
        ]);
    }

    /**
     * Staff Dashboard
     */
    private function staffDashboard()
    {
        // Calculate metrics
        $totalProducts = Product::count();
        $totalStock = Product::sum('quantity');
        $inventoryValue = Product::selectRaw('SUM(unit_cost * quantity) as value')->first()->value ?? 0;
        $avgPrice = Product::avg('unit_cost');
        $totalSold = Sale::sum('quantity');
        $totalRevenue = Sale::selectRaw('SUM(quantity * sale_price) as revenue')->value('revenue') ?? 0;
        
        // Last 30 days sales chart data (revenue)
        $last30Days = Sale::selectRaw('DATE(created_at) as date, SUM(quantity * sale_price) as revenue')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Last 30 days items sold data
        $dailyItemsSold = Sale::selectRaw('DATE(created_at) as date, SUM(quantity) as quantity')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Inventory status data for chart
        $totalProductCount = Product::count();
        $lowStockCount = Product::where('quantity', '>', 0)->where('quantity', '<=', 10)->count();
        $outOfStockCount = Product::where('quantity', 0)->count();
        $inStockCount = $totalProductCount - $lowStockCount - $outOfStockCount;

        // Low stock products
        $lowStockProducts = Product::where('quantity', '<=', 10)
            ->with('category')
            ->limit(5)
            ->get();

        // Recent sales
        $recentSales = Sale::with('product')
            ->latest('created_at')
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
                'label' => 'Average Item Cost',
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

        return view('user.dashboard', [
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
