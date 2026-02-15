@extends('layouts.app')

@section('title', 'Daily Sales Report')

@section('content')
<div class="daily-report-container">
    <!-- Header -->
    <div class="report-header">
        <div class="header-content">
            <h1>Daily Sales Report</h1>
            <p>Track revenue, profit, and top products</p>
        </div>
    </div>

    <!-- Date Filter -->
    <div class="date-filter-section">
        <form method="GET" action="{{ route('daily_sales_report') }}" class="date-filter-form">
            <div class="filter-group">
                <label for="date_from">Date From</label>
                <input type="date" id="date_from" name="date_from" class="form-control" value="{{ request('date_from', now()->subDays(30)->format('Y-m-d')) }}">
            </div>
            <div class="filter-group">
                <label for="date_to">Date To</label>
                <input type="date" id="date_to" name="date_to" class="form-control" value="{{ request('date_to', now()->format('Y-m-d')) }}">
            </div>
            <div class="filter-group" style="max-width: 220px;">
                <button type="submit" class="btn btn-filter" style="width: 100%;">Apply Filter</button>
            </div>
            <div class="filter-group" style="max-width: 220px;">
                <a href="{{ route('daily_sales_report') }}" class="btn btn-reset" style="width: 100%;">Reset</a>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-icon">💰</div>
            <div>
                <div class="summary-label">Total Revenue</div>
                <div class="summary-value">₱{{ number_format($totalRevenue ?? 0, 2) }}</div>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon">🛒</div>
            <div>
                <div class="summary-label">Total Sales</div>
                <div class="summary-value">{{ $totalSales ?? 0 }}</div>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon">📦</div>
            <div>
                <div class="summary-label">Items Sold</div>
                <div class="summary-value">{{ $totalItemsSold ?? 0 }}</div>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon">📈</div>
            <div>
                <div class="summary-label">Avg Transaction</div>
                <div class="summary-value">₱{{ number_format($avgTransaction ?? 0, 2) }}</div>
            </div>
        </div>
    </div>

    <!-- Sales Trend Chart -->
    <div class="chart-section">
        <h2>Revenue Trend</h2>
        <div class="chart-container">
            <canvas id="salesTrendChart"></canvas>
        </div>
    </div>

    <!-- Top Products -->
    <div class="top-products-section">
        <h2>Top Products</h2>
        @if(isset($topProducts) && $topProducts->count() > 0)
        <div class="top-products-grid">
            @foreach($topProducts as $index => $product)
            <div class="top-product-card">
                <div class="rank-badge">{{ $index + 1 }}</div>
                <div class="product-info">
                    <h3>{{ $product->product_name }}</h3>
                    <div class="product-stats">
                        <span class="stat-item">Qty: {{ $product->total_quantity }}</span>
                        <span class="stat-item revenue">₱{{ number_format($product->total_revenue, 2) }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-muted">No sales data in this range.</p>
        @endif
    </div>

    <!-- Sales Table -->
    <div class="report-table-section">
        <div class="section-header">
            <h2> Daily Sales Performance overview</h2>
        </div>

        <div class="table-wrapper">
            @if(isset($sales) && $sales->count() > 0)
            <table class="report-table" id="salesTable">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Sold By</th>
                        <th>Qty</th>
                        <th>Unit Cost</th>
                        <th>Sale Price</th>
                        <th>Revenue</th>
                        <th>Profit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                    <tr>
                        <td>{{ $sale->sold_at->format('M d, Y H:i A') }}</td>
                        <td class="product-name">{{ $sale->product->name }}</td>
                        <td>
                            <span class="category-badge" style="background-color: {{ $sale->product->category->color_code ?? '#999' }};">
                                {{ $sale->product->category->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td>{{ $sale->user->name }}</td>
                        <td class="text-center">{{ $sale->quantity_sold }}</td>
                        <td>₱{{ number_format($sale->unit_cost, 2) }}</td>
                        <td>₱{{ number_format($sale->sale_price, 2) }}</td>
                        <td class="revenue-cell">₱{{ number_format($sale->revenue, 2) }}</td>
                        <td class="profit-cell">₱{{ number_format(($sale->sale_price - $sale->unit_cost) * $sale->quantity_sold, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                
            </table>

            <!-- Pagination -->
            @if(method_exists($sales, 'links'))
            <div class="pagination-wrapper">
                {{ $sales->appends(request()->query())->links() }}
            </div>
            @endif
            @else
            <div class="empty-state">
                <div class="empty-icon">📊</div>
                <h3>No Sales Data</h3>
                <p>No sales recorded for the selected date range.</p>
                <a href="{{ route('sales.create') }}" class="btn btn-primary">Record Your First Sale</a>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* ===== CONTAINER ===== */
    .daily-report-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px;
        background: #f5f7fa;
    }

    /* ===== HEADER ===== */
    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .header-content h1 {
        font-size: 2rem;
        margin: 0 0 5px 0;
        color: #2c3e50;
    }

    .header-content p {
        margin: 0;
        color: #7f8c8d;
    }

    .header-actions {
        display: flex;
        gap: 10px;
    }

    /* ===== DATE FILTER ===== */
    .date-filter-section {
        background: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .date-filter-form {
        display: flex;
        gap: 15px;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .filter-group {
        flex: 1;
        min-width: 200px;
    }

    .filter-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        color: #555;
        font-size: 0.9rem;
    }

    /* ===== SUMMARY GRID ===== */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .summary-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 15px;
        transition: transform 0.3s ease;
    }

    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .summary-icon {
        font-size: 2.5rem;
        flex-shrink: 0;
    }

    .summary-label {
        font-size: 0.85rem;
        color: #7f8c8d;
        font-weight: 600;
        text-transform: uppercase;
    }

    .summary-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2c3e50;
    }

    /* ===== CHART SECTION ===== */
    .chart-section {
        background: white;
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .chart-section h2 {
        margin: 0 0 20px 0;
        color: #2c3e50;
        font-size: 1.3rem;
    }

    .chart-container {
        position: relative;
        height: 300px;
    }

    /* ===== TABLE SECTION ===== */
    .report-table-section {
        background: white;
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .section-header h2 {
        margin: 0;
        color: #2c3e50;
        font-size: 1.3rem;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .report-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .report-table th {
        padding: 12px;
        text-align: left;
        font-weight: 600;
        white-space: nowrap;
    }

    .report-table td {
        padding: 12px;
        border-bottom: 1px solid #e0e0e0;
    }

    .report-table tbody tr:hover {
        background: #f8f9fa;
    }

    .report-table tfoot {
        background: #f8f9fa;
        font-weight: 700;
    }

    .totals-row td {
        padding: 15px 12px;
        border-top: 2px solid #2c3e50;
    }

    .product-name {
        font-weight: 600;
        color: #2c3e50;
    }

    .category-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 4px;
        color: white;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .revenue-cell {
        color: #27ae60;
        font-weight: 600;
    }

    .profit-cell {
        color: #2ecc71;
        font-weight: 600;
    }

    .text-center {
        text-align: center;
    }

    /* ===== TOP PRODUCTS ===== */
    .top-products-section {
        background: white;
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .top-products-section h2 {
        margin: 0 0 20px 0;
        color: #2c3e50;
        font-size: 1.3rem;
    }

    .top-products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 15px;
    }

    .top-product-card {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #f39c12;
    }

    .rank-badge {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #f39c12, #e67e22);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .product-info h3 {
        margin: 0 0 8px 0;
        font-size: 1rem;
        color: #2c3e50;
    }

    .product-stats {
        display: flex;
        gap: 15px;
        font-size: 0.85rem;
    }

    .stat-item {
        color: #7f8c8d;
    }

    .stat-item.revenue {
        color: #27ae60;
        font-weight: 600;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #7f8c8d;
        margin-bottom: 20px;
    }

    /* ===== BUTTONS ===== */
    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-filter {
        background: #3498db;
        color: white;
    }

    .btn-reset {
        background: #95a5a6;
        color: white;
    }

    .btn-print {
        background: #34495e;
        color: white;
    }

    .btn-export {
        background: #27ae60;
        color: white;
    }

    .btn:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1.5px solid #ddd;
        border-radius: 6px;
        font-size: 0.95rem;
        transition: border 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 5px rgba(52, 152, 219, 0.2);
    }

    /* ===== PAGINATION ===== */
    .pagination-wrapper {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    /* ===== PRINT STYLES ===== */
    @media print {
        .report-header .header-actions,
        .date-filter-section,
        .btn,
        .pagination-wrapper {
            display: none !important;
        }

        .daily-report-container {
            background: white;
            padding: 0;
        }

        .report-table thead {
            background: #2c3e50 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .daily-report-container {
            padding: 15px;
        }

        .report-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }

        .header-actions {
            width: 100%;
            flex-direction: column;
        }

        .date-filter-form {
            flex-direction: column;
        }

        .filter-group {
            width: 100%;
        }

        .filter-actions {
            width: 100%;
        }

        .filter-actions .btn {
            width: 100%;
        }

        .summary-grid {
            grid-template-columns: 1fr;
        }

        .report-table {
            font-size: 0.8rem;
        }

        .report-table th,
        .report-table td {
            padding: 8px;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sales Trend Chart
    @if(isset($chartData) && count($chartData['labels']) > 0)
    const ctx = document.getElementById('salesTrendChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData['labels']) !!},
                datasets: [{
                    label: 'Daily Revenue (₱)',
                    data: {!! json_encode($chartData['data']) !!},
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3498db',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '₱' + context.parsed.y.toLocaleString('en-US', { minimumFractionDigits: 2 });
                            }
                        }
                    }
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

    // Export to CSV function
    function exportToCSV() {
        const table = document.getElementById('salesTable');
        if (!table) return;

        let csv = [];
        const rows = table.querySelectorAll('tr');

        for (let i = 0; i < rows.length; i++) {
            const row = [];
            const cols = rows[i].querySelectorAll('td, th');

            for (let j = 0; j < cols.length - 1; j++) { // Exclude last column (actions)
                let text = cols[j].innerText.replace(/"/g, '""');
                row.push('"' + text + '"');
            }
            csv.push(row.join(','));
        }

        const csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
        const downloadLink = document.createElement('a');
        downloadLink.download = 'daily_sales_report_' + new Date().toISOString().split('T')[0] + '.csv';
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = 'none';
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
</script>
@endsection
