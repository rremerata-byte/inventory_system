@extends('layouts.app')

@section('title', 'Add New Product')

@section('content')
<div class="form-container">
    <div class="page-header">
        <h1>📦 Add New Product</h1>
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

            <form action="{{ route('products.store') }}" method="POST" class="product-form">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Product Name <span class="required">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="e.g., Natasha Moisturizing Cream" value="{{ old('name') }}" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category_id" class="form-label">Category <span class="required">*</span></label>
                        <select id="category_id" name="category_id" class="form-control" required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price" class="form-label">Sale Price (₱) <span class="required">*</span></label>
                        <input type="number" id="price" name="price" class="form-control" placeholder="0.00" step="0.01" min="0" value="{{ old('price') }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="unit_cost" class="form-label">Unit Cost (₱) <span class="required">*</span></label>
                        <input type="number" id="unit_cost" name="unit_cost" class="form-control" placeholder="0.00" step="0.01" min="0" value="{{ old('unit_cost') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="stock" class="form-label">Current Stock <span class="required">*</span></label>
                        <input type="number" id="stock" name="stock" class="form-control" placeholder="0" min="0" value="{{ old('stock') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="min_stock" class="form-label">Minimum Stock Level <span class="required">*</span></label>
                    <input type="number" id="min_stock" name="min_stock" class="form-control" placeholder="5" min="0" value="{{ old('min_stock') }}" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Create Product</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
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

.product-form {
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
@endsection
