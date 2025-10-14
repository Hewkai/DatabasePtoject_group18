<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('category_product', function (Blueprint $t) {
      $t->foreignId('product_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
      $t->foreignId('category_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
      $t->primary(['product_id','category_id']);
    });
  }
  public function down(): void { Schema::dropIfExists('category_product'); }
};
