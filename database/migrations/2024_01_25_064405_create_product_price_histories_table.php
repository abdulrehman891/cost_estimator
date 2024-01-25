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
        Schema::create('product_price_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->decimal('old_unit_price', 10, 2)->default('0');
            $table->decimal('new_unit_price', 10, 2)->default('0');
            $table->foreignUuid('product_id')->nullable();
            $table->foreignUuid('created_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_price_histories');
    }
};
