# 🌈 Rainbow Direct Selling Inventory System

A complete, production-ready Laravel 12 inventory management application with role-based access control, built with Blade templates and a beautiful rainbow-themed UI.

## 🚀 Quick Start (2 Minutes)

### Prerequisites
- PHP 8.2+
- Composer installed
- Node.js & npm installed

### Step 1: Navigate to Project
```bash
cd "c:\Users\USER\Desktop\project_inventory\laravel-app"
```

### Step 2: Install Dependencies (if not done)
```bash
composer install
npm install
```

### Step 3: Start Development Servers

**Terminal 1 - Laravel Server:**
```bash
php artisan serve
```
Runs on: `http://127.0.0.1:8000`

**Terminal 2 - Vite Server:**
```bash
npm run dev
```
Runs on: `http://localhost:5174`

### Step 4: Login
Visit: `http://127.0.0.1:8000`

**Test Credentials:**
```
Admin Account:
  Email: admin@inventory.com
  Password: password

Staff Account:
  Email: staff@inventory.com
  Password: password
```

---

## 📚 Documentation

- **[INVENTORY_SYSTEM.md](./INVENTORY_SYSTEM.md)** - Complete system documentation
- **[COMPLETION_SUMMARY.md](./COMPLETION_SUMMARY.md)** - What was built
- **[QUICK_REFERENCE.md](./QUICK_REFERENCE.md)** - Visual overview & commands

---

## ✨ Features

### Dashboard
- 5 key metrics (Inventory Value, Product Count, Avg Price, Items Sold, Revenue)
- Sales trend chart (Chart.js)
- Low stock alerts (Admin only)
- Recent sales history

### Product Management
- Create/Edit/Delete products
- Search and filter by category
- Stock tracking with status badges
- Profit margin calculations

### Sales Management
- Record sales transactions
- Auto-calculated revenue
- Stock deduction & validation
- Edit/Delete with stock restoration

### Categories (Admin Only)
- Manage product categories
- Custom color assignment
- Color picker UI

### Activity Logging (Admin Only)
- Complete audit trail
- User actions tracking
- Color-coded status

### Security
- Role-based access control (Admin/Staff)
- CSRF protection
- Form validation
- Activity logging

---

## 🎨 Design

- **Rainbow gradient header** (ROYGBIV theme)
- **Responsive layout** (Desktop/Tablet/Mobile)
- **Color-coded badges** (Success, Warning, Danger, Info)
- **Sidebar navigation** with role-based menu items
- **Professional styling** with modern UI patterns

---

## 📊 What's Included

### Database
- 5 core tables (users, categories, products, sales, activity_logs)
- Proper relationships and constraints
- Sample data: 2 users, 6 categories, 14 products

### Code
- 5 Controllers (Dashboard, Product, Sale, Category, ActivityLog)
- 5 Models with relationships
- 5 Migrations
- 16 Blade templates
- 45 configured routes
- Admin middleware for authorization

### Styling
- 1,000+ lines of custom CSS
- Responsive design (mobile-first)
- Color-coded UI elements
- Professional form styling

---

## 🔐 User Roles

### Admin
- Full access to all features
- Edit/Delete products and sales
- Manage categories
- View activity logs
- See low stock alerts

### Staff
- View dashboard
- Search/Browse products
- Create products
- Record sales
- Create new categories

---

## 📁 Project Structure

```
laravel-app/
├── app/
│   ├── Http/Controllers/        ✅ 5 Controllers
│   ├── Http/Middleware/         ✅ AdminMiddleware
│   └── Models/                  ✅ 5 Models
├── database/
│   ├── migrations/              ✅ 5 Migrations
│   └── seeders/                 ✅ InventorySeeder
├── resources/views/
│   ├── layouts/                 ✅ Main layout
│   ├── dashboard.blade.php      ✅
│   ├── products/                ✅ 4 templates
│   ├── sales/                   ✅ 4 templates
│   ├── categories/              ✅ 3 templates
│   └── logs/                    ✅ 1 template
├── routes/web.php               ✅ 45 routes
├── INVENTORY_SYSTEM.md          📖 Full documentation
├── COMPLETION_SUMMARY.md        📋 Build summary
├── QUICK_REFERENCE.md           🎯 Quick guide
└── README.md                    📄 This file
```

---

## 🛠️ Setup (First Time Only)

### Reset Database
If you need to reset the database:
```bash
php artisan migrate:fresh --seed
```

### Clear Cache
```bash
php artisan optimize:clear
```

### View Routes
```bash
php artisan route:list
```

---

## 📝 Key Routes

