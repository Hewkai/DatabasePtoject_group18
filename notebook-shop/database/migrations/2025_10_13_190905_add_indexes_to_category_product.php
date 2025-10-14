<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('category_product', function (Blueprint $table) {
            // ป้องกันซ้ำหนึ่งคู่
            if (!Schema::hasColumn('category_product','product_id')) return;
            $table->unique(['product_id','category_id'], 'catprod_product_category_uk');
            // index แยก เพื่อช่วยเคส query ที่ฟิลด์เดียว
            $table->index('product_id',  'catprod_product_idx');
            $table->index('category_id', 'catprod_category_idx');
        });
    }
    public function down(): void {
        Schema::table('category_product', function (Blueprint $table) {
            try { $table->dropUnique('catprod_product_category_uk'); } catch (\Throwable $e) {}
            try { $table->dropIndex('catprod_product_idx'); } catch (\Throwable $e) {}
            try { $table->dropIndex('catprod_category_idx'); } catch (\Throwable $e) {}
        });
    }
};
