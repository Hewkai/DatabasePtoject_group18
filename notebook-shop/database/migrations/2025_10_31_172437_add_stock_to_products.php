<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('products', function (Blueprint $t) {
            // เพิ่มคอลัมน์ stock ถ้ายังไม่มี 
            if (!Schema::hasColumn('products', 'stock')) {
                $t->unsignedInteger('stock')->default(0)->after('price');
            }

            // สร้าง index ชื่อกำหนดเอง จะได้ลบได้ตรงชื่อแน่นอน
            $t->index('stock', 'products_stock_idx');
        });
    }

    public function down(): void {
        Schema::table('products', function (Blueprint $t) {
            // ลบ index ตามชื่อที่ตั้งไว้
            $t->dropIndex('products_stock_idx');

            // ค่อยลบคอลัมน์ (กัน error ถ้าคอลัมน์ถูกลบไปแล้ว)
            if (Schema::hasColumn('products', 'stock')) {
                $t->dropColumn('stock');
            }
        });
    }
};
