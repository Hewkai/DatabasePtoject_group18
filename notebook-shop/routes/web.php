<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Models\Product;

/**
 * หน้าแรก (สาธารณะ)
 */
Route::get('/', function () {
    return view('welcome');
})->name('home');

/**
 * หน้าสินค้าทั้งหมด (สาธารณะ)
 */
Route::get('/products', function () {
    return view('products.index');
})->name('products.index');

/**
 * หน้าสินค้าแบบ public (กดจากการ์ด)
 */
Route::get('/product/{product}', function (Product $product) {
    $product->load(['brand','categories','primaryImage']);
    return view('public.product', compact('product'));
})->name('product.show');

//member
Route::get('/members', [MemberController::class, 'index'])->name('members.index');
/**
 * Dashboard (ต้องล็อกอิน + verified)
 */
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth','verified'])->name('dashboard');

/**
 * โปรไฟล์ (ต้องล็อกอิน)
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

/**
 * เส้นทางซื้อของ (ต้องล็อกอิน)
 */
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    
    Route::post('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
    Route::post('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');

    Route::get('/checkout', [CartController::class, 'checkoutShow'])->name('checkout.show');
    Route::post('/checkout', [CartController::class, 'checkoutProcess'])->name('checkout.process');

    Route::get('/orders', [CartController::class, 'ordersIndex'])->name('orders.index');
});
//  Admin Dashboard

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // The URI will be /admin/dashboard
    // The name will be admin.dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Add other admin routes here (e.g., product management)
    // Route::resource('/products', App\Http\Controllers\Admin\ProductManagementController::class);
});

/** เส้นทาง auth ของ Breeze */
require __DIR__.'/auth.php';