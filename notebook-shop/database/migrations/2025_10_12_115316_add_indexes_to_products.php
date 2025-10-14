<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private function idxExists(string $name): bool
    {
        // เช็คใน information_schema ว่า index นี้มีแล้วหรือยัง
        $sql = 'SELECT 1 FROM information_schema.statistics
                WHERE table_schema = DATABASE()
                  AND table_name = "products"
                  AND index_name = ?
                LIMIT 1';
        return collect(DB::select($sql, [$name]))->isNotEmpty();
    }

    public function up(): void
    {
        // 1) (brand_id, cpu_brand)
        if (!$this->idxExists('products_brand_id_cpu_brand_index')) {
            Schema::table('products', function (Blueprint $t) {
                $t->index(['brand_id','cpu_brand'], 'products_brand_id_cpu_brand_index');
            });
        }

        // 2) price
        if (!$this->idxExists('products_price_index')) {
            Schema::table('products', function (Blueprint $t) {
                $t->index('price', 'products_price_index');
            });
        }

        // 3) unique (brand_id, model) กันรุ่นซ้ำ
        if (!$this->idxExists('products_brand_id_model_unique')) {
            Schema::table('products', function (Blueprint $t) {
                $t->unique(['brand_id','model'], 'products_brand_id_model_unique');
            });
        }
    }

    public function down(): void
    {
        // ใช้ SQL ตรง ๆ เพื่อ drop แบบมีเงื่อนไข
        if ($this->idxExists('products_brand_id_model_unique')) {
            DB::statement('DROP INDEX `products_brand_id_model_unique` ON `products`');
        }
        if ($this->idxExists('products_price_index')) {
            DB::statement('DROP INDEX `products_price_index` ON `products`');
        }
        if ($this->idxExists('products_brand_id_cpu_brand_index')) {
            DB::statement('DROP INDEX `products_brand_id_cpu_brand_index` ON `products`');
        }
    }
};
