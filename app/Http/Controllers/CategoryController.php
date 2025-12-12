<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories',
            'color_code' => 'nullable|regex:/^#[0-9A-F]{6}$/i',
        ]);

        $category = Category::create($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Category Created',
            'details' => "Category '{$category->name}' created",
            'color_class' => 'badge-success'
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    /**
     * Show the specified resource.
     */
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
            'color_code' => 'nullable|regex:/^#[0-9A-F]{6}$/i',
        ]);

        $category->update($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Category Updated',
            'details' => "Category '{$category->name}' updated",
            'color_class' => 'badge-info'
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->withErrors(['delete' => 'Cannot delete category with existing products.']);
        }

        $name = $category->name;
        $category->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Category Deleted',
            'details' => "Category '{$name}' deleted",
            'color_class' => 'badge-danger'
        ]);

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}
