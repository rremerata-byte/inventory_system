<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with(['product', 'user'])->latest('sold_at')->paginate(20);
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        $view = auth()->user()?->role === 'admin'
            ? 'admin.sales.create'
            : 'user.sales.create';

        return view($view, compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity_sold' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Check stock
        if ($product->stock < $validated['quantity_sold']) {
            return back()->withErrors(['quantity_sold' => 'Insufficient stock available.'])->withInput();
        }

        $validated['user_id'] = auth()->id();
        $validated['revenue'] = $validated['quantity_sold'] * $validated['sale_price'];
        $validated['sold_at'] = now();

        $sale = Sale::create($validated);

        // Update product stock
        $product->decrement('stock', $validated['quantity_sold']);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Sale Recorded',
            'details' => "{$validated['quantity_sold']} x {$product->name} sold for ₱{$validated['sale_price']}",
            'color_class' => 'badge-success'
        ]);

        return redirect()->route('sales.index')->with('success', 'Sale recorded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        $this->authorize('admin');
        $products = Product::all();
        return view('sales.edit', compact('sale', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $this->authorize('admin');

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity_sold' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $oldProduct = $sale->product;
        $oldQuantity = $sale->quantity_sold;

        // Restore old stock
        $oldProduct->increment('stock', $oldQuantity);

        // Check new stock
        if ($product->stock < $validated['quantity_sold']) {
            $oldProduct->decrement('stock', $oldQuantity);
            return back()->withErrors(['quantity_sold' => 'Insufficient stock available.'])->withInput();
        }

        // Deduct new quantity
        $product->decrement('stock', $validated['quantity_sold']);

        $validated['revenue'] = $validated['quantity_sold'] * $validated['sale_price'];

        $sale->update($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Sale Updated',
            'details' => "Sale #{$sale->id} updated",
            'color_class' => 'badge-info'
        ]);

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        $this->authorize('admin');

        $product = $sale->product;
        $quantity = $sale->quantity_sold;

        // Restore stock
        $product->increment('stock', $quantity);

        $sale->delete();

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Sale Deleted',
            'details' => "Sale #{$sale->id} deleted, stock restored",
            'color_class' => 'badge-danger'
        ]);

        return redirect()->route('sales.index')->with('success', 'Sale deleted and stock restored!');
    }

    /**
     * Display daily sales report
     */
    public function dailyReport(Request $request)
    {
        // Get date range from request or default to last 30 days
        $dateFrom = $request->get('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        // Get sales within date range
        $sales = Sale::with(['product.category', 'user'])
            ->whereBetween('sold_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->latest('sold_at')
            ->paginate(50);

        // Calculate summary statistics
        $totalRevenue = $sales->sum('revenue');
        $totalSales = $sales->count();
        $totalItemsSold = $sales->sum('quantity_sold');
        $avgTransaction = $totalSales > 0 ? $totalRevenue / $totalSales : 0;

        // Get chart data (daily revenue)
        $chartData = Sale::selectRaw('DATE(sold_at) as date, SUM(revenue) as revenue')
            ->whereBetween('sold_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = $chartData->pluck('date')->map(function($date) {
            return date('M d', strtotime($date));
        })->toArray();
        $chartValues = $chartData->pluck('revenue')->toArray();

        // Get top selling products
        $topProducts = Sale::selectRaw('product_id, products.name as product_name, SUM(quantity_sold) as total_quantity, SUM(revenue) as total_revenue')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->whereBetween('sold_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->groupBy('product_id', 'products.name')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        $view = auth()->user()?->role === 'admin'
            ? 'admin.sales.daily-report'
            : 'user.sales.daily-report';

        return view($view, [
            'sales' => $sales,
            'totalRevenue' => $totalRevenue,
            'totalSales' => $totalSales,
            'totalItemsSold' => $totalItemsSold,
            'avgTransaction' => $avgTransaction,
            'chartData' => [
                'labels' => $chartLabels,
                'data' => $chartValues
            ],
            'topProducts' => $topProducts
        ]);
    }

    /**
     * Authorize admin actions
     */
    private function authorize($role)
    {
        if (auth()->user()->role !== $role) {
            abort(403, 'Unauthorized action.');
        }
    }
}
