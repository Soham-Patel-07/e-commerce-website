# E-Commerce Multi-Vendor Platform
## Complete Project Documentation

---

## 1. Project Overview

### 1.1 Project Description
Multi-vendor e-commerce platform similar to Amazon where multiple sellers can list products and buyers can purchase them. The system supports three user roles with full authentication and role-based access control.

### 1.2 Technology Stack
| Component | Technology |
|-----------|------------|
| Backend | PHP 8.2, Laravel 12.x |
| Database | MySQL (XAMPP) |
| Frontend | Bootstrap 5, Font Awesome 6 |
| Templating | Blade Templates |
| Server | PHP Built-in Server / XAMPP Apache |

### 1.3 Project Location
```
C:\xampp\htdocs\ecom
```

---

## 2. User Roles & Features

### 2.1 ADMIN (Pre-created)
**Cannot register - credentials pre-seeded in database**

**Login Credentials:**
- Email: `admin@ecom.com`
- Password: `admin123`

**Features:**
- Dashboard with system statistics
- View all buyers and sellers
- Block/unblock users
- Delete users
- Approve/reject products
- Remove products
- View all orders
- Total revenue tracking

### 2.2 SELLER (Vendor)
**Registration required**

**Features:**
- Seller dashboard showing:
  - Total products count
  - Total sales count
  - Total earnings
- Add new products with images
- Edit/delete own products
- Upload product images
- Manage stock (quantity)
- View orders for their products
- **Ship/Deliver orders** (new feature added)
- Track earnings
- Profile update

### 2.3 BUYER (Customer)
**Registration required**

**Features:**
- Register, login, logout
- Browse all products
- Search and filter products
- View product details
- Add to cart
- Update/remove cart items
- Checkout system
- Place orders
- Simulated payment (Cash on Delivery, Card, PayPal)
- View order history
- Profile update

---

## 3. Database Design

### 3.1 Database: `ecom`

### 3.2 Tables

#### users
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| name | VARCHAR(255) | User name |
| email | VARCHAR(255) | Unique email |
| password | VARCHAR(255) | Hashed password |
| role | ENUM | buyer/seller/admin |
| is_blocked | BOOLEAN | Account status |
| phone | VARCHAR(20) | Contact number |
| address | TEXT | Full address |
| avatar | VARCHAR(255) | Profile image |
| created_at | TIMESTAMP | Creation date |
| updated_at | TIMESTAMP | Last update |

#### categories
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| name | VARCHAR(255) | Category name |
| slug | VARCHAR(255) | URL slug (unique) |
| description | TEXT | Category description |
| status | BOOLEAN | Active/inactive |
| created_at | TIMESTAMP | Creation date |
| updated_at | TIMESTAMP | Last update |

#### products
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| seller_id | BIGINT | FK to users |
| category_id | BIGINT | FK to categories |
| name | VARCHAR(255) | Product name |
| slug | VARCHAR(255) | URL slug (unique) |
| description | TEXT | Product description |
| price | DECIMAL(10,2) | Product price |
| quantity | INT | Stock quantity |
| image | VARCHAR(255) | Image path |
| status | ENUM | pending/approved/rejected |
| created_at | TIMESTAMP | Creation date |
| updated_at | TIMESTAMP | Last update |

#### carts
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| buyer_id | BIGINT | FK to users |
| product_id | BIGINT | FK to products |
| quantity | INT | Item quantity |
| created_at | TIMESTAMP | Creation date |
| updated_at | TIMESTAMP | Last update |

#### orders
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| buyer_id | BIGINT | FK to users |
| total_amount | DECIMAL(10,2) | Order total |
| status | ENUM | pending/processing/shipped/delivered/cancelled |
| payment_method | VARCHAR(50) | COD/Card/PayPal |
| payment_status | ENUM | pending/paid/failed |
| shipping_address | TEXT | Delivery address |
| created_at | TIMESTAMP | Creation date |
| updated_at | TIMESTAMP | Last update |

