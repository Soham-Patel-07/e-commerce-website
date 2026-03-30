# E-Commerce Multi-Vendor Platform

A full-stack multi-vendor e-commerce web application built with PHP Laravel and MySQL. This platform allows multiple sellers to list products while buyers can purchase them, with admin oversight.

## Features

### Three User Roles
- **Buyer (Customer)** - Browse, cart, purchase products
- **Seller (Vendor)** - List products, manage inventory, track orders
- **Admin** - System management, user oversight, product approval

### Key Features
- Separate registration for Buyer and Seller
- Role-based authentication
- Product search and filtering
- Shopping cart system
- Checkout with multiple payment methods (simulated)
- Order tracking
- Seller dashboard with sales analytics
- Admin dashboard with system overview

## Tech Stack

- **Framework:** Laravel 12.x
- **Database:** MySQL (phpMyAdmin/XAMPP)
- **Frontend:** Bootstrap 5, Font Awesome
- **Templating:** Blade Templates

## Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- XAMPP (MySQL)
- Node.js (optional)

### Installation

1. **Clone/Download the project to htdocs:**
```
C:\xampp\htdocs\ecom
```

2. **Install dependencies:**
```bash
cd C:\xampp\htdocs\ecom
composer install
```

3. **Configure .env file:**
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecom
DB_USERNAME=root
DB_PASSWORD=
```

4. **Create database:**
- Open phpMyAdmin (http://localhost/phpmyadmin)
- Create database named: `ecom`

5. **Run migrations and seeders:**
```bash
php artisan migrate --seed
```

6. **Create storage link:**
```bash
php artisan storage:link
```

7. **Start the server:**
```bash
php -S 127.0.0.1:8000 -t public
```

8. **Access the application:**
- URL: http://127.0.0.1:8000

## Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@ecom.com | admin123 |
| Buyer | Register new account | - |
| Seller | Register new account | - |

## Project Structure

```
ecom/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # All controllers
│   │   └── Middleware/      # Role middleware
│   └── Models/              # Eloquent models
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── resources/
│   └── views/              # Blade templates
├── routes/
│   └── web.php             # Web routes
├── .env                    # Environment config
└── artisan                 # Laravel CLI
```

## License

MIT License
