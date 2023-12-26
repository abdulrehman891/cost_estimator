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
            $table->uuid('id')->primary();
            $table->string('product_name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default('0');
            $table->decimal('weight', 10, 2)->default('0');
            $table->decimal('length', 10, 2)->default('0');
            $table->decimal('width', 10, 2)->default('0');
            $table->decimal('height', 10, 2)->default('0');
            $table->string('material')->nullable();
            $table->string('color')->nullable();
            $table->integer('stock_quantity')->default('0');
            $table->foreignUuid('product_category_id')->nullable();
            $table->foreignUuid('product_subcategory_id')->nullable();
            $table->foreignUuid('created_by');
            $table->string('sku');
            $table->timestamps();
            $table->softDeletes();
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
