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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['يومية', 'شهرية']);  
            $table->date('date');
            $table->enum('category', ['مستلزمات', 'راتب','إيجار','فواتير']);
            $table->text('notes');
            $table->decimal('amount',8,2)->default(0);
            $table->enum('payment_status', ['مدفوع', 'غير مدفوع']);
            $table->enum('payment_method', ['نقدا', 'تحويل بنكي','بطاقة ائتمان']);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
