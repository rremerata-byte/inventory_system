@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-dashboard-container">

    <!-- Key Metrics Grid -->
    <div class="metrics-grid">
        <div class="metric-card" style="border-top: 4px solid #e74c3c;">
            <div class="metric-icon">📦</div>
            <div class="metric-details">
                <div class="metric-label">Total Products</div>
                <div class="metric-value">{{ $totalProducts ?? 0 }}</div>
            </div>
        </div>

        <div class="metric-card" style="border-top: 4px solid #3498db;">
            <div class="metric-icon">👥</div>
            <div class="metric-details">
                <div class="metric-label">Active Users</div>
                <div class="metric-value">{{ $activeUsers ?? 0 }}</div>
            </div>
        </div>

        <div class="metric-card" style="border-top: 4px solid #2ecc71;">
            <div class="metric-icon">💰</div>
            <div class="metric-details">
                <div class="metric-label">Total Revenue</div>
                <div class="metric-value">₱{{ number_format((float)($totalRevenue ?? 0), 0) }}</div>
            </div>
        </div>

        <div class="metric-card" style="border-top: 4px solid #f39c12;">
            <div class="metric-icon">📊</div>
            <div class="metric-details">
                <div class="metric-label">Categories</div>
                <div class="metric-value">{{ $totalCategories ?? 0 }}</div>
            </div>
        </div>

        <div class="metric-card" style="border-top: 4px solid #9b59b6;">
            <div class="metric-icon">🎯</div>
            <div class="metric-details">
                <div class="metric-label">Items Sold</div>
                <div class="metric-value">{{ $itemsSold ?? 0 }}</div>
            </div>
        </div>

        <div class="metric-card" style="border-top: 4px solid #e67e22;">
            <div class="metric-icon">⚠️</div>
            <div class="metric-details">
                <div class="metric-label">Low Stock Items</div>
                <div class="metric-value">{{ $lowStockCount ?? 0 }}</div>
            </div>
        </div>
    </div>

    <!-- Admin Controls Section -->
    <div class="admin-controls-section">
        <h2>🛠️ Administrative Tools</h2>
        <div class="controls-grid">
            <a href="{{ route('categories.index') }}" class="control-card">
                <div class="control-icon">🏷️</div>
                <h3>Manage Categories</h3>
                <p>Add, edit, or delete product categories</p>
            </a>

            <a href="{{ route('products.index') }}" class="control-card">
                <div class="control-icon">📦</div>
                <h3>Manage Products</h3>
                <p>View and manage all products in inventory</p>
            </a>

            <a href="{{ route('activity-logs.index') }}" class="control-card">
                <div class="control-icon">📋</div>
                <h3>Activity Logs</h3>
                <p>Track all system activities and changes</p>
            </a>

            <a href="{{ route('profile.edit') }}" class="control-card">
                <div class="control-icon">⚙️</div>
                <h3>Settings</h3>
                <p>Manage your account and preferences</p>
            </a>
        </div>
    </div>

    <!-- Critical Alerts -->
    <div class="alerts-section">
        <h2>⚠️ System Alerts</h2>

        <!-- Low Stock Products -->
        @if(isset($lowStockProducts) && $lowStockProducts->count() > 0)
        <div class="alert-box alert-warning">
            <div class="alert-header">
                <span class="alert-icon">🚨</span>
                <h3>Low Stock Products ({{ $lowStockProducts->count() }})</h3>
            </div>
            <div class="alert-content">
                <table class="alert-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Current Stock</th>
                            <th>Min Stock</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowStockProducts->take(5) as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>
                                <span class="badge" style="background-color: {{ $product->category->color_code ?? '#999' }}; color: white;">
                                    {{ $product->category->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td><strong>{{ $product->stock }}</strong></td>
                            <td>{{ $product->min_stock }}</td>
                            <td>
                                @if($product->stock == 0)
                                    <span class="status-badge status-critical">OUT OF STOCK</span>
                                @else
                                    <span class="status-badge status-warning">LOW</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($lowStockProducts->count() > 5)
                <p class="text-center" style="margin-top: 15px; color: #666;">
                    <a href="{{ route('stock_alert') }}" style="color: #e74c3c; font-weight: 600;">View all {{ $lowStockProducts->count() }} items →</a>
                </p>
                @endif
            </div>
        </div>
        @else
        <div class="alert-box alert-success">
            <div class="alert-header">
                <span class="alert-icon">✓</span>
                <h3>All Products in Stock</h3>
            </div>
            <p>All products have sufficient inventory levels.</p>
        </div>
        @endif
    </div>

    <!-- Analytics Section -->
    <div class="analytics-section">
        <h2>📊 Analytics & Performance</h2>
        
        <div class="charts-container">
            <div class="chart-card">
                <h3>Sales Trend (30 Days)</h3>
                <canvas id="salesTrendChart" height="80"></canvas>
            </div>

            <div class="chart-card">
                <h3>Inventory Distribution</h3>
                <canvas id="inventoryDistributionChart" height="80"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity Log -->
    <div class="activity-section">
        <h2>📝 Recent System Activity</h2>
        
        @if(isset($recentActivity) && $recentActivity->count() > 0)
        <div class="activity-list">
            @foreach($recentActivity->take(8) as $activity)
            <div class="activity-item">
                <div class="activity-time">{{ $activity->created_at->format('M d, Y H:i') }}</div>
                <div class="activity-action">{{ $activity->action }}</div>
                <div class="activity-details">
                    <span class="activity-user">By: {{ $activity->user->name ?? 'System' }}</span>
                    <span class="activity-model">{{ class_basename($activity->model_type ?? '') }}</span>
                </div>
            </div>
            @endforeach
        </div>
        <div class="activity-footer">
            <a href="{{ route('activity-logs.index') }}" class="btn btn-secondary">View Full Activity Log</a>
        </div>
        @else
        <p class="text-center text-muted">No recent activity</p>
        @endif
    </div>

    <!-- Quick Stats -->
    <div class="quick-stats">
        <h2>📈 Quick Statistics</h2>
        <div class="stats-table-container">
            <table class="stats-table">
                <tr>
                    <td>Average Product Price</td>
                    <td class="stat-value">₱{{ number_format((float)($avgProductPrice ?? 0), 2) }}</td>
                </tr>
                <tr>
                    <td>Total Inventory Value</td>
                    <td class="stat-value">₱{{ number_format((float)($totalInventoryValue ?? 0), 2) }}</td>
                </tr>
                <tr>
                    <td>Average Daily Sales</td>
                    <td class="stat-value">₱{{ number_format((float)($avgDailySales ?? 0), 2) }}</td>
                </tr>
                <tr>
                    <td>Staff Members</td>
                    <td class="stat-value">{{ $staffCount ?? 0 }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<style>
    /* ===== TOP NAVIGATION BAR ===== */
    .admin-top-nav {
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
        border: 2px solid transparent;
    }

    .nav-item:hover {
        background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
        color: #2c3e50;
        transform: translateY(-2px);
    }

    .nav-item.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #764ba2;
        box-shadow: 0 4px 12px rgba(118, 75, 162, 0.3);
    }

    .nav-icon {
        font-size: 1.2rem;
    }

    .nav-label {
        font-size: 0.9rem;
    }

    /* ===== ADMIN DASHBOARD CONTAINER ===== */
    .admin-dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: calc(100vh - 80px);
    }

    /* ===== ADMIN HEADER ===== */
    .admin-header {
        text-align: center;
        margin-bottom: 40px;
        padding-bottom: 30px;
        border-bottom: 3px solid #ff7f00;
    }

    .admin-header h1 {
        font-size: 2.2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .admin-header p {
        font-size: 1.1rem;
        color: #7f8c8d;
    }

    /* ===== METRICS GRID ===== */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .metric-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s ease;
    }

    .metric-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    .metric-icon {
        font-size: 2.5rem;
        flex-shrink: 0;
    }

    .metric-details {
        flex: 1;
    }

    .metric-label {
        font-size: 0.85rem;
        color: #95a5a6;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .metric-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2c3e50;
        margin-top: 5px;
    }

    /* ===== ADMIN CONTROLS ===== */
    .admin-controls-section {
        margin-bottom: 40px;
    }

    .admin-controls-section h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: #2c3e50;
    }

    .controls-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
    }

    .control-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
        border-left: 4px solid #ff7f00;
    }

    .control-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        border-left-color: #e67e22;
    }

    .control-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
    }

    .control-card h3 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 8px;
        color: #2c3e50;
    }

    .control-card p {
        font-size: 0.9rem;
        color: #7f8c8d;
        line-height: 1.5;
    }

    /* ===== ALERTS SECTION ===== */
    .alerts-section {
        margin-bottom: 40px;
    }

    .alerts-section h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: #2c3e50;
    }

    .alert-box {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        border-left: 5px solid;
    }

    .alert-warning {
        border-left-color: #f39c12;
        background: linear-gradient(135deg, #fff9e6 0%, #ffffff 100%);
    }

    .alert-success {
        border-left-color: #2ecc71;
        background: linear-gradient(135deg, #e8f8f5 0%, #ffffff 100%);
    }

    .alert-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .alert-icon {
        font-size: 1.8rem;
    }

    .alert-box h3 {
        font-size: 1.2rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    .alert-content {
        overflow-x: auto;
    }

    .alert-table {
        width: 100%;
        border-collapse: collapse;
    }

    .alert-table th {
        background: #f8f9fa;
        padding: 12px;
        text-align: left;
        font-weight: 600;
        color: #555;
        border-bottom: 2px solid #e0e0e0;
    }

    .alert-table td {
        padding: 12px;
        border-bottom: 1px solid #e0e0e0;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-critical {
        background: #e74c3c;
        color: white;
    }

    .status-warning {
        background: #f39c12;
        color: white;
    }

    /* ===== ANALYTICS SECTION ===== */
    .analytics-section {
        margin-bottom: 40px;
    }

    .analytics-section h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: #2c3e50;
    }

    .charts-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 20px;
    }

    .chart-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .chart-card h3 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: #2c3e50;
    }

    /* ===== ACTIVITY SECTION ===== */
    .activity-section {
        margin-bottom: 40px;
    }

    .activity-section h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: #2c3e50;
    }

    .activity-list {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .activity-item {
        padding: 20px 25px;
        border-bottom: 1px solid #e0e0e0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-time {
        font-size: 0.85rem;
        color: #95a5a6;
        font-weight: 600;
        min-width: 150px;
    }

    .activity-action {
        flex: 1;
        font-weight: 600;
        color: #2c3e50;
    }

    .activity-details {
        display: flex;
        gap: 15px;
        font-size: 0.85rem;
    }

    .activity-user {
        color: #3498db;
        font-weight: 600;
    }

    .activity-model {
        background: #ecf0f1;
        padding: 3px 10px;
        border-radius: 4px;
        color: #555;
    }

    .activity-footer {
        padding: 20px 25px;
        text-align: center;
        border-top: 1px solid #e0e0e0;
    }

    /* ===== QUICK STATS ===== */
    .quick-stats {
        margin-bottom: 40px;
    }

    .quick-stats h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: #2c3e50;
    }

    .stats-table-container {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .stats-table {
        width: 100%;
        border-collapse: collapse;
    }

    .stats-table tr {
        border-bottom: 1px solid #e0e0e0;
    }

    .stats-table tr:last-child {
        border-bottom: none;
    }

    .stats-table td {
        padding: 18px 20px;
        font-size: 1rem;
    }

    .stats-table td:first-child {
        color: #555;
        font-weight: 600;
    }

    .stat-value {
        font-size: 1.4rem;
        font-weight: 700;
        color: #2ecc71;
        text-align: right;
    }

    /* ===== BADGES ===== */
    .badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    /* ===== TEXT UTILITIES ===== */
    .text-center {
        text-align: center;
    }

    .text-muted {
        color: #95a5a6;
    }

    /* ===== BUTTONS ===== */
    .btn {
        display: inline-block;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        font-size: 0.95rem;
    }

    .btn-secondary {
        background: #95a5a6;
        color: white;
    }

    .btn-secondary:hover {
        background: #7f8c8d;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .admin-top-nav {
            gap: 8px;
            padding: 10px;
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

        .admin-dashboard-container {
            padding: 20px;
        }

        .admin-header h1 {
            font-size: 1.8rem;
        }

        .metrics-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .charts-container {
            grid-template-columns: 1fr;
        }

        .activity-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .activity-details {
            width: 100%;
            flex-direction: column;
        }
    }
</style>

@if(isset($chartData))
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sales Trend Chart
    const salesTrendCtx = document.getElementById('salesTrendChart');
    if (salesTrendCtx) {
        new Chart(salesTrendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData['salesLabels'] ?? []) !!},
                datasets: [{
                    label: 'Daily Sales (₱)',
                    data: {!! json_encode($chartData['salesData'] ?? []) !!},
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    // Inventory Distribution Chart
    const inventoryCtx = document.getElementById('inventoryDistributionChart');
    if (inventoryCtx) {
        new Chart(inventoryCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($chartData['inventoryLabels'] ?? []) !!},
                datasets: [{
                    data: {!! json_encode($chartData['inventoryData'] ?? []) !!},
                    backgroundColor: [
                        '#e74c3c', '#3498db', '#2ecc71', '#f39c12',
                        '#9b59b6', '#1abc9c', '#e67e22', '#34495e'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }
</script>
@endif
@endsection
