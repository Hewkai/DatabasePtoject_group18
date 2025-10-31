<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Models\Product;

/**
 * หน้าแรก (สาธารณะ)
 */
Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/products', function () {
    $products = \App\Models\Product::with(['brand','categories','primaryImage'])
        ->latest()
        ->paginate(12);

    return view('public.index', compact('products'));
})->name('products.index');


/**
 * หน้าสินค้าแบบ public (กดจากการ์ด)
 */
Route::get('/product/{product}', function (Product $product) {
    $product->load(['brand','categories','primaryImage']);
    return view('public.product', compact('product'));
})->name('product.show');

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

    Route::get('/checkout', [CartController::class, 'checkoutShow'])->name('checkout.show');
    Route::post('/checkout', [CartController::class, 'checkoutProcess'])->name('checkout.process');

    Route::get('/orders', [CartController::class, 'ordersIndex'])->name('orders.index');
    
});

/** เส้นทาง auth ของ Breeze */
require __DIR__.'/auth.php';
