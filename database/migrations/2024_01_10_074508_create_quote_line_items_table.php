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
        Schema::create('quote_line_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->foreignUuid('created_by');
            $table->foreignUuid('quotation_id')->nullable();
            $table->foreignUuid('product_id')->nullable();
            $table->foreignUuid('project_milestone_id')->nullable();
            $table->decimal('unit_price', 10, 2)->default('0');
            $table->decimal('discount_price', 10, 2)->default('0');
            $table->integer('quantity')->default('0');
            $table->decimal('total_price', 10, 2)->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_line_items');
    }
};
