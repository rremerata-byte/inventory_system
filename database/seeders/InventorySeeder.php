<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'Natasha', 'color_code' => '#2ecc71'],
            ['name' => 'Personal Collection', 'color_code' => '#8b4513'],
            ['name' => 'Avon', 'color_code' => '#16a085'],
            ['name' => 'BHI', 'color_code' => '#8b4513'],
            ['name' => 'Tupperware', 'color_code' => '#e67e22'],
            ['name' => 'Sunexchange', 'color_code' => '#f39c12'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create users
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@inventory.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Staff User',
            'email' => 'staff@inventory.com',
            'password' => Hash::make('password'),
            'role' => 'staff'
        ]);

        // Create sample products
        $products = [
            ['name' => 'Natasha Cream 50ml', 'price' => 450, 'unit_cost' => 200, 'stock' => 25, 'min_stock' => 5, 'category_id' => 1],
            ['name' => 'Natasha Serum 30ml', 'price' => 550, 'unit_cost' => 250, 'stock' => 15, 'min_stock' => 5, 'category_id' => 1],
            ['name' => 'Natasha Face Wash', 'price' => 350, 'unit_cost' => 150, 'stock' => 30, 'min_stock' => 5, 'category_id' => 1],
            ['name' => 'Personal Collection Soap', 'price' => 120, 'unit_cost' => 50, 'stock' => 60, 'min_stock' => 10, 'category_id' => 2],
            ['name' => 'Personal Collection Lotion', 'price' => 280, 'unit_cost' => 120, 'stock' => 20, 'min_stock' => 5, 'category_id' => 2],
            ['name' => 'Avon Lipstick', 'price' => 180, 'unit_cost' => 80, 'stock' => 40, 'min_stock' => 10, 'category_id' => 3],
            ['name' => 'Avon Perfume', 'price' => 650, 'unit_cost' => 300, 'stock' => 12, 'min_stock' => 3, 'category_id' => 3],
            ['name' => 'BHI Vitamin C', 'price' => 420, 'unit_cost' => 180, 'stock' => 18, 'min_stock' => 5, 'category_id' => 4],
            ['name' => 'Tupperware Container 2L', 'price' => 280, 'unit_cost' => 120, 'stock' => 35, 'min_stock' => 10, 'category_id' => 5],
            ['name' => 'Tupperware Container 5L', 'price' => 480, 'unit_cost' => 220, 'stock' => 22, 'min_stock' => 5, 'category_id' => 5],
            ['name' => 'Sunexchange Solar Charger', 'price' => 1200, 'unit_cost' => 550, 'stock' => 8, 'min_stock' => 2, 'category_id' => 6],
            ['name' => 'Sunexchange LED Light', 'price' => 850, 'unit_cost' => 400, 'stock' => 5, 'min_stock' => 2, 'category_id' => 6],
            ['name' => 'Natasha Mask Sheet', 'price' => 250, 'unit_cost' => 100, 'stock' => 40, 'min_stock' => 10, 'category_id' => 1],
            ['name' => 'Personal Collection Shampoo', 'price' => 180, 'unit_cost' => 80, 'stock' => 25, 'min_stock' => 5, 'category_id' => 2],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
