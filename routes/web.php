<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/products/{slug}', [HomeController::class, 'productDetail'])->name('product.detail');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register/buyer', [AuthController::class, 'showRegisterBuyerForm'])->name('register.buyer');
Route::post('/register/buyer', [AuthController::class, 'registerBuyer']);
Route::get('/register/seller', [AuthController::class, 'showRegisterSellerForm'])->name('register.seller');
Route::post('/register/seller', [AuthController::class, 'registerSeller']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('place.order');
    Route::post('/orders/{id}/pay', [OrderController::class, 'payOrder'])->name('order.pay');
});

Route::middleware(['auth', 'role:buyer'])->prefix('buyer')->group(function () {
    Route::get('/dashboard', [BuyerController::class, 'dashboard'])->name('buyer.dashboard');
    Route::get('/orders', [BuyerController::class, 'orders'])->name('buyer.orders');
    Route::get('/profile', [BuyerController::class, 'showProfile'])->name('buyer.profile');
    Route::put('/profile', [BuyerController::class, 'updateProfile']);
    Route::put('/password', [BuyerController::class, 'updatePassword'])->name('buyer.password');
});

Route::middleware(['auth', 'role:seller'])->prefix('seller')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
    Route::get('/products', [SellerController::class, 'products'])->name('seller.products');
    Route::get('/products/create', [SellerController::class, 'showCreateProduct'])->name('seller.products.create');
    Route::post('/products', [SellerController::class, 'storeProduct'])->name('seller.products.store');
    Route::get('/products/{id}/edit', [SellerController::class, 'showEditProduct'])->name('seller.products.edit');
    Route::put('/products/{id}', [SellerController::class, 'updateProduct'])->name('seller.products.update');
    Route::delete('/products/{id}', [SellerController::class, 'deleteProduct'])->name('seller.products.delete');
    Route::get('/orders', [SellerController::class, 'orders'])->name('seller.orders');
    Route::put('/orders/{id}/ship', [SellerController::class, 'shipOrder'])->name('seller.orders.ship');
    Route::get('/earnings', [SellerController::class, 'earnings'])->name('seller.earnings');
    Route::get('/profile', [SellerController::class, 'showProfile'])->name('seller.profile');
    Route::put('/profile', [SellerController::class, 'updateProfile']);
    Route::put('/password', [SellerController::class, 'updatePassword'])->name('seller.password');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::put('/users/{id}/block', [AdminController::class, 'blockUser'])->name('admin.users.block');
    Route::put('/users/{id}/unblock', [AdminController::class, 'unblockUser'])->name('admin.users.unblock');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::put('/products/{id}/approve', [AdminController::class, 'approveProduct'])->name('admin.products.approve');
    Route::put('/products/{id}/reject', [AdminController::class, 'rejectProduct'])->name('admin.products.reject');
    Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
});
