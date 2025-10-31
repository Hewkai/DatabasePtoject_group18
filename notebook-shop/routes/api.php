<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductImageController;
use App\Models\Category;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Public API (อ่านอย่างเดียว)
|--------------------------------------------------------------------------
|
| ส่วนนี้ไม่ต้องใช้ token: อ่านแบรนด์/หมวดหมู่/สินค้า และดูรูปของสินค้า
| หมายเหตุ: ต้องวาง /products/{product}/images "เหนือ" /products/{product}
| เพื่อไม่ให้ชนพารามิเตอร์ของ apiResource (show).
|
*/

// ลิสต์แบรนด์/หมวดหมู่
Route::get('brands', [BrandController::class, 'index'])->name('api.brands.index');
Route::get('categories', fn () => Category::orderBy('name')->get())->name('api.categories.index');

// ลิสต์รูปของสินค้าหนึ่งตัว (อ่านอย่างเดียว)
Route::get('products/{product}/images', fn (Product $product) =>
    $product->images()->orderBy('sort_order')->get()
)->name('api.products.images.index');

// products: อ่านเฉพาะ index/show
Route::apiResource('products', ProductController::class)
    ->only(['index', 'show'])
    ->names([
        'index' => 'api.products.index',
        'show'  => 'api.products.show',
    ]);


/*
|--------------------------------------------------------------------------
| Protected API (ต้อง auth:sanctum)
|--------------------------------------------------------------------------
|
| ส่วนนี้ต้องส่ง Bearer Token (Sanctum) ถึงจะเรียกได้:
| - สร้าง/แก้ไข/ลบสินค้า
| - อัปโหลดรูปสินค้าแบบ multipart/form-data
|
*/
Route::middleware('auth:sanctum')->group(function () {

    // products: เขียน (create/update/delete)
    Route::apiResource('products', ProductController::class)
        ->only(['store', 'update', 'destroy'])
        ->names([
            'store'   => 'api.products.store',
            'update'  => 'api.products.update',
            'destroy' => 'api.products.destroy',
        ]);

    // อัปโหลดรูปสินค้า (multipart/form-data)
    Route::post('products/{product}/images', [ProductImageController::class, 'store'])
        ->name('api.products.images.store');
});
