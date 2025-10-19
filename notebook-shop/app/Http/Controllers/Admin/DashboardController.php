<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Facades\Schema as DBSchema;

class DashboardController extends Controller
{
    public function index()
    {
        // -------- Metrics --------
        $metrics = [
            'users'      => class_exists(User::class) ? User::count() : 0,
            'products'   => class_exists(Product::class) ? Product::count() : 0,
            'categories' => class_exists(Category::class) ? Category::count() : 0,
            'brands'     => class_exists(Brand::class) ? Brand::count() : 0,
        ];

        // -------- Resolve column names safely --------
        $productNameCol = $this->firstExistingColumn('products', ['name','title','product_name']);
        $productPriceCol = $this->firstExistingColumn('products', ['price','unit_price','sale_price','amount']);
        $categoryNameCol = $this->firstExistingColumn('categories', ['name','title','category_name','label']);

        // -------- Latest products (normalize to id, name, price, created_at) --------
        $latestProducts = collect();
        if (class_exists(Product::class)) {
            // เลือกเฉพาะคอลัมน์ที่มีจริงเพื่อลด error
            $selectCols = array_values(array_filter([
                'id',
                $productNameCol,
                $productPriceCol,
                'created_at',
            ]));

            $raw = Product::query()->latest()->take(6)->get($selectCols);

            // แม็ปให้มี key ชื่อมาตรฐานที่ view ใช้ได้เสมอ
            $latestProducts = $raw->map(function ($p) use ($productNameCol, $productPriceCol) {
                return (object) [
                    'id'         => $p->id,
                    'name'       => $productNameCol    ? ($p->{$productNameCol} ?? '-') : '-',
                    'price'      => $productPriceCol   ? ($p->{$productPriceCol} ?? 0) : 0,
                    'created_at' => $p->created_at ?? null,
                ];
            });
        }

        // -------- Products by Category (name + products_count) --------
        $byCategory = collect();
        if (class_exists(Category::class) && method_exists(Category::class, 'withCount')) {
            $selectCols = array_values(array_filter([$categoryNameCol]));
            // ดึงชื่อหมวดหมู่ + จำนวนสินค้า
            $cats = Category::withCount('products')
                ->orderByDesc('products_count')
                ->take(6)
                ->when(!empty($selectCols), fn($q) => $q->get($selectCols))
                ->when(empty($selectCols), fn() => Category::withCount('products')->orderByDesc('products_count')->take(6)->get());

            // แม็ปให้มี name + products_count เสมอ (สำหรับกราฟ)
            $byCategory = $cats->map(function ($c) use ($categoryNameCol) {
                $name = $categoryNameCol ? ($c->{$categoryNameCol} ?? 'N/A') : 'N/A';
                return (object)[
                    'name' => $name,
                    'products_count' => $c->products_count ?? 0,
                ];
            });
        }

        return view('admin.dashboard', compact('metrics','latestProducts','byCategory'));
    }

    /**
     * คืนชื่อคอลัมน์ตัวแรกที่มีอยู่จริงในตารางนั้น ๆ
     */
    private function firstExistingColumn(string $table, array $candidates): ?string
    {
        foreach ($candidates as $col) {
            if (DBSchema::hasColumn($table, $col)) {
                return $col;
            }
        }
        return null;
    }
}
