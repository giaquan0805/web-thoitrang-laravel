<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AiTryonController;
use App\Http\Controllers\PasswordResetController;

// Admin routes
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

// Trang chủ
Route::get('/', [ProductController::class, 'index'])->name('home');

// Trang chi tiết sản phẩm
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// Giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

// Đặt hàng
Route::get('/checkout', [OrderController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

// Auth khách hàng
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Quên mật khẩu
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.forgot');
Route::post('/forgot-password', [PasswordResetController::class, 'sendOtp'])->name('password.sendOtp');
Route::get('/verify-otp', [PasswordResetController::class, 'showOtpForm'])->name('password.showOtpForm');
Route::post('/verify-otp', [PasswordResetController::class, 'verifyOtp'])->name('password.verifyOtp');
Route::get('/reset-password', [PasswordResetController::class, 'showResetForm'])->name('password.showResetForm');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.reset');

// Account khách hàng
Route::middleware('auth')->group(function () {
    Route::get('/account', [AuthController::class, 'profile'])->name('account.profile');
    Route::post('/account/update', [AuthController::class, 'update'])->name('account.update');
    Route::get('/account/orders', [AuthController::class, 'orders'])->name('account.orders');
});

// AI Try-on
Route::get('/ai-tryon/{productId}', [AiTryonController::class, 'index'])->name('ai.tryon');
Route::post('/ai-tryon/process', [AiTryonController::class, 'process'])->name('ai.process');

// Admin Auth (riêng biệt)
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Panel
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Products
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    // Variants
    Route::post('/products/{id}/variants', [AdminProductController::class, 'storeVariant'])->name('variants.store');
    Route::put('/variants/{id}', [AdminProductController::class, 'updateVariant'])->name('variants.update');
    Route::delete('/variants/{id}', [AdminProductController::class, 'destroyVariant'])->name('variants.destroy');

    // Product Images
    Route::delete('/product-images/{id}', [AdminProductController::class, 'destroyImage'])->name('product-images.destroy');

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Categories
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
});