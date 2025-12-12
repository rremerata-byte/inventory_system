@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="form-container">
    <div class="page-header">
        <h1>🏷️ Edit Category</h1>
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

            <form action="{{ route('categories.update', $category) }}" method="POST" class="category-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name" class="form-label">Category Name <span class="required">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="e.g., Natasha" value="{{ old('name', $category->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="color_code" class="form-label">Color Code (Optional)</label>
                    <div class="color-picker-wrapper">
                        <input type="color" id="color_code" name="color_code" class="form-control color-picker" value="{{ old('color_code', $category->color_code ?? '#2ecc71') }}" onchange="updateColorPreview()">
                        <input type="text" id="color_code_text" class="form-control color-text" placeholder="#2ecc71" value="{{ old('color_code', $category->color_code ?? '#2ecc71') }}" onchange="updateColorPicker()" readonly>
                        <div id="color-preview" class="color-preview" style="background-color: {{ $category->color_code ?? '#2ecc71' }};"></div>
                    </div>
                    <small class="text-muted">This color will be used to identify products in this category</small>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update Category</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.form-container {
    padding: 20px;
    max-width: 500px;
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

.category-form {
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

.color-picker-wrapper {
    display: flex;
    gap: 10px;
    align-items: center;
}

.color-picker {
    width: 60px;
    height: 44px;
    padding: 2px;
    cursor: pointer;
}

.color-text {
    flex: 1;
    cursor: default;
}

.color-preview {
    width: 44px;
    height: 44px;
    border-radius: 4px;
    border: 1px solid #ddd;
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
    flex: 1;
}

.btn:hover {
    opacity: 0.8;
    transform: translateY(-2px);
}

.btn-primary {
    background: linear-gradient(135deg, #FF0000, #FF7F00, #FFFF00, #00FF00, #0000FF, #4B0082, #9400D3);
    color: white;
}

.btn-secondary {
    background: #95a5a6;
    color: white;
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

.text-muted {
    color: #7f8c8d;
    font-size: 13px;
    display: block;
    margin-top: 8px;
}

@media (max-width: 500px) {
    .color-picker-wrapper {
        flex-direction: column;
    }

    .color-picker {
        width: 100%;
    }

    .color-preview {
        width: 100%;
    }

    .form-actions {
        flex-direction: column;
    }
}
</style>

<script>
function updateColorPreview() {
    const color = document.getElementById('color_code').value;
    document.getElementById('color_code_text').value = color;
    document.getElementById('color-preview').style.backgroundColor = color;
}

function updateColorPicker() {
    const text = document.getElementById('color_code_text').value;
    if (/^#[0-9A-F]{6}$/i.test(text)) {
        document.getElementById('color_code').value = text;
        document.getElementById('color-preview').style.backgroundColor = text;
    }
}
</script>
@endsection
