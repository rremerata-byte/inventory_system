@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="categories-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1>🏷️ Product Categories</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">+ Add New Category</a>
    </div>

    <!-- Categories Grid -->
    <div class="categories-grid">
        @forelse($categories as $category)
        <div class="category-card">
            <div class="category-color" style="background-color: {{ $category->color_code ?? '#95a5a6' }};"></div>
            <div class="category-content">
                <h3>{{ $category->name }}</h3>
                <p class="product-count">{{ $category->products_count }} product{{ $category->products_count != 1 ? 's' : '' }}</p>
                <div class="color-code">
                    @if($category->color_code)
                    <small>{{ $category->color_code }}</small>
                    @else
                    <small class="text-muted">No color assigned</small>
                    @endif
                </div>
            </div>
            <div class="category-actions">
                <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">Edit</a>
                @if($category->products_count == 0)
                <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this category?')">Delete</button>
                </form>
                @else
                <button type="button" class="btn btn-secondary btn-sm" disabled title="Cannot delete categories with products">Delete</button>
                @endif
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 40px;">
            <p class="text-muted">No categories found. <a href="{{ route('categories.create') }}">Create one now</a></p>
        </div>
        @endforelse
    </div>
</div>

<style>
.categories-container {
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

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}

.category-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.15);
}

.category-color {
    height: 100px;
    width: 100%;
}

.category-content {
    padding: 20px;
    border-bottom: 1px solid #eee;
}

.category-content h3 {
    margin: 0 0 10px 0;
    font-size: 1.3rem;
    color: #2c3e50;
}

.product-count {
    font-size: 14px;
    color: #7f8c8d;
    margin: 0 0 10px 0;
}

.color-code {
    font-family: monospace;
    color: #7f8c8d;
}

.color-code small {
    font-size: 12px;
}

.category-actions {
    padding: 15px 20px;
    display: flex;
    gap: 5px;
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
    flex: 1;
    text-align: center;
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

.btn-warning {
    background: #f39c12;
    color: white;
}

.btn-danger {
    background: #e74c3c;
    color: white;
}

.btn-secondary {
    background: #95a5a6;
    color: white;
    cursor: not-allowed;
    opacity: 0.6;
}

.btn-sm {
    padding: 6px 10px;
    font-size: 11px;
}

.text-muted {
    color: #7f8c8d;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }

    .categories-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }
}
</style>
@endsection
