@extends('layouts.app')

@section('title', 'Sale Details')

@section('content')
<div class="detail-container">
    <div class="page-header">
        <a href="{{ route('sales.index') }}" class="btn btn-outline">&larr; Back to Sales</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Sale #{{ $sale->id }}</h2>
        </div>
        <div class="card-body">
            <div class="details-grid">
                <div class="detail-item">
                    <label>Product</label>
                    <p class="detail-value">{{ $sale->product->name }}</p>
                </div>

                <div class="detail-item">
                    <label>Sold By</label>
                    <p class="detail-value">{{ $sale->user->name }}</p>
                </div>

                <div class="detail-item">
                    <label>Quantity Sold</label>
                    <p class="detail-value">{{ $sale->quantity_sold }} units</p>
                </div>

                <div class="detail-item">
                    <label>Unit Cost</label>
                    <p class="detail-value">₱{{ number_format($sale->unit_cost, 2) }}</p>
                </div>

                <div class="detail-item">
                    <label>Sale Price per Unit</label>
                    <p class="detail-value">₱{{ number_format($sale->sale_price, 2) }}</p>
                </div>

                <div class="detail-item">
                    <label>Total Revenue</label>
                    <p class="detail-value text-success">₱{{ number_format($sale->revenue, 2) }}</p>
                </div>

                <div class="detail-item">
                    <label>Total Cost</label>
                    <p class="detail-value">₱{{ number_format($sale->quantity_sold * $sale->unit_cost, 2) }}</p>
                </div>

                <div class="detail-item">
                    <label>Profit</label>
                    <p class="detail-value text-profit">₱{{ number_format($sale->revenue - ($sale->quantity_sold * $sale->unit_cost), 2) }}</p>
                </div>

                <div class="detail-item">
                    <label>Date & Time</label>
                    <p class="detail-value">{{ $sale->sold_at->format('M d, Y H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->role === 'admin')
    <div class="action-buttons" style="margin-top: 20px; display: flex; gap: 10px;">
        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-warning">Edit Sale</a>
        <form action="{{ route('sales.destroy', $sale) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this sale and restore stock?')">Delete Sale</button>
        </form>
    </div>
    @endif
</div>

<style>
.detail-container {
    padding: 20px;
    max-width: 800px;
    margin: 0 auto;
}

.page-header {
    margin-bottom: 30px;
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

.card-header h2 {
    margin: 0;
    font-size: 1.8rem;
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

.text-success {
    color: #27ae60;
}

.text-profit {
    color: #27ae60;
    font-size: 20px;
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

@media (max-width: 600px) {
    .details-grid {
        grid-template-columns: 1fr;
    }

    .detail-value {
        font-size: 16px;
    }
}
</style>
@endsection
