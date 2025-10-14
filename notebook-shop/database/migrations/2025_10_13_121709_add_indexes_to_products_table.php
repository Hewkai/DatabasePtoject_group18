<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $hasBrand     = Schema::hasColumn('products', 'brand_id');
        $hasCpuBrand  = Schema::hasColumn('products', 'cpu_brand');
        $hasPrice     = Schema::hasColumn('products', 'price');
        $hasCreatedAt = Schema::hasColumn('products', 'created_at');

        Schema::table('products', function (Blueprint $table) use ($hasBrand, $hasCpuBrand, $hasPrice, $hasCreatedAt) {
            if ($hasBrand)     $table->index('brand_id',   'products_brand_id_idx');
            if ($hasCpuBrand)  $table->index('cpu_brand',  'products_cpu_brand_idx');
            if ($hasPrice)     $table->index('price',      'products_price_idx');
            if ($hasCreatedAt) $table->index('created_at', 'products_created_at_idx');
        });
    }


    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // ลบ index เฉพาะคอลัมน์ที่มีอยู่ และถ้า index เคยถูกสร้าง
            if (Schema::hasColumn('products', 'brand_id')) {
                try { $table->dropIndex('products_brand_id_idx'); } catch (\Throwable $e) {}
            }
            if (Schema::hasColumn('products', 'cpu_brand')) {
                try { $table->dropIndex('products_cpu_brand_idx'); } catch (\Throwable $e) {}
            }
            if (Schema::hasColumn('products', 'price')) {
                try { $table->dropIndex('products_price_idx'); } catch (\Throwable $e) {}
            }
            if (Schema::hasColumn('products', 'created_at')) {
                try { $table->dropIndex('products_created_at_idx'); } catch (\Throwable $e) {}
            }
        });
    }
};