| Route | Method | Controller | Purpose |
|-------|--------|------------|---------|
| `/dashboard` | GET | DashboardController | Show dashboard with metrics |
| `/products` | GET | ProductController | List all products |
| `/products/create` | GET | ProductController | Create product form |
| `/products` | POST | ProductController | Store new product |
| `/products/{id}` | GET | ProductController | View product details |
| `/products/{id}/edit` | GET | ProductController | Edit product form (admin) |
| `/products/{id}` | PUT | ProductController | Update product (admin) |
| `/products/{id}` | DELETE | ProductController | Delete product (admin) |
| `/sales` | GET | SaleController | List all sales |
| `/sales/create` | GET | SaleController | Create sale form |
| `/sales` | POST | SaleController | Record sale |
| `/sales/{id}` | GET | SaleController | View sale details |
| `/sales/{id}/edit` | GET | SaleController | Edit sale (admin) |
| `/sales/{id}` | PUT | SaleController | Update sale (admin) |
| `/sales/{id}` | DELETE | SaleController | Delete sale (admin) |
| `/categories` | GET | CategoryController | List categories (admin) |
| `/categories/create` | GET | CategoryController | Create category (admin) |
| `/categories` | POST | CategoryController | Store category (admin) |
| `/categories/{id}/edit` | GET | CategoryController | Edit category (admin) |
| `/categories/{id}` | PUT | CategoryController | Update category (admin) |
| `/categories/{id}` | DELETE | CategoryController | Delete category (admin) |
| `/activity-logs` | GET | ActivityLogController | View logs (admin) |

---

## 💾 Database Schema

### Users
- id, name, email, password, role (admin/staff), timestamps

### Categories
- id, name, color_code, timestamps

### Products
- id, name, price, unit_cost, stock, min_stock, category_id, timestamps

### Sales
- id, product_id, user_id, quantity_sold, unit_cost, sale_price, revenue, sold_at, timestamps

### Activity Logs
- id, user_id, action, details, color_class, logged_at, timestamps

---

## 🎯 Common Tasks

### Add a New Product
1. Click **Products** → **+ Add New Product**
2. Fill in product details (name, price, category, stock)
3. Click **Create Product**

### Record a Sale
1. Click **Sales** → **+ Record New Sale**
2. Select product, enter quantity and sale price
3. Revenue auto-calculates
4. Click **Record Sale**

### Manage Categories (Admin)
1. Click **Categories** (admin only)
2. Select a color for the category
3. Click **Create Category**

### View Activity (Admin)
1. Click **Activity Logs** (admin only)
2. See all system actions with user tracking

### Low Stock Alert (Admin)
1. Dashboard shows products with low stock
2. Only visible to admin users
3. Quantity displayed vs min stock level

---

## 🐛 Troubleshooting

### Port Already in Use
If port 8000 or 5174 is in use:

```bash
# Use different port for Laravel
php artisan serve --port=8001

# Vite automatically tries next port (5174)
npm run dev
```

### Database Not Found
```bash
# Reset database
php artisan migrate:fresh --seed
```

### Clear Cache
```bash
php artisan optimize:clear
```

### Check Routes
```bash
php artisan route:list
```

---

## 🔒 Security Notes

- All forms are CSRF protected
- Blade templates prevent XSS
- Passwords are hashed with bcrypt
- Role-based middleware ensures authorization
- All database queries use Eloquent ORM
- Activity logging tracks all actions

---

## 📊 Sample Data

The seeder creates:
- **2 Users**: admin@inventory.com, staff@inventory.com
- **6 Categories**: Natasha, Personal Collection, Avon, BHI, Tupperware, Sunexchange
- **14 Products**: Various items across categories

---

## 🚀 Deployment

For production deployment:

1. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

2. **Database**
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   ```

3. **Build Assets**
   ```bash
   npm run build
   ```

4. **Server Configuration**
   - Use proper web server (Nginx/Apache)
   - Set document root to `public/`
   - Enable HTTPS
   - Configure environment variables

5. **Security**
   - Set `APP_DEBUG=false`
   - Use strong `APP_KEY`
   - Configure mail settings
   - Set proper file permissions

---

## 📞 Support Commands

```bash
# View application logs
tail -f storage/logs/laravel.log

# Create cache table
php artisan table:make cache_table

# Validate routes
php artisan route:list --name=products

# Check tinker shell
php artisan tinker

# Run artisan commands
php artisan help [command]
```

---

## ✅ Implementation Checklist

- ✅ Database setup
- ✅ Models with relationships
- ✅ Controllers with business logic
- ✅ Blade templates
- ✅ Authentication (Breeze)
- ✅ Authorization (Middleware)
- ✅ Form validation
- ✅ Error handling
- ✅ Responsive design
- ✅ Activity logging
- ✅ Sample data
- ✅ Complete documentation

---

## 🎓 Learning Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Blade Template Syntax](https://laravel.com/docs/blade)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [Form Validation](https://laravel.com/docs/validation)

---

## 📝 Notes

- All numeric values displayed in Philippine Peso (₱)
- Stock levels prevent negative inventory
- Sales validation prevents overselling
- Categories can't be deleted if they have products
- Stock is auto-restored when sales are deleted
- Admin has full control, Staff has limited access

---

## 🎉 You're All Set!

Everything is configured and ready to use. Simply:

1. Start Laravel: `php artisan serve`
2. Start Vite: `npm run dev`
3. Visit: `http://127.0.0.1:8000`
4. Login with test credentials
5. Explore the system!

---

**Last Updated**: December 12, 2025
**Status**: ✅ Production Ready
**Version**: 1.0
