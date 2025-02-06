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
        Schema::create('sale_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->integer('unit_price');
            $table->integer('total_price');
            $table->foreignId('sale_invoice_id')->nullable()->constrained('sale_invoices')->nullOnDelete();
            $table->foreignId('medicine_id')->nullable()->constrained('medicines')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_invoice_items');
    }
};
