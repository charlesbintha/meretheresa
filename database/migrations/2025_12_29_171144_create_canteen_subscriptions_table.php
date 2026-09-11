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
        Schema::create('canteen_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('academic_year_id')->constrained()->onDelete('cascade');
            $table->enum('subscription_type', ['daily', 'weekly', 'monthly', 'term']);
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('monthly_fee', 10, 2);
            $table->enum('status', ['active', 'suspended', 'cancelled'])->default('active');
            $table->timestamps();

            // Indexes for faster lookups
            $table->index('student_id');
            $table->index('academic_year_id');
            $table->index('status');
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canteen_subscriptions');
    }
};
