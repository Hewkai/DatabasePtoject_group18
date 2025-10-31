<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
<<<<<<< Updated upstream
use App\Http\Controllers\Admin\DashboardController; // << เพิ่ม import
=======
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\Admin\DashboardController;
>>>>>>> Stashed changes
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Public pages
|--------------------------------------------------------------------------
*/

// หน้าแรก (แสดงสินค้าแบบ public ใน welcome.blade.php)
Route::get('/', function () {
    return view('welcome');
})->name('home');

<<<<<<< Updated upstream
/**
 * หน้าสินค้าแบบ public (กดจากการ์ด)
 */
=======
// หน้ารวมสินค้าทั้งหมด (ถ้าคุณมีหน้าแยก products/index.blade.php)
Route::get('/products', function () {
    return view('products.index');
})->name('products.index');

// หน้าแสดงรายละเอียดสินค้าแบบ public (คลิกจากการ์ดหน้าแรก)
>>>>>>> Stashed changes
Route::get('/product/{product}', function (Product $product) {
    $product->load(['brand', 'categories', 'primaryImage']);
    return view('public.product', compact('product'));
})->whereNumber('product')->name('product.show');

<<<<<<< Updated upstream
/**
 * Dashboard ผู้ใช้ทั่วไป (ต้องล็อกอิน + verified)
 */
=======

/*
|--------------------------------------------------------------------------
| Auth + verified only pages
|--------------------------------------------------------------------------
*/

// Dashboard (ตัวอย่างหน้า dashboard เริ่มต้นของ Breeze/Jetstream)
>>>>>>> Stashed changes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// โปรไฟล์ผู้ใช้ (แก้ไขข้อมูล, เปลี่ยนรหัสผ่าน, ลบบัญชี)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// เส้นทางซื้อของ (ต้องล็อกอิน)
Route::middleware('auth')->group(function () {
    // ตะกร้า
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
<<<<<<< Updated upstream
    Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
=======
    Route::post('/cart/remove/{product}', [CartController::class, 'remove'])
        ->whereNumber('product')
        ->name('cart.remove');

    Route::post('/cart/increase/{id}', [CartController::class, 'increase'])
        ->whereNumber('id')
        ->name('cart.increase');
>>>>>>> Stashed changes

    Route::post('/cart/decrease/{id}', [CartController::class, 'decrease'])
        ->whereNumber('id')
        ->name('cart.decrease');

    // Checkout
    Route::get('/checkout', [CartController::class, 'checkoutShow'])->name('checkout.show');
    Route::post('/checkout', [CartController::class, 'checkoutProcess'])->name('checkout.process');

<<<<<<< Updated upstream
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
=======
    // คำสั่งซื้อของฉัน
    Route::get('/orders', [CartController::class, 'ordersIndex'])->name('orders.index');

    // ตัวอย่างหน้า member (ถ้ามี)
    Route::get('/members', [MemberController::class, 'index'])->name('members.index');
});


/*
|--------------------------------------------------------------------------
| Admin area (auth + verified)
| หมายเหตุ: ตอนนี้ยังไม่ได้ผูก middleware ตรวจ is_admin โดยตรง
|           คุณซ่อนปุ่มใน Blade แล้ว และควบคุมสิทธิ์ใน Controller ได้
|           หากสร้าง middleware is_admin ภายหลัง ค่อยเพิ่มเข้า group นี้
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // GET /admin/dashboard  -> name: admin.dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // ตัวอย่าง (เพิ่มตามต้องการ)
        // Route::resource('/products', App\Http\Controllers\Admin\ProductManagementController::class);
    });


/*
|--------------------------------------------------------------------------
| Auth scaffold (Breeze/Jetstream)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Optional: fallback -> กลับหน้าแรก
|--------------------------------------------------------------------------
*/
// Route::fallback(function () {
//     return redirect()->route('home');
// });
>>>>>>> Stashed changes
