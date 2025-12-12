@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-container">


    <!-- Page Title -->
    <h2 class="description">Detailed view of sales and item movement over the last 30 days</h2>

    <!-- Stat Boxes -->
    <div class="stats-row">
        <div class="stat-box" style="border-left: 5px solid #27ae60;">
            <div class="stat-label">Current Inventory Value</div>
            <div class="stat-value">₱{{ number_format((float)($stats[0]['value'] ?? 0), 2) }}</div>
        </div>
        <div class="stat-box" style="border-left: 5px solid #34495e;">
            <div class="stat-label">No. of Product Types</div>
            <div class="stat-value">{{ (int)($stats[1]['value'] ?? 0) }}</div>
        </div>
        <div class="stat-box" style="border-left: 5px solid #e67e22;">
            <div class="stat-label">Average Item Price</div>
            <div class="stat-value">₱{{ number_format((float)($stats[2]['value'] ?? 0), 2) }}</div>
        </div>
        <div class="stat-box" style="border-left: 5px solid #2980b9;">
            <div class="stat-label">All Time Items Sold</div>
            <div class="stat-value">{{ (int)($stats[3]['value'] ?? 0) }}</div>
        </div>
        <div class="stat-box" style="border-left: 5px solid #27ae60;">
            <div class="stat-label">All Time Sales</div>
            <div class="stat-value">₱{{ number_format((float)($stats[4]['value'] ?? 0), 2) }}</div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="charts-row">
        <div class="chart-box">
            <h3>📊 Inventory Status</h3>
            <canvas id="inventoryChart"></canvas>
        </div>
        <div class="chart-box">
            <h3>📈 Daily Items Sold</h3>
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Low Stock Products (Admin Only) -->
    @auth
        @if(auth()->user()->role === 'admin')
        <div class="alert alert-warning" style="margin-top: 30px;">
            <strong>⚠️ Alert:</strong> The following products are low on stock and need replenishment!
        </div>

        <div class="card">
        <div class="card-header">
            <h3>🚨 Low Stock Products</h3>
        </div>
        <div class="card-body">
            @if($lowStockProducts->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Current Stock</th>
                        <th>Min Stock</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockProducts as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>
                            <span class="badge" style="background-color: {{ $product->category->color_code }}; color: white;">
                                {{ $product->category->name }}
                            </span>
                        </td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->min_stock }}</td>
                        <td>
                            @if($product->stock == 0)
                                <span class="badge badge-danger">OUT OF STOCK</span>
                            @else
                                <span class="badge badge-warning">LOW STOCK</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="text-center text-muted">All products have sufficient stock! ✓</p>
            @endif
        </div>
    </div>
        @endif
    @endauth

    <!-- Recent Sales -->
    <div class="card" style="margin-top: 30px;">
        <div class="card-header">
            <h3>💰 Recent Sales</h3>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm">View All</a>
        </div>
        <div class="card-body">
            @if($recentSales->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Sold By</th>
                        <th>Quantity</th>
                        <th>Unit Cost</th>
                        <th>Sale Price</th>
                        <th>Revenue</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentSales as $sale)
                    <tr>
                        <td>{{ $sale->product->name }}</td>
                        <td>{{ $sale->user->name }}</td>
                        <td>{{ $sale->quantity_sold }}</td>
                        <td>₱{{ number_format($sale->unit_cost, 2) }}</td>
                        <td>₱{{ number_format($sale->sale_price, 2) }}</td>
                        <td class="font-weight-bold">₱{{ number_format($sale->revenue, 2) }}</td>
                        <td>{{ $sale->sold_at->format('M d, Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="text-center text-muted">No sales recorded yet.</p>
            @endif
        </div>
    </div>
</div>

<style>
.dashboard-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 30px 40px;
}

/* ===== TOP NAVIGATION ===== */
.staff-top-nav {
    display: flex;
    gap: 10px;
    background: white;
    padding: 15px 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    overflow-x: auto;
    flex-wrap: wrap;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    border-radius: 8px;
    text-decoration: none;
    color: #555;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.nav-item:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(118, 75, 162, 0.2);
}

.nav-item.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(118, 75, 162, 0.3);
}

.nav-icon {
    font-size: 1.2rem;
}

.nav-label {
    font-size: 0.9rem;
}

/* ===== PAGE TITLE ===== */
.description {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 30px;
    color: #111;
    text-align: center;
}

.stats-row {
    display: flex;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 40px;
    flex-wrap: wrap;
}

.stat-box {
    flex: 1 1 auto;
    min-width: 160px;
    max-width: 200px;
    background: white;
    border-radius: 12px;
    padding: 24px 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
}

.stat-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}

