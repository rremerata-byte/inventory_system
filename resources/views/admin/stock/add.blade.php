@extends('layouts.inventory')

@section('title', 'Add Stock - Rainbow Direct Selling')

@section('content')
<main class="container">
    <h1>Add Stock</h1>
    <form action="{{ route('admin.stock.store') }}" method="POST">
        @csrf
        <label for="product_id">Product</label>
        <select id="product_id" name="product_id" required>
            <option value="">Select Product</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
            @endforeach
        </select>

        <label for="product_name">Or Add New Product</label>
        <input type="text" id="product_name" name="product_name" placeholder="New Product Name">

        <label for="category_id">Category</label>
        <select id="category_id" name="category_id">
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <label for="quantity">Quantity to Add</label>
        <input type="number" id="quantity" name="quantity" min="1" placeholder="Quantity" required>

        <label for="unit_cost">Unit Cost (₱)</label>
        <input type="number" id="unit_cost" name="unit_cost" min="0.01" step="0.01" placeholder="0.00" required>

        <button type="submit" class="btn btn-primary">Add Stock</button>
    </form>
</main>
@endsection
