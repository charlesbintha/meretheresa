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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('tuition_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('payment_type', ['tuition', 'canteen', 'transport', 'other']);
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['cash', 'bank_transfer', 'mobile_money', 'check']);
            $table->date('payment_date');
            $table->string('receipt_number')->unique();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes for faster lookups
            $table->index('student_id');
            $table->index('tuition_id');
            $table->index('payment_type');
            $table->index('payment_date');
            $table->index('receipt_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
