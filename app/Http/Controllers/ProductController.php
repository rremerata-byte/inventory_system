<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search by product name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->paginate(15);
        $categories = Category::all();
        $view = auth()->user()?->role === 'admin'
            ? 'admin.products.index'
            : 'user.products.index';

        return view($view, compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:products',
            'price' => 'required|numeric|min:0',
            'unit_cost' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::create($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Product Created',
            'details' => "Product '{$product->name}' created",
            'color_class' => 'badge-success'
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $this->authorize('admin');
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('admin');

        $validated = $request->validate([
            'name' => 'required|unique:products,name,' . $product->id,
            'price' => 'required|numeric|min:0',
            'unit_cost' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $oldName = $product->name;
        $product->update($validated);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Product Updated',
            'details' => "Product '{$oldName}' updated",
            'color_class' => 'badge-info'
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('admin');

        $name = $product->name;
        $product->delete();

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Product Deleted',
            'details' => "Product '{$name}' deleted",
            'color_class' => 'badge-danger'
        ]);

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    /**
     * Authorize admin actions
     */
    private function authorize($role)
    {
        if (auth()->user()->role !== $role) {
            abort(403, 'Unauthorized action.');
        }
    }
}
