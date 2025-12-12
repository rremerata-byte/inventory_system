@extends('layouts.app')

@section('title', 'Record New Sale')

@section('content')
<div class="form-container">
    <div class="page-header">
        <h1>💰 Record New Sale</h1>
    </div>

    <div class="card">
        @if($errors->any())
        <div class="alert">
            <strong>Please fix the following errors:</strong>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('sales.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="product_id" class="form-label">Product <span class="required">*</span></label>
                <select id="product_id" name="product_id" class="form-control" required onchange="updateProductInfo()">
                    <option value="">Select a product</option>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-cost="{{ $product->unit_cost }}" data-stock="{{ $product->stock }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }} (Stock: {{ $product->stock }})
                    </option>
                    @endforeach
                </select>
            </div>

            
            <div class="form-group">
                <label for="quantity_sold" class="form-label">Quantity <span class="required">*</span></label>
                <input type="number" id="quantity_sold" name="quantity_sold" class="form-control" placeholder="1" min="1" value="{{ old('quantity_sold') }}" required onchange="updateRevenue()" onkeyup="updateRevenue()">
            </div>

            <div class="form-group">
                <label for="unit_cost" class="form-label">Unit Cost (₱) <span class="required">*</span></label>
                <input type="number" id="unit_cost" name="unit_cost" class="form-control" placeholder="0.00" step="0.01" min="0" value="{{ old('unit_cost') }}" required>
            </div>

            <div class="form-group">
                <label for="sale_price" class="form-label">Sale Price (₱) <span class="required">*</span></label>
                <input type="number" id="sale_price" name="sale_price" class="form-control" placeholder="0.00" step="0.01" min="0" value="{{ old('sale_price') }}" required onchange="updateRevenue()" onkeyup="updateRevenue()">
            </div>

            <div class="form-group">
                <label for="revenue" class="form-label">Total Revenue (₱)</label>
                <input type="number" id="revenue" class="form-control" placeholder="0.00" step="0.01" disabled>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Record Sale</button>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<style>
.form-container {
    padding: 20px;
    max-width: 550px;
    margin: 0 auto;
}

.page-header h1 {
    font-size: 1.5rem;
    margin-bottom: 20px;
    color: #333;
}

.card {
    background: white;
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 25px;
}

.form-group {
    margin-bottom: 18px;
}

.form-label {
    font-weight: 600;
    margin-bottom: 6px;
    color: #333;
    font-size: 14px;
    display: block;
}

.required {
    color: #e74c3c;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #666;
}

.product-info {
    background: #f5f5f5;
    padding: 12px;
    border-radius: 4px;
    margin-bottom: 18px;
    border: 1px solid #e0e0e0;
}

.info-item {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
}

.info-item label {
    font-size: 13px;
    color: #666;
    font-weight: 600;
}

.info-item p {
    font-size: 13px;
    font-weight: 600;
    color: #333;
    margin: 0;
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 25px;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    flex: 1;
}

.btn-primary {
    background: #007bff;
    color: white;
}

.btn-primary:hover {
    background: #0056b3;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

.alert {
    padding: 12px 15px;
    border-radius: 4px;
    margin-bottom: 20px;
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert ul {
    margin: 8px 0 0 20px;
    padding: 0;
}

.alert li {
    margin: 4px 0;
}
</style>

<script>
function updateProductInfo() {
    const select = document.getElementById('product_id');
    const option = select.options[select.selectedIndex];
    
    if (option.value) {
        document.getElementById('available-stock').textContent = option.dataset.stock + ' units';
        document.getElementById('unit-cost').textContent = '₱' + parseFloat(option.dataset.cost).toFixed(2);
        document.getElementById('default-price').textContent = '₱' + parseFloat(option.dataset.price).toFixed(2);
        
        // Set form values
        document.getElementById('unit_cost').value = option.dataset.cost;
        document.getElementById('sale_price').value = option.dataset.price;
        updateRevenue();
    } else {
        document.getElementById('available-stock').textContent = '-';
        document.getElementById('unit-cost').textContent = '-';
        document.getElementById('default-price').textContent = '-';
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
    if (document.getElementById('product_id').value) {
        updateProductInfo();
    }
});
</script>
@endsection
