@extends('layouts.app')

@section('title', 'Sales')

@section('content')
<div class="sales-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1>💰 Sales Management</h1>
        <a href="{{ route('sales.create') }}" class="btn btn-primary">+ Record New Sale</a>
    </div>

    <!-- Search & Filter -->
    <div class="search-filter">
        <form method="GET" action="{{ route('sales.index') }}" class="filter-form">
            <input type="text" name="search" placeholder="Search product name..." value="{{ request('search') }}" class="form-control">
            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            <button type="submit" class="btn btn-secondary">Filter</button>
            <a href="{{ route('sales.index') }}" class="btn btn-outline">Reset</a>
        </form>
    </div>

    <!-- Sales Table -->
    <div class="card">
        <div class="card-header">
            <h3>Sales Records ({{ $sales->total() }} total)</h3>
        </div>
        <div class="card-body">
            @if($sales->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Product</th>
                            <th>Sold By</th>
                            <th>Quantity</th>
                            <th>Unit Cost</th>
                            <th>Sale Price</th>
                            <th>Revenue</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                        <tr>
                            <td>{{ $sale->sold_at->format('M d, Y H:i') }}</td>
                            <td class="font-weight-bold">{{ $sale->product->name }}</td>
                            <td>{{ $sale->user->name }}</td>
                            <td>{{ $sale->quantity_sold }}</td>
                            <td>₱{{ number_format($sale->unit_cost, 2) }}</td>
                            <td>₱{{ number_format($sale->sale_price, 2) }}</td>
                            <td class="font-weight-bold text-success">₱{{ number_format($sale->revenue, 2) }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('sales.show', $sale) }}" class="btn btn-info btn-xs">View</a>
                                    @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('sales.edit', $sale) }}" class="btn btn-warning btn-xs">Edit</a>
                                    <form action="{{ route('sales.destroy', $sale) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Delete this sale and restore stock?')">Delete</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $sales->links() }}
            </div>
            @else
            <p class="text-center text-muted">No sales recorded yet. <a href="{{ route('sales.create') }}">Record your first sale</a></p>
            @endif
        </div>
    </div>
</div>

<style>
.sales-container {
    padding: 20px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.page-header h1 {
    font-size: 2rem;
    margin: 0;
}

.search-filter {
    background: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.filter-form {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.form-control {
    flex: 1;
    min-width: 150px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.form-control:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.2);
}

.card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

.card-header {
    background: #f8f9fa;
    padding: 20px;
    border-bottom: 1px solid #e9ecef;
}

.card-header h3 {
    margin: 0;
    font-size: 1.3rem;
    color: #2c3e50;
}

.card-body {
    padding: 20px;
}

.table-responsive {
    overflow-x: auto;
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

.font-weight-bold {
    font-weight: bold;
}

.text-success {
    color: #27ae60;
}

.text-muted {
    color: #7f8c8d;
}

.text-center {
    text-align: center;
}

.action-buttons {
    display: flex;
    gap: 5px;
    flex-wrap: wrap;
}

.btn {
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.2s;
}

.btn:hover {
    opacity: 0.8;
    transform: translateY(-1px);
}

.btn-primary {
    background: linear-gradient(135deg, #FF0000, #FF7F00, #FFFF00, #00FF00, #0000FF, #4B0082, #9400D3);
    color: white;
    padding: 10px 20px;
}

.btn-secondary {
    background: #95a5a6;
    color: white;
}

.btn-info {
    background: #3498db;
    color: white;
}

.btn-warning {
    background: #f39c12;
    color: white;
}

.btn-danger {
    background: #e74c3c;
    color: white;
}

.btn-outline {
    background: transparent;
    color: #7f8c8d;
    border: 1px solid #ddd;
}

.btn-xs {
    padding: 4px 8px;
    font-size: 11px;
}

.pagination-wrapper {
    margin-top: 20px;
    display: flex;
    justify-content: center;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }

    .filter-form {
        flex-direction: column;
    }

    .form-control {
        width: 100%;
    }

    .data-table {
        font-size: 12px;
    }

    .data-table th, .data-table td {
        padding: 8px;
    }
}
</style>
@endsection
