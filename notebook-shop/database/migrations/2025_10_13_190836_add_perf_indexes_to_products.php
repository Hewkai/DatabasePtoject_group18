<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    private function idxExists(string $table, string $index): bool {
        $sql = "SELECT 1 FROM information_schema.statistics
                WHERE table_schema = DATABASE() AND table_name = ? AND index_name = ? LIMIT 1";
        return (bool) DB::selectOne($sql, [$table, $index]);
    }

    public function up(): void {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products','brand_id')    && !$this->idxExists('products','products_brand_id_idx'))   $table->index('brand_id','products_brand_id_idx');
            if (Schema::hasColumn('products','cpu_brand')   && !$this->idxExists('products','products_cpu_brand_idx'))  $table->index('cpu_brand','products_cpu_brand_idx');
            if (Schema::hasColumn('products','price')       && !$this->idxExists('products','products_price_idx'))      $table->index('price','products_price_idx');
            if (Schema::hasColumn('products','created_at')  && !$this->idxExists('products','products_created_at_idx')) $table->index('created_at','products_created_at_idx');
        });
    }

    public function down(): void {
        Schema::table('products', function (Blueprint $table) {
            foreach (['products_brand_id_idx','products_cpu_brand_idx','products_price_idx','products_created_at_idx'] as $idx) {
                try { $table->dropIndex($idx); } catch (\Throwable $e) {}
            }
        });
    }
};