#### order_items
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| order_id | BIGINT | FK to orders |
| product_id | BIGINT | FK to products |
| seller_id | BIGINT | FK to users |
| quantity | INT | Item quantity |
| price | DECIMAL(10,2) | Unit price |
| subtotal | DECIMAL(10,2) | Line total |
| created_at | TIMESTAMP | Creation date |
| updated_at | TIMESTAMP | Last update |

#### payments
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| order_id | BIGINT | FK to orders |
| amount | DECIMAL(10,2) | Payment amount |
| method | VARCHAR(50) | Payment method |
| status | ENUM | pending/completed/failed |
| transaction_id | VARCHAR(100) | Transaction ID |
| paid_at | TIMESTAMP | Payment date |
| created_at | TIMESTAMP | Creation date |
| updated_at | TIMESTAMP | Last update |

### 3.3 Relationships
- One Seller → Many Products
- One Category → Many Products
- One Buyer → Many Orders
- One Order → Many Order Items
- One Order → One Payment

---

## 4. Routes

### 4.1 Public Routes
| Method | URL | Controller | Description |
|--------|-----|------------|-------------|
| GET | / | HomeController@index | Home page |
| GET | /products | HomeController@products | Product listing |
| GET | /products/{slug} | HomeController@productDetail | Product details |

### 4.2 Authentication Routes
| Method | URL | Controller | Description |
|--------|-----|------------|-------------|
| GET | /login | AuthController@showLoginForm | Login form |
| POST | /login | AuthController@login | Login action |
| GET | /register/buyer | AuthController@showRegisterBuyerForm | Buyer registration |
| POST | /register/buyer | AuthController@registerBuyer | Buyer register |
| GET | /register/seller | AuthController@showRegisterSellerForm | Seller registration |
| POST | /register/seller | AuthController@registerSeller | Seller register |
| POST | /logout | AuthController@logout | Logout |

### 4.3 Cart & Checkout (Authenticated)
| Method | URL | Controller | Description |
|--------|-----|------------|-------------|
| GET | /cart | CartController@index | View cart |
| POST | /cart/add/{productId} | CartController@add | Add to cart |
| PUT | /cart/update/{id} | CartController@update | Update quantity |
| DELETE | /cart/remove/{id} | CartController@remove | Remove item |
| DELETE | /cart/clear | CartController@clear | Clear cart |
| GET | /checkout | OrderController@checkout | Checkout page |
| POST | /place-order | OrderController@placeOrder | Place order |
| POST | /orders/{id}/pay | OrderController@payOrder | Pay for order |

### 4.4 Buyer Routes
| Method | URL | Controller | Description |
|--------|-----|------------|-------------|
| GET | /buyer/dashboard | BuyerController@dashboard | Buyer dashboard |
| GET | /buyer/orders | BuyerController@orders | Order history |
| GET | /buyer/profile | BuyerController@showProfile | Profile form |
| PUT | /buyer/profile | BuyerController@updateProfile | Update profile |

### 4.5 Seller Routes
| Method | URL | Controller | Description |
|--------|-----|------------|-------------|
| GET | /seller/dashboard | SellerController@dashboard | Seller dashboard |
| GET | /seller/products | SellerController@products | Product list |
| GET | /seller/products/create | SellerController@showCreateProduct | Add product |
| POST | /seller/products | SellerController@storeProduct | Save product |
| GET | /seller/products/{id}/edit | SellerController@showEditProduct | Edit product |
| PUT | /seller/products/{id} | SellerController@updateProduct | Update product |
| DELETE | /seller/products/{id} | SellerController@deleteProduct | Delete product |
| GET | /seller/orders | SellerController@orders | View orders |
| PUT | /seller/orders/{id}/ship | SellerController@shipOrder | Ship/deliver order |
| GET | /seller/earnings | SellerController@earnings | View earnings |
| GET | /seller/profile | SellerController@showProfile | Profile form |
| PUT | /seller/profile | SellerController@updateProfile | Update profile |

