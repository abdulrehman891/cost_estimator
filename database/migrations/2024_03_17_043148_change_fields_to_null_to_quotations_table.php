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
        Schema::table('quotations', function (Blueprint $table) {
            //
            $table->date('prepared_date')->nullable()->change();
            $table->text('assembly_type')->nullable()->change();
            $table->text('manufacturer')->nullable()->change();
            $table->text('sq_field')->nullable()->change();
            $table->text('parapet_length')->nullable()->change();
            $table->text('warranty')->nullable()->change();
            $table->text('sq_walls')->nullable()->change();
            $table->text('building_height')->nullable()->change();
            $table->text('deck_type')->nullable()->change();
            $table->text('inclusions')->nullable()->change();
            $table->text('exclusions')->nullable()->change();
            $table->text('payment_schedule')->nullable()->change();
            $table->text('price_escalation_clause')->nullable()->change();
            $table->text('alterations')->nullable()->change();
            $table->text('compliance')->nullable()->change();
            $table->text('timelines')->nullable()->change();
            $table->text('warranty_clause')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            //
        });
    }
};
