@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="products-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1>📦 Product Inventory</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add New Product</a>
    </div>

    <!-- Search & Filter -->
    <div class="search-filter">
        <form method="GET" action="{{ route('products.index') }}" class="filter-form">
            <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}" class="form-control">
            <select name="category" class="form-control">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-secondary">Filter</button>
            <a href="{{ route('products.index') }}" class="btn btn-outline">Reset</a>
        </form>
    </div>

    <!-- Products Table -->
    <div class="card">
        <div class="card-header">
            <h3>Product List ({{ $products->total() }} items)</h3>
        </div>
        <div class="card-body">
            @if($products->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Min Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td class="font-weight-bold">{{ $product->name }}</td>
                            <td>
                                <span class="badge" style="background-color: {{ $product->category->color_code }}; color: white;">
                                    {{ $product->category->name }}
                                </span>
                            </td>
                            <td>₱{{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->min_stock }}</td>
                            <td>
                                @if($product->stock == 0)
                                    <span class="badge badge-danger">OUT OF STOCK</span>
                                @elseif($product->stock <= $product->min_stock)
                                    <span class="badge badge-warning">LOW STOCK</span>
                                @else
                                    <span class="badge badge-success">IN STOCK</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-info btn-xs">Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $products->links() }}
            </div>
            @else
            <p class="text-center text-muted">No products found. <a href="{{ route('products.create') }}">Create one now</a></p>
            @endif
        </div>
    </div>
</div>

<style>
.products-container {
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

.badge-warning {
    background: #f39c12;
    color: white;
}

.badge-danger {
    background: #e74c3c;
    color: white;
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

.text-muted {
    color: #7f8c8d;
}

.text-center {
    text-align: center;
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
