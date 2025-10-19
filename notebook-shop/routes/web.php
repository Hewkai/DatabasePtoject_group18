<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\DashboardController; // << เพิ่ม import
use App\Models\Product;

/**
 * หน้าแรก (สาธารณะ)
 */
Route::get('/', function () {
    return view('welcome');
})->name('home');

/**
 * หน้าสินค้าแบบ public (กดจากการ์ด)
 */
Route::get('/product/{product}', function (Product $product) {
    $product->load(['brand','categories','primaryImage']);
    return view('public.product', compact('product'));
})->name('product.show');

/**
 * Dashboard ผู้ใช้ทั่วไป (ต้องล็อกอิน + verified)
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

    Route::get('/checkout', [CartController::class, 'checkoutShow'])->name('checkout.show');
    Route::post('/checkout', [CartController::class, 'checkoutProcess'])->name('checkout.process');

    Route::get('/orders', [CartController::class, 'ordersIndex'])->name('orders.index');
});

/**
 * พื้นที่ผู้ดูแลระบบ (Admin)
 * ต้องผ่าน: auth + verified + admin (alias ถูกประกาศแล้วใน bootstrap/app.php)
 */
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth','verified','admin'])
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // เพิ่มเส้นทางอื่น ๆ ของแอดมินได้ที่นี่ เช่น:
        // Route::resource('/products', AdminProductController::class);
        // Route::resource('/categories', AdminCategoryController::class);
        // Route::resource('/brands', AdminBrandController::class);
        // Route::resource('/users', AdminUserController::class);
    });

/** เส้นทาง auth ของ Breeze */
require __DIR__.'/auth.php';
