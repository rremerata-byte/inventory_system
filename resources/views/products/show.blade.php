@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="product-detail-container">
    <div class="page-header">
        <a href="{{ route('products.index') }}" class="btn btn-outline">&larr; Back to Products</a>
        @if(auth()->user()->role === 'admin')
        <div class="action-buttons">
            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this product?')">Delete</button>
            </form>
        </div>
        @endif
    </div>

    <div class="product-details">
        <div class="card">
            <div class="card-header">
                <h2>{{ $product->name }}</h2>
            </div>
            <div class="card-body">
                <div class="details-grid">
                    <div class="detail-item">
                        <label>Category</label>
                        <p>
                            <span class="badge" style="background-color: {{ $product->category->color_code }}; color: white;">
                                {{ $product->category->name }}
                            </span>
                        </p>
                    </div>

                    <div class="detail-item">
                        <label>Sale Price</label>
                        <p class="detail-value">₱{{ number_format($product->price, 2) }}</p>
                    </div>

                    <div class="detail-item">
                        <label>Unit Cost</label>
                        <p class="detail-value">₱{{ number_format($product->unit_cost, 2) }}</p>
                    </div>

                    <div class="detail-item">
                        <label>Profit Margin</label>
                        <p class="detail-value">₱{{ number_format($product->price - $product->unit_cost, 2) }} ({{ round((($product->price - $product->unit_cost) / $product->unit_cost * 100), 1) }}%)</p>
                    </div>

                    <div class="detail-item">
                        <label>Current Stock</label>
                        <p class="detail-value">{{ $product->stock }} units</p>
                    </div>

                    <div class="detail-item">
                        <label>Minimum Stock</label>
                        <p class="detail-value">{{ $product->min_stock }} units</p>
                    </div>

                    <div class="detail-item">
                        <label>Stock Status</label>
                        <p>
                            @if($product->stock == 0)
                                <span class="badge badge-danger">OUT OF STOCK</span>
                            @elseif($product->stock <= $product->min_stock)
                                <span class="badge badge-warning">LOW STOCK</span>
                            @else
                                <span class="badge badge-success">IN STOCK</span>
                            @endif
                        </p>
                    </div>

                    <div class="detail-item">
                        <label>Inventory Value</label>
                        <p class="detail-value">₱{{ number_format($product->price * $product->stock, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if($product->sales->count() > 0)
        <div class="card">
            <div class="card-header">
                <h3>📊 Sales History</h3>
            </div>
            <div class="card-body">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Sold By</th>
                            <th>Quantity</th>
                            <th>Unit Cost</th>
                            <th>Sale Price</th>
                            <th>Revenue</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->sales()->latest('sold_at')->take(10)->get() as $sale)
                        <tr>
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
            </div>
        </div>
        @endif
    </div>
</div>

<style>
.product-detail-container {
    padding: 20px;
    max-width: 1000px;
    margin: 0 auto;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    gap: 15px;
}

.action-buttons {
    display: flex;
    gap: 10px;
}

.card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
    margin-bottom: 20px;
}

.card-header {
    background: #f8f9fa;
    padding: 20px;
    border-bottom: 1px solid #e9ecef;
}

.card-header h2 {
    margin: 0;
    font-size: 1.8rem;
    color: #2c3e50;
}

.card-header h3 {
    margin: 0;
    font-size: 1.3rem;
    color: #2c3e50;
}

.card-body {
    padding: 30px;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
}

.detail-item {
    border-bottom: 1px solid #eee;
    padding-bottom: 15px;
}

.detail-item label {
    display: block;
    font-size: 12px;
    color: #7f8c8d;
    text-transform: uppercase;
    margin-bottom: 8px;
    font-weight: 600;
}

.detail-value {
    font-size: 18px;
    font-weight: bold;
    color: #2c3e50;
    margin: 0;
}

.badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 13px;
    font-weight: 600;
}

.badge-success {
    background: #27ae60;
    color: white;
}

.badge-warning {
    background: #f39c12;
    color: white;
}

.badge-danger {
    background: #e74c3c;
    color: white;
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

.btn {
    padding: 10px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s;
}

.btn:hover {
    opacity: 0.8;
    transform: translateY(-2px);
}

.btn-outline {
    background: transparent;
    color: #2c3e50;
    border: 1px solid #ddd;
}

.btn-warning {
    background: #f39c12;
    color: white;
}

.btn-danger {
    background: #e74c3c;
    color: white;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .action-buttons {
        width: 100%;
    }

    .details-grid {
        grid-template-columns: 1fr;
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
