<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Public dashboard (guests can view it)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Products
Route::resource('/products', ProductController::class);

// Sales
Route::resource('/sales', SaleController::class);

// Categories (Admin only)
Route::middleware('admin')->resource('/categories', CategoryController::class);

// Activity Logs (Admin only)
Route::middleware('admin')->get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

// Profile
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// Auth routes (Breeze/Fortify)
if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}

// Route aliases to mirror original static HTML filenames
Route::get('/productlisting', function () {
    return redirect()->route('products.index');
})->name('productlisting');

Route::get('/stock_add', function () {
    return redirect()->route('products.create');
})->name('stock_add');

Route::get('/stock_sold', function () {
    return redirect()->route('sales.create');
})->name('stock_sold');

Route::get('/daily_sales_report', [SaleController::class, 'dailyReport'])->name('daily_sales_report');

Route::get('/settings', function () {
    return view('settings');
})->name('settings');

Route::get('/user_log', function () {
    return redirect()->route('activity-logs.index');
})->name('user_log');

Route::get('/stock_alert', [DashboardController::class, 'index'])->name('stock_alert');

Route::get('/add_category', function () {
    return redirect()->route('categories.create');
})->name('add_category');
