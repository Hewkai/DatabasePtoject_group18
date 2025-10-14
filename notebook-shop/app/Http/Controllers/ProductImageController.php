<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    /**
     * POST /api/products/{product}/images
     * Multipart: image (required), is_primary (bool), sort_order (int)
     */
    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            'image'      => 'required|file|mimes:jpg,jpeg,png,webp|max:4096',
            'is_primary' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer|min:0',
        ]);

        // อัปโหลดไฟล์ไปที่ storage/app/public/products/{id}
        $path = $request->file('image')->store("public/products/{$product->id}");
        $publicUrl = Storage::url($path); // => /storage/products/{id}/xxx.jpg

        // ถ้าเลือกเป็นรูปหลัก เคลียร์ flag เดิมก่อน
        if (!empty($data['is_primary'])) {
            ProductImage::where('product_id', $product->id)->update(['is_primary' => false]);
        }

        $img = ProductImage::create([
            'product_id' => $product->id,
            'url'        => $publicUrl,
            'is_primary' => (bool)($data['is_primary'] ?? false),
            'sort_order' => (int)($data['sort_order'] ?? 0),
        ]);

        return response()->json($img, 201);
    }
}
