@extends('layouts.app')

@section('title', 'Edit Sale')

@section('content')
<div class="form-container">
    <div class="page-header">
        <h1>💰 Edit Sale</h1>
    </div>

    <div class="card">
        <div class="card-body">
            @if($errors->any())
            <div class="alert alert-danger">
                <strong>Please fix the following errors:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('sales.update', $sale) }}" method="POST" class="sale-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="product_id" class="form-label">Product <span class="required">*</span></label>
                    <select id="product_id" name="product_id" class="form-control" required onchange="updateProductInfo()">
                        @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-cost="{{ $product->unit_cost }}" data-stock="{{ $product->stock }}" {{ old('product_id', $sale->product_id) == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} (Stock: {{ $product->stock }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="product-info">
                    <div class="info-item">
                        <label>Original Quantity:</label>
                        <p id="original-qty">{{ $sale->quantity_sold }}</p>
                    </div>
                    <div class="info-item">
                        <label>Available Stock:</label>
                        <p id="available-stock">-</p>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="quantity_sold" class="form-label">Quantity Sold <span class="required">*</span></label>
                        <input type="number" id="quantity_sold" name="quantity_sold" class="form-control" placeholder="1" min="1" value="{{ old('quantity_sold', $sale->quantity_sold) }}" required onchange="updateRevenue()" onkeyup="updateRevenue()">
                    </div>

                    <div class="form-group">
                        <label for="unit_cost" class="form-label">Unit Cost (₱) <span class="required">*</span></label>
                        <input type="number" id="unit_cost" name="unit_cost" class="form-control" placeholder="0.00" step="0.01" min="0" value="{{ old('unit_cost', $sale->unit_cost) }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="sale_price" class="form-label">Sale Price per Unit (₱) <span class="required">*</span></label>
                        <input type="number" id="sale_price" name="sale_price" class="form-control" placeholder="0.00" step="0.01" min="0" value="{{ old('sale_price', $sale->sale_price) }}" required onchange="updateRevenue()" onkeyup="updateRevenue()">
                    </div>

                    <div class="form-group">
                        <label for="revenue" class="form-label">Total Revenue (₱)</label>
                        <input type="number" id="revenue" class="form-control" placeholder="0.00" step="0.01" value="{{ $sale->revenue }}" disabled>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update Sale</button>
                    <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.form-container {
    padding: 20px;
    max-width: 600px;
    margin: 0 auto;
}

.page-header {
    margin-bottom: 30px;
}

.page-header h1 {
    font-size: 2rem;
    margin: 0;
}

.card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

.card-body {
    padding: 30px;
}

.sale-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-label {
    font-weight: 600;
    margin-bottom: 8px;
    color: #2c3e50;
    font-size: 14px;
}

.required {
    color: #e74c3c;
}

.form-control {
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    font-family: inherit;
}

.form-control:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.2);
}

.product-info {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 4px;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

.info-item {
    display: flex;
    flex-direction: column;
}

.info-item label {
    font-size: 12px;
    color: #7f8c8d;
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 5px;
}

.info-item p {
    font-size: 16px;
    font-weight: bold;
    color: #2c3e50;
    margin: 0;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-actions {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin-top: 20px;
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.2s;
}

.btn:hover {
    opacity: 0.8;
    transform: translateY(-2px);
}

.btn-primary {
    background: linear-gradient(135deg, #FF0000, #FF7F00, #FFFF00, #00FF00, #0000FF, #4B0082, #9400D3);
    color: white;
    flex: 1;
}

.btn-secondary {
    background: #95a5a6;
    color: white;
    flex: 1;
}

.alert {
    padding: 15px 20px;
    border-radius: 4px;
    margin-bottom: 20px;
    border-left: 4px solid;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border-left-color: #e74c3c;
}

.alert-danger ul {
    margin: 10px 0 0 20px;
    padding: 0;
}

.alert-danger li {
    margin: 5px 0;
}

@media (max-width: 600px) {
    .product-info {
        grid-template-columns: 1fr;
    }

    .form-row {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
    }
}
</style>

<script>
function updateProductInfo() {
    const select = document.getElementById('product_id');
    const option = select.options[select.selectedIndex];
    
    if (option.value) {
        document.getElementById('available-stock').textContent = option.dataset.stock + ' units';
    } else {
        document.getElementById('available-stock').textContent = '-';
    }
}

function updateRevenue() {
    const quantity = parseFloat(document.getElementById('quantity_sold').value) || 0;
    const salePrice = parseFloat(document.getElementById('sale_price').value) || 0;
    const revenue = (quantity * salePrice).toFixed(2);
    document.getElementById('revenue').value = revenue;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateProductInfo();
});
</script>
@endsection
