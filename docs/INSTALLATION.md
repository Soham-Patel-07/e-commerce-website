# Installation Guide

Complete step-by-step instructions to install and run the e-commerce project.

---

## Option 1: Using Existing Project (Already Setup)

The project is already at: `C:\xampp\htdocs\ecom`

### To Run the Project:

1. **Start XAMPP**
   - Open XAMPP Control Panel
   - Start Apache
   - Start MySQL

2. **Start Server**
   ```bash
   cd C:\xampp\htdocs\ecom
   php -S 127.0.0.1:8000 -t public
   ```

3. **Open Browser**
   - Go to: http://127.0.0.1:8000

---

## Option 2: Fresh Installation

### Step 1: Install Prerequisites

| Software | Download Link |
|----------|---------------|
| XAMPP | https://www.apachefriends.org/ |
| PHP 8.2+ | Included in XAMPP |
| Composer | https://getcomposer.org/ |

### Step 2: Create Project

```bash
cd C:\xampp\htdocs
composer create-project laravel/laravel ecom
```

### Step 3: Configure Database

1. Open XAMPP Control Panel
2. Start MySQL
3. Go to http://localhost/phpmyadmin
4. Create database: `ecom`

### Step 4: Update .env

Edit `C:\xampp\htdocs\ecom\.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecom
DB_USERNAME=root
DB_PASSWORD=
```

### Step 5: Run Migrations

```bash
cd C:\xampp\htdocs\ecom
php artisan migrate --seed
```

### Step 6: Create Storage Link

```bash
php artisan storage:link
```

### Step 7: Start Server

```bash
php -S 127.0.0.1:8000 -t public
```

### Step 8: Access Application

Open browser: http://127.0.0.1:8000

---

## Login Credentials

### Admin (Pre-created)
| Field | Value |
|-------|-------|
| Email | admin@ecom.com |
| Password | admin123 |

### For Buyer/Seller
1. Go to Register page
2. Create new account
3. Select role (Buyer or Seller)

---

## Project Structure

```
C:\xampp\htdocs\ecom\
├── app\
│   ├── Http\
│   │   ├── Controllers\    (7 controllers)
│   │   └── Middleware\     (RoleMiddleware)
│   └── Models\             (7 models)
├── database\
│   ├── migrations\         (8 migrations)
│   └── seeders\           (DatabaseSeeder)
├── resources\
│   └── views\             (20+ blade files)
├── routes\
│   └── web.php           (All routes)
├── .env                  (Database config)
└── composer.json         (Dependencies)
```

---

## Common Commands

```bash
# Start server
php artisan serve

# Or with custom port
php artisan serve --port=8080

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Recreate database
php artisan migrate:fresh --seed

# Create new controller
php artisan make:controller ControllerName

# Create new model
php artisan make:model ModelName
```

---

## Troubleshooting

### MySQL Not Starting
- Check if another MySQL service is running (e.g., MySQL Workbench)
- Port 3306 might be in use

### Database Connection Error
- Verify .env credentials
- Ensure MySQL is running
- Check database exists in phpMyAdmin

### Class Not Found
```bash
composer dump-autoload
```

### Storage Link Error
```bash
php artisan storage:link
```

---

## Features at a Glance

### Buyer Features
- [x] Register/Login
- [x] Browse Products
- [x] Search & Filter
- [x] Add to Cart
- [x] Checkout
- [x] Payment (Simulated)
- [x] Order History
- [x] Profile Management

### Seller Features
- [x] Register/Login
- [x] Add Products
- [x] Edit/Delete Products
- [x] Image Upload
- [x] Stock Management
- [x] View Orders
- [x] Ship/Deliver Orders
- [x] Track Earnings
- [x] Profile Management

### Admin Features
- [x] Login (Pre-created)
- [x] View All Users
- [x] Block/Unblock Users
- [x] Delete Users
- [x] Approve Products
- [x] Reject Products
- [x] View All Orders
- [x] Dashboard Stats

---

## Default Categories

When seeded, these categories are created:
1. Electronics
2. Clothing
3. Books
4. Home & Garden
5. Sports
6. Beauty
7. Toys
8. Food

---

## Payment Methods (Simulated)

- Cash on Delivery (COD)
- Credit/Debit Card
- PayPal

*Note: All payments are simulated - no real money is processed.*

---

## Support

For issues or questions, check:
1. Laravel Documentation: https://laravel.com/docs
2. Stack Overflow
3. Project documentation in /docs folder

---

**Installation Complete!**
