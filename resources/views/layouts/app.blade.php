<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Commerce')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-brand { font-weight: bold; }
        .card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .product-card { transition: transform 0.2s; }
        .product-card:hover { transform: translateY(-5px); }
        .sidebar { min-height: calc(100vh - 56px); }
        .dropdown-menu { border: none; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-shopping-bag"></i> E-Shop
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products') }}">Products</a>
                    </li>
                    @auth
                        @if(Auth::user()->role === 'buyer')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart') }}">
                                <i class="fas fa-shopping-cart"></i> Cart
                                @php
                                    $cartCount = \App\Models\Cart::where('buyer_id', Auth::id())->sum('quantity');
                                @endphp
                                @if($cartCount > 0)
                                    <span class="badge bg-danger">{{ $cartCount }}</span>
                                @endif
                            </a>
                        </li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Register</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('register.buyer') }}">As Buyer</a></li>
                                <li><a class="dropdown-item" href="{{ route('register.seller') }}">As Seller</a></li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(Auth::user()->role === 'buyer')
                                    <li><a class="dropdown-item" href="{{ route('buyer.dashboard') }}">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ route('buyer.profile') }}">Profile</a></li>
                                    <li><a class="dropdown-item" href="{{ route('buyer.orders') }}">My Orders</a></li>
                                @elseif(Auth::user()->role === 'seller')
                                    <li><a class="dropdown-item" href="{{ route('seller.dashboard') }}">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ route('seller.products') }}">Products</a></li>
                                    <li><a class="dropdown-item" href="{{ route('seller.orders') }}">Orders</a></li>
                                    <li><a class="dropdown-item" href="{{ route('seller.earnings') }}">Earnings</a></li>
                                    <li><a class="dropdown-item" href="{{ route('seller.profile') }}">Profile</a></li>
                                @elseif(Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.users') }}">Manage Users</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.products') }}">Manage Products</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.orders') }}">Manage Orders</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
