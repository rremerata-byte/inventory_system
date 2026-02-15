# Rainbow Direct Selling Inventory System - Laravel Conversion

This is a simplified Laravel conversion of the Rainbow Direct Selling inventory system.

## What's Been Created

### 1. **Blade Views** (resources/views/inventory/)
- `login.blade.php` - Login page
- `dashboard.blade.php` - Main dashboard with statistics
- `products/index.blade.php` - Product listing
- `stock/add.blade.php` - Add stock form
- `stock/sold.blade.php` - Record sales
- `stock/alert.blade.php` - Low stock alerts
- `sales/report.blade.php` - Sales reports
- `categories/add.blade.php` - Category management
- `settings/index.blade.php` - Settings menu
- `data/backup.blade.php` - Backup page
- `user/log.blade.php` - Activity log

### 2. **Layout**
- `layouts/inventory.blade.php` - Main layout with rainbow header

### 3. **Controller**
- `InventoryController.php` - Handles all inventory operations

### 4. **Models**
- `Products.php` - Product model
- `Categories.php` - Category model
- `Sales.php` - Sales model

### 5. **Migrations**
- `create_categories_table.php`
- `create_products_table.php`
- `create_sales_table.php`

### 6. **Routes**
All routes are prefixed with `/inventory`:
- `/inventory/login` - Login
- `/inventory/dashboard` - Dashboard
- `/inventory/products` - Product listing
- `/inventory/stock/add` - Add stock
- `/inventory/stock/sold` - Record sales
- `/inventory/sales/report` - Sales report
- `/inventory/settings` - Settings
- `/inventory/categories` - Manage categories

## Setup Instructions

1. **Run Migrations**
   ```bash
   php artisan migrate
   ```

2. **Add Sample Data (Optional)**
   Create some categories and products through the web interface or use tinker:
   ```bash
   php artisan tinker
   ```
   Then:
   ```php
   \App\Models\Categories::create(['name' => 'Electronics']);
   \App\Models\Categories::create(['name' => 'Groceries']);
   ```

3. **Place Rainbow Logo**
   Put your `rainbow.png` image in `public/assets/img/rainbow.png`

4. **Start Server**
   ```bash
   php artisan serve
   ```

5. **Access the System**
   Go to: `http://localhost:8000/inventory/login`

## Features

✅ Simple and clean code structure
✅ Login system (admin/staff roles)
✅ Product management
✅ Stock tracking
✅ Sales recording
✅ Category management
✅ Stock alerts for low inventory
✅ Sales reports with date filters
✅ Dashboard with statistics and charts

## Notes

- The code is kept simple and straightforward
- No complex authentication system (can be added later)
- Uses session for login (upgrade to Laravel auth as needed)
- All styling is embedded in blade templates for simplicity
- Database structure is minimal and easy to understand

## Next Steps (Optional Enhancements)

- Add Laravel authentication middleware
- Create proper user management
- Add export to Excel functionality
- Implement actual backup system
- Add more detailed activity logging
- Create API endpoints if needed
