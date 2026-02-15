@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-dashboard-container">

    <!-- Stat Boxes -->
    <div class="stats-row">
        <div class="stat-box stat-box-green">
            <div class="stat-label">Current Inventory Value</div>
            <div class="stat-value">₱{{ number_format((float)($stats[0]['value'] ?? 0), 2) }}</div>
        </div>
        <div class="stat-box stat-box-black">
            <div class="stat-label">No. of Product Types</div>
            <div class="stat-value">{{ (int)($stats[1]['value'] ?? 0) }}</div>
        </div>
        <div class="stat-box stat-box-orange">
            <div class="stat-label">Average Item Price</div>
            <div class="stat-value">₱{{ number_format((float)($stats[2]['value'] ?? 0), 2) }}</div>
        </div>
        <div class="stat-box stat-box-blue">
            <div class="stat-label">All Time Items Sold</div>
            <div class="stat-value">{{ (int)($stats[3]['value'] ?? 0) }}</div>
        </div>
        <div class="stat-box stat-box-green">
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
</div>

    
</div>

<style>
    /* ===== TOP NAVIGATION BAR ===== */
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
    max-width: 220px;
    background: white;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    transition: border-color 0.3s;
}

.stat-box:hover {
    border-color: #b0b0b0;
}

.stat-box-green {
    border-color: #27ae60;
    color: green;
}

.stat-box-green .stat-value {
    color: #27ae60;
}

.stat-box-black {
    border-color: #000;
}

.stat-box-black .stat-value {
    color: #000;
}

.stat-box-orange {
    border-color: #ff8c00;
}

.stat-box-orange .stat-value {
    color: #ff8c00;
}

.stat-box-blue {
    border-color: #0066cc;
}

.stat-box-blue .stat-value {
    color: #0066cc;
}

.stat-label {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 10px;
    font-weight: 600;
}

.stat-value {
    font-size: 1.6rem;
    font-weight: 700;
    color: #333;
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inventory Status Chart
    const inventoryStatus = @json($inventoryStatus);
    const inventoryCtx = document.getElementById('inventoryChart');
    if (inventoryCtx) {
        new Chart(inventoryCtx, {
            type: 'bar',
            data: {
                labels: ['In Stock', 'Low Stock', 'Out of Stock'],
                datasets: [{
                    label: 'Products',
                    data: [inventoryStatus.inStock, inventoryStatus.lowStock, inventoryStatus.outOfStock],
                    backgroundColor: ['#27ae60', '#f39c12', '#e74c3c'],
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' products';
                            }
                        }
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        ticks: { 
                            stepSize: 1,
                            color: '#fff'
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    },
                    x: {
                        ticks: { color: '#fff' },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    }
                }
            }
        });
    }

    // Daily Items Sold Chart
    const dailyItems = @json($dailyItemsSold);
    const dates = dailyItems.map(d => d.date);
    const quantities = dailyItems.map(d => parseInt(d.quantity));

    const salesCtx = document.getElementById('salesChart');
    if (salesCtx) {
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Items Sold',
                    data: quantities,
                    borderColor: '#00bfff',
                    backgroundColor: 'rgba(0, 191, 255, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#00bfff',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' items sold';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            color: '#fff'
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    },
                    x: {
                        ticks: { color: '#fff' },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    }
                }
            }
        });
    }
});
</script>
@endsection