### 4.6 Admin Routes
| Method | URL | Controller | Description |
|--------|-----|------------|-------------|
| GET | /admin/dashboard | AdminController@dashboard | Admin dashboard |
| GET | /admin/users | AdminController@users | Manage users |
| PUT | /admin/users/{id}/block | AdminController@blockUser | Block user |
| PUT | /admin/users/{id}/unblock | AdminController@unblockUser | Unblock user |
| DELETE | /admin/users/{id} | AdminController@deleteUser | Delete user |
| GET | /admin/products | AdminController@products | Manage products |
| PUT | /admin/products/{id}/approve | AdminController@approveProduct | Approve product |
| PUT | /admin/products/{id}/reject | AdminController@rejectProduct | Reject product |
| DELETE | /admin/products/{id} | AdminController@deleteProduct | Delete product |
| GET | /admin/orders | AdminController@orders | View all orders |

---

## 5. Controllers

### 5.1 AuthController
Handles all authentication: login, logout, buyer registration, seller registration

### 5.2 HomeController
Public pages: home, product listing, product details, search, filter

### 5.3 BuyerController
- dashboard() - Buyer dashboard with order summary
- orders() - Order history
- showProfile() - Profile form
- updateProfile() - Update profile
- updatePassword() - Change password

### 5.4 SellerController
- dashboard() - Stats: products, sales, earnings
- products() - Product management list
- showCreateProduct() - Add product form
- storeProduct() - Save new product
- showEditProduct() - Edit product form
- updateProduct() - Update product
- deleteProduct() - Delete product
- orders() - View orders for their products
- shipOrder() - Mark order as delivered
- earnings() - Earnings view
- showProfile() - Profile form
- updateProfile() - Update profile
- updatePassword() - Change password

### 5.5 AdminController
- dashboard() - System overview
- users() - View all buyers/sellers
- blockUser() - Block user
- unblockUser() - Unblock user
- deleteUser() - Delete user
- products() - All products list
- approveProduct() - Approve product
- rejectProduct() - Reject product
- deleteProduct() - Delete product
- orders() - All orders view

### 5.6 CartController
- index() - View cart
- add() - Add product to cart
- update() - Update quantity
- remove() - Remove item
- clear() - Clear cart

### 5.7 OrderController
- checkout() - Checkout form
- placeOrder() - Create order
- myOrders() - Buyer orders
- payOrder() - Simulate payment

---

## 6. Middleware

### RoleMiddleware
Location: `app/Http/Middleware/RoleMiddleware.php`

Protects routes based on user role:
- `role:buyer` - Only buyers can access
- `role:seller` - Only sellers can access
- `role:admin` - Only admin can access

Also handles:
- Authentication check
- Blocked user check (logs out blocked users)

---

## 7. Views Structure

```
resources/views/
├── layouts/
│   └── app.blade.php          # Main layout with navigation
├── home.blade.php              # Home page
├── auth/
│   ├── login.blade.php        # Login form
│   ├── register-buyer.blade.php
│   └── register-seller.blade.php
├── products/
│   ├── index.blade.php        # Product listing with filters
│   └── show.blade.php        # Product details
├── cart/
│   ├── index.blade.php        # Shopping cart
│   └── checkout.blade.php     # Checkout form
├── buyer/
│   ├── dashboard.blade.php    # Buyer dashboard
│   ├── orders.blade.php       # Order history
│   └── profile.blade.php      # Profile settings
├── seller/
│   ├── dashboard.blade.php    # Seller dashboard
│   ├── orders.blade.php       # Seller orders (with ship button)
│   ├── earnings.blade.php     # Earnings view
│   ├── profile.blade.php      # Profile settings
│   └── products/
│       ├── index.blade.php    # Product list
│       ├── create.blade.php   # Add product
│       └── edit.blade.php     # Edit product
└── admin/
    ├── dashboard.blade.php    # Admin dashboard
    ├── users.blade.php        # User management
    ├── products.blade.php     # Product management
    └── orders.blade.php       # All orders
```

---

## 8. Seeders

### DatabaseSeeder
Creates:
1. **Admin User**
   - Name: Admin
   - Email: admin@ecom.com
   - Password: admin123 (hashed)
   - Role: admin

