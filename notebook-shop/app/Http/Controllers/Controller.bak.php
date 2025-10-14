<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductIndexRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(ProductIndexRequest $request)
    {
        $q = Product::query()
            ->with(['brand','category']); // ปรับตามความสัมพันธ์ที่มีจริง

        // ----- Filters -----
        if ($request->filled('brand_id')) {
            $q->where('brand_id', $request->integer('brand_id'));
        }

        if ($request->filled('category_id')) {
            $q->where('category_id', $request->integer('category_id')); // มีคอลัมน์นี้จริงค่อยใช้
        }

        if ($request->filled('cpu_brand')) {
            $q->where('cpu_brand', $request->input('cpu_brand'));
        }

        if ($request->filled('price_min')) {
            $q->where('price', '>=', $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $q->where('price', '<=', $request->input('price_max'));
        }

        // ----- Search (q) -----
        if ($request->filled('q')) {
            $term = trim($request->input('q'));
            $q->where(function ($sub) use ($term) {
                $like = '%'.$term.'%';
                $sub->where('model', 'LIKE', $like)
                    ->orWhere('gpu', 'LIKE', $like)
                    ->orWhere('cpu_model', 'LIKE', $like);
            });
        }

        // ----- Sorting -----
        // รูปแบบ: sort=price,-created_at (คั่นด้วย comma, ขีดนำหน้า = DESC)
        $allowedSorts = [
            'price'      => 'price',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'ram_gb'     => 'ram_gb',
            'storage_gb' => 'storage_gb',
        ];

        if ($request->filled('sort')) {
            $sorts = explode(',', $request->input('sort'));
            foreach ($sorts as $sortItem) {
                $direction = 'asc';
                $key = $sortItem;
                if (str_starts_with($sortItem, '-')) {
                    $direction = 'desc';
                    $key = ltrim($sortItem, '-');
                }
                if (isset($allowedSorts[$key])) {
                    $q->orderBy($allowedSorts[$key], $direction);
                }
            }
        } else {
            // ค่า default (เช่น สินค้าที่สร้างล่าสุดมาก่อน)
            $q->orderBy('created_at', 'desc');
        }

        // ----- Pagination -----
        $perPage = $request->integer('per_page', 15);
        $products = $q->paginate($perPage)->appends($request->query());

        return response()->json($products);
    }
}
