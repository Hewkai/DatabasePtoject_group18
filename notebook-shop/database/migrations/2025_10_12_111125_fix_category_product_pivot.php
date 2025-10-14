<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ดรอปของเดิมที่โครงสร้างไม่ถูกต้อง
        if (Schema::hasTable('category_product')) {
            Schema::drop('category_product');
        }

        // สร้างใหม่ให้ถูกต้อง (pivot ของ products <-> categories)
        Schema::create('category_product', function (Blueprint $t) {
            $t->foreignId('product_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $t->foreignId('category_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $t->primary(['product_id','category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_product');
    }
};
