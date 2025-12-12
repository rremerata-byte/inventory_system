# Rainbow Direct Selling Inventory System

A complete Laravel 12 inventory management system with role-based access control (admin/staff), product management, sales tracking, and activity logging.

## ✨ Features Completed

### 🔐 Authentication & Authorization
- Laravel Breeze authentication (login/register/password reset)
- Role-based access control (Admin/Staff)
- Admin middleware for protected routes
- Session-based authentication

### 📊 Dashboard
- 5 key metrics (Inventory Value, Product Count, Avg Price, Items Sold, Total Revenue)
- Sales trend chart (last 30 days) using Chart.js
- Low stock alerts (admin only)
- Recent sales history
- Real-time data calculations

### 📦 Product Management
- **Index**: Full product listing with search, filter by category, pagination
- **Create**: Add new products with category selection, pricing, stock levels
- **Edit**: Update product details (admin only)
- **Show**: Detailed product view with profit margins, inventory value, sales history
- **Delete**: Remove products (admin only)
- Color-coded categories for easy identification
- Stock status badges (In Stock, Low Stock, Out of Stock)

### 💰 Sales Management
- **Index**: Complete sales transaction history with date filtering
- **Create**: Log new sales with auto-calculated revenue
- **Edit**: Modify sales records with stock restoration (admin only)
- **Show**: Detailed sale view with profit calculations
- **Delete**: Remove sales and automatically restore stock (admin only)
- Stock validation to prevent overselling
- Unit cost and sale price tracking per transaction

### 🏷️ Category Management (Admin Only)
- Create product categories with custom colors
- Edit category details
- Delete categories (only if no products)
- Color preview for easy identification
- Product count per category

### 📋 Activity Logs (Admin Only)
- Complete audit trail of all system actions
- Tracks: Creates, Updates, Deletes, Sales records
- User information for each action
- Color-coded status indicators
- Paginated log viewing

## 🏗️ Database Structure

### Users Table
- id, name, email, password, role (admin/staff), timestamps

### Categories Table
- id, name, color_code, timestamps

### Products Table
- id, name, price, unit_cost, stock, min_stock, category_id, timestamps

### Sales Table
- id, product_id, user_id, quantity_sold, unit_cost, sale_price, revenue, sold_at, timestamps

### Activity Logs Table
- id, user_id, action, details, color_class, logged_at, timestamps

## 🎨 UI/Design

### Rainbow Theme
- Linear gradient header: Red → Orange → Yellow → Green → Blue → Indigo → Violet
- Responsive design with mobile-first approach
- Clean, modern interface with card-based layout
- Color-coded badges and status indicators

### Components
- Sidebar navigation with role-based menu items
- Search and filter forms
- Data tables with hover effects
- Forms with validation error display
- Pagination support
- Color picker for categories

## 🔑 Test Credentials

```
Admin Account:
Email: admin@inventory.com
Password: password

Staff Account:
Email: staff@inventory.com
Password: password
```

## 📁 Project Structure

```
laravel-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php
│   │   │   ├── ProductController.php
│   │   │   ├── SaleController.php
│   │   │   ├── CategoryController.php
│   │   │   └── ActivityLogController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/
│       ├── Product.php
│       ├── Sale.php
│       ├── Category.php
│       ├── ActivityLog.php
│       └── User.php
├── database/
│   ├── migrations/
│   │   ├── 2025_12_11_214622_create_categories_table.php
│   │   ├── 2025_12_11_214623_create_products_table.php
│   │   ├── 2025_12_11_214624_create_sales_table.php
│   │   ├── 2025_12_11_214626_create_activity_logs_table.php
│   │   └── 2025_12_11_214728_add_role_to_users_table.php
│   └── seeders/
│       ├── InventorySeeder.php
│       └── DatabaseSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php (Rainbow-themed layout)
│       ├── dashboard.blade.php
│       ├── products/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       ├── sales/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       ├── categories/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       └── logs/
│           └── index.blade.php
└── routes/
    └── web.php
```

## 🚀 Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- SQLite or MySQL

### Installation

1. **Clone/Extract Project**
```bash
cd c:\Users\USER\Desktop\project_inventory\laravel-app
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Configure Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Run Migrations & Seed**
```bash
php artisan migrate:fresh --seed
```

5. **Start Development Servers**

Terminal 1 - Laravel Dev Server:
```bash
php artisan serve
```

Terminal 2 - Vite Dev Server:
```bash
npm run dev
```

6. **Access Application**
```
http://127.0.0.1:8000
```

## 📊 Sample Data

The InventorySeeder creates:
- **6 Categories**: Natasha, Personal Collection, Avon, BHI, Tupperware, Sunexchange
- **2 Users**: admin@inventory.com (admin), staff@inventory.com (staff)
- **14 Sample Products**: With realistic prices and stock levels

## 🔐 Security Features

- CSRF protection on all forms
- Blade templating for XSS protection
- Role-based authorization middleware
- Model relationships for data integrity
- Foreign key constraints
- Activity logging for audit trails

## 📱 Responsive Design

- Desktop: Full sidebar navigation
- Tablet: Responsive grid layouts
- Mobile: Stack-based layouts with optimized forms

## 🎯 Admin-Only Features

- Edit/Delete products
- Edit/Delete sales records
- Stock restoration on sale deletion
- Category management
- View complete activity logs
- Low stock alerts on dashboard

## 🛠️ Technology Stack

- **Backend**: Laravel 12
- **Frontend**: Blade templates with vanilla JavaScript
- **Database**: SQLite (development)
- **Charts**: Chart.js
- **Build**: Vite
- **Authentication**: Laravel Breeze
- **Styling**: Custom CSS with responsive design

## 📝 Routes

### Public Routes
- `POST /login` - User login
- `POST /register` - User registration

### Authenticated Routes
- `GET /dashboard` - Dashboard with metrics
- `GET /products` - Product listing
- `GET /products/create` - Create product form
- `POST /products` - Store product
- `GET /products/{id}` - View product details
- `GET /products/{id}/edit` - Edit product form
- `PUT /products/{id}` - Update product
- `DELETE /products/{id}` - Delete product
- `GET /sales` - Sales listing
- `GET /sales/create` - Create sale form
- `POST /sales` - Record sale
- `GET /sales/{id}` - View sale details
- `GET /sales/{id}/edit` - Edit sale form (admin)
- `PUT /sales/{id}` - Update sale (admin)
- `DELETE /sales/{id}` - Delete sale (admin)

### Admin Routes
- `GET /categories` - Category listing
- `GET /categories/create` - Create category form
- `POST /categories` - Store category
- `GET /categories/{id}/edit` - Edit category form
- `PUT /categories/{id}` - Update category
- `DELETE /categories/{id}` - Delete category
- `GET /activity-logs` - Activity log listing

## ✅ Status

**COMPLETE** - All core features implemented and tested:
✅ Database migrations
✅ Eloquent models with relationships
✅ CRUD controllers with authorization
✅ Blade templates with rainbow theme
✅ Authentication system
✅ Role-based access control
✅ Activity logging
✅ Dashboard with charts
✅ Responsive design
✅ Form validation
✅ Error handling

## 📄 Notes

- All numeric values formatted as Philippine Peso (₱)
- Stock levels are validated to prevent negative inventory
- Sales cannot be recorded for out-of-stock items
- Categories cannot be deleted if they have products
- All actions are logged for audit purposes
- Admin users have full control, Staff users have limited access

## 🎨 Customization

To customize the color scheme:
1. Edit `.rainbow-header` in `/resources/views/layouts/app.blade.php`
2. Modify badge colors in individual view files
3. Update category colors through the admin panel
