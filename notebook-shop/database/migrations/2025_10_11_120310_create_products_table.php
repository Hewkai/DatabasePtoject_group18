<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
        $table->id();
        
        $table->foreignId('brand_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();

        $table->string('model');
        $table->enum('cpu_brand', ['Intel','AMD']);
        $table->string('cpu_model')->nullable();
        $table->integer('ram_gb')->default(8);
        $table->integer('storage_gb')->default(256);
        $table->string('gpu')->nullable();
        $table->decimal('price', 10, 2)->nullable();
        $table->timestamps();

        // index ช่วยค้น
        $table->index(['brand_id','cpu_brand']);
        $table->index('price');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
