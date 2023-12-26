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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignUuid('project_id')->nullable();
            $table->foreignUuid('created_by');
            $table->date('prepared_date');
            $table->text('assembly_type');
            $table->text('manufacturer');
            $table->text('sq_field');
            $table->text('parapet_length');
            $table->text('warranty');
            $table->text('sq_walls');
            $table->text('building_height');
            $table->text('deck_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