.stat-label {
    font-size: 0.9rem;
    color: #7f8c8d;
    text-transform: uppercase;
    margin-bottom: 10px;
    font-weight: 600;
}

.stat-value {
    font-size: 1.8rem;
    font-weight: bold;
    color: #2c3e50;
}

.charts-row {
    display: flex;
    justify-content: space-between;
    gap: 30px;
    margin-bottom: 40px;
    flex-wrap: wrap;
}

.chart-box {
    background: #1e293b;
    border-radius: 12px;
    padding: 25px 20px;
    flex: 1;
    min-width: 400px;
    color: white;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

.chart-box h3 {
    font-weight: 700;
    margin-bottom: 20px;
    font-size: 1.1rem;
}

.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
}

.card-header {
    background: #f8f9fa;
    padding: 20px;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header h3 {
    margin: 0;
    font-size: 1.3rem;
    color: #2c3e50;
}

.card-body {
    padding: 20px;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.data-table thead {
    background: #f8f9fa;
}

.data-table th {
    padding: 12px;
    text-align: left;
    font-weight: 600;
    color: #2c3e50;
    border-bottom: 2px solid #ddd;
}

.data-table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

.data-table tbody tr:hover {
    background: #f8f9fa;
}

.badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
}

.badge-success {
    background: #27ae60;
    color: white;
}

.badge-danger {
    background: #e74c3c;
    color: white;
}

.badge-warning {
    background: #f39c12;
    color: white;
}

.badge-info {
    background: #3498db;
    color: white;
}

.font-weight-bold {
    font-weight: bold;
}

.text-muted {
    color: #7f8c8d;
}

.text-center {
    text-align: center;
}

.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
}

.btn-secondary {
    background: #95a5a6;
    color: white;
}

.btn-sm {
    padding: 4px 12px;
    font-size: 12px;
}

.alert {
    padding: 15px 20px;
    border-radius: 4px;
    margin-bottom: 20px;
    border-left: 4px solid;
}

.alert-warning {
    background: #fff3cd;
    color: #856404;
    border-left-color: #f39c12;
}

@media (max-width: 1200px) {
    .charts-row {
        flex-direction: column;
    }

    .chart-box {
        min-width: auto;
    }

    .stats-row {
        gap: 10px;
    }

    .stat-box {
        max-width: none;
        flex: 1;
    }
}

@media (max-width: 768px) {
    .dashboard-container {
        padding: 20px;
    }

    .staff-top-nav {
        gap: 8px;
        padding: 10px 15px;
        margin-bottom: 20px;
    }

    .nav-item {
        padding: 8px 12px;
        font-size: 0.85rem;
    }

    .nav-icon {
        font-size: 1rem;
    }

    .nav-label {
        font-size: 0.85rem;
    }

    .stats-row {
        flex-direction: column;
    }

    .stat-box {
        max-width: none;
    }

    .data-table {
        font-size: 12px;
    }

    .data-table th, .data-table td {
        padding: 8px;
    }

    .chart-box {
        min-width: auto;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inventory Status Chart
    @if($lowStockProducts->count() > 0 || $recentSales->count() > 0)
    const inventoryCtx = document.getElementById('inventoryChart');
    if (inventoryCtx) {
        new Chart(inventoryCtx, {
            type: 'bar',
            data: {
                labels: ['In Stock', 'Low Stock', 'Out of Stock'],
                datasets: [{
                    data: [@json($lowStockProducts->count()), 0, @json($lowStockProducts->where('stock', 0)->count())],
                    backgroundColor: ['#27ae60', '#f1c40f', '#e74c3c'],
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } },
                    x: {}
                }
            }
        });
    }
    @endif

    // Daily Sales Chart
    @if($chartData->count() > 0)
    const chartData = @json($chartData);
    const dates = chartData.map(d => d.date);
    const revenues = chartData.map(d => d.revenue);

    const salesCtx = document.getElementById('salesChart');
    if (salesCtx) {
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Daily Revenue (₱)',
                    data: revenues,
                    borderColor: '#00bfff',
                    backgroundColor: 'rgba(0, 191, 255, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#00bfff',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }
    @endif
});
</script>
@endsection