2. **Categories** (8 default)
   - Electronics
   - Clothing
   - Books
   - Home & Garden
   - Sports
   - Beauty
   - Toys
   - Food

---

## 9. Installation Steps

### Step 1: Prerequisites
- Install XAMPP (Apache + MySQL)
- Install PHP 8.2+
- Install Composer

### Step 2: Setup Project
```bash
# Navigate to htdocs
cd C:\xampp\htdocs

# Create Laravel project (or use existing)
composer create-project laravel/laravel ecom

# Or use existing project in C:\xampp\htdocs\ecom
```

### Step 3: Configure .env
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecom
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Create Database
- Open phpMyAdmin: http://localhost/phpmyadmin
- Create new database: `ecom`
- Select collation: `utf8mb4_unicode_ci`

### Step 5: Run Migrations
```bash
php artisan migrate
```

### Step 6: Run Seeders
```bash
php artisan db:seed
```

Or combined:
```bash
php artisan migrate --seed
```

### Step 7: Create Storage Link
```bash
php artisan storage:link
```

### Step 8: Start Server
```bash
# Method 1: PHP built-in server
php -S 127.0.0.1:8000 -t public

# Method 2: Laravel artisan serve
php artisan serve
```

### Step 9: Access Application
- URL: http://127.0.0.1:8000
- Admin: http://127.0.0.1:8000/login

---

## 10. Default Categories

When running seeders, these categories are created:

1. Electronics
2. Clothing
3. Books
4. Home & Garden
5. Sports
6. Beauty
7. Toys
8. Food

---

## 11. Payment Methods (Simulated)

- **Cash on Delivery (COD)** - Auto-marks as paid
- **Credit/Debit Card** - Simulated
- **PayPal** - Simulated

All payments are simulated - no real money is processed.

---

## 12. Workflow Examples

### Buyer Purchase Flow
1. Register as Buyer
2. Browse products
3. Add to cart
4. Go to checkout
5. Enter shipping address
6. Select payment method
7. Place order
8. View order in history
9. (Optional) Pay for pending orders

### Seller Product Flow
1. Register as Seller
2. Go to dashboard
3. Add product with details
4. Product status: "pending"
5. Admin approves product
6. Product status: "approved"
7. Product visible to buyers

### Order Delivery Flow
1. Buyer places order
2. Seller sees order in their panel
3. Seller ships/delivers order
4. Order status: "delivered"
5. Buyer sees "Delivered" status

---

## 13. Troubleshooting

### Common Issues

**1. "Class not found" error**
```bash
composer dump-autoload
```

**2. Database connection error**
- Check MySQL is running in XAMPP
- Verify .env database credentials

**3. Storage link error**
```bash
php artisan storage:link
```

**4. Clear cache**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## 14. Project Files Created

### Controllers (7)
- app/Http/Controllers/AuthController.php
- app/Http/Controllers/HomeController.php
- app/Http/Controllers/BuyerController.php
- app/Http/Controllers/SellerController.php
- app/Http/Controllers/AdminController.php
- app/Http/Controllers/CartController.php
- app/Http/Controllers/OrderController.php

### Models (7)
- app/Models/User.php
- app/Models/Category.php
- app/Models/Product.php
- app/Models/Cart.php
- app/Models/Order.php
- app/Models/OrderItem.php
- app/Models/Payment.php

### Migrations (8)
- database/migrations/0001_01_01_000000_create_users_table.php
- database/migrations/2024_01_01_000002_create_categories_table.php
- database/migrations/2024_01_01_000003_create_products_table.php
- database/migrations/2024_01_01_000004_create_carts_table.php
- database/migrations/2024_01_01_000005_create_orders_table.php
- database/migrations/2024_01_01_000006_create_order_items_table.php
- database/migrations/2024_01_01_000007_create_payments_table.php

### Middleware (1)
- app/Http/Middleware/RoleMiddleware.php

### Views (20+)
- All blade templates in resources/views/

---

## 15. License

MIT License

---

**End of Documentation**
