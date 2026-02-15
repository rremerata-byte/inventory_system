@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-container">


    <!-- Page Title -->
    <h2 class="description">Detailed view of sales and item movement over the last 30 days</h2>

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
    border-color: #ae2793ff;
}

.stat-box-green .stat-value {
    color: #aea927ff;
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
