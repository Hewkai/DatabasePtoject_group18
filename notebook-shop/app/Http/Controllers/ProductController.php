<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductIndexRequest;
use Illuminate\Support\Facades\Cache;


class ProductController extends Controller
{
    // GET /api/products
    public function index(ProductIndexRequest $request)
    {
        // key อ้างอิงจาก query string ทั้งหมด เพื่อให้ cache แยกตาม filter/sort/page
        $cacheKey = 'products:' . md5($request->fullUrl());
        $ttl = now()->addSeconds(60); // อายุ cache 60 วินาที (ปรับได้)

        $payload = Cache::tags(['products'])->remember($cacheKey, $ttl, function () use ($request) {
            $q = Product::query()->with(['brand','categories','primaryImage']);

            // ----- Filters -----
            if ($request->filled('brand_id')) {
                $q->where('brand_id', $request->integer('brand_id'));
            }
            if ($request->filled('category_id')) {
                $q->whereHas('categories', function ($sub) use ($request) {
                    $sub->where('categories.id', $request->integer('category_id'));
                });
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

            // ----- Search -----
            if ($request->filled('q')) {
                $term = '%'.trim($request->input('q')).'%';
                $q->where(function ($sub) use ($term) {
                    $sub->where('model', 'like', $term)
                        ->orWhere('gpu', 'like', $term)
                        ->orWhere('cpu_model', 'like', $term);
                });
            }

            // ----- Sorting -----
            $allowed = ['price','created_at','updated_at','ram_gb','storage_gb'];
            if ($request->filled('sort')) {
                foreach (explode(',', $request->input('sort')) as $part) {
                    $dir = str_starts_with($part, '-') ? 'desc' : 'asc';
                    $col = ltrim($part, '-');
                    if (in_array($col, $allowed, true)) {
                        $q->orderBy($col, $dir);
                    }
                }
            } else {
                $q->orderBy('created_at', 'desc');
            }

            // ----- Pagination -----
            $perPage = $request->integer('per_page', 20);
            return $q->paginate($perPage)->appends($request->query());
        });

        // ตอบพร้อม hint อายุ cache (เผื่อ debug)
        return response()->json($payload)->header('X-Cache-TTL', 60);
    }


    // POST /api/products
    public function store(Request $request)
{
    $data = $request->validate([
        'brand_id'    => 'required|exists:brands,id', // << เปลี่ยนเป็น brand_id
        'model'       => 'required|string',
        'cpu_brand'   => 'required|in:Intel,AMD',
        'cpu_model'   => 'nullable|string',
        'ram_gb'      => 'nullable|integer|min:1',
        'storage_gb'  => 'nullable|integer|min:1',
        'gpu'         => 'nullable|string',
        'price'       => 'nullable|numeric|min:0',
    ]);

        $product = Product::create($data);
        return response()->json($product, 201)
            ->header('Location', route('products.show', $product));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'brand_id'    => 'sometimes|exists:brands,id', // << เปลี่ยนเป็น brand_id
            'model'       => 'sometimes|string',
            'cpu_brand'   => 'sometimes|in:Intel,AMD',
            'cpu_model'   => 'sometimes|nullable|string',
            'ram_gb'      => 'sometimes|integer|min:1',
            'storage_gb'  => 'sometimes|integer|min:1',
            'gpu'         => 'sometimes|nullable|string',
            'price'       => 'sometimes|numeric|min:0',
        ]);

        $product->update($data);
        return response()->json($product);
    }

    public function show(Product $product)
    {
        // ดึงความสัมพันธ์ที่ต้องการแสดงไปพร้อมกัน
        $product->load(['brand', 'categories', 'primaryImage']);

        return response()->json($product);
    }

    // DELETE /api/products/{product}
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }
}
