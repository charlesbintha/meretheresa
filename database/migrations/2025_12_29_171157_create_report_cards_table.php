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
        Schema::create('report_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_id')->constrained()->onDelete('cascade');
            $table->foreignId('period_id')->constrained()->onDelete('cascade');
            $table->foreignId('academic_year_id')->constrained()->onDelete('cascade');
            $table->decimal('total_score', 8, 2);
            $table->decimal('average', 5, 2);
            $table->integer('rank')->nullable();
            $table->text('teacher_comment')->nullable();
            $table->text('principal_comment')->nullable();
            $table->timestamp('generated_at')->useCurrent();
            $table->timestamps();

            // Indexes for faster lookups
            $table->index('student_id');
            $table->index('class_id');
            $table->index('period_id');
            $table->index('academic_year_id');
            // Ensure one report card per student per period per academic year
            $table->unique(['student_id', 'period_id', 'academic_year_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_cards');
    }
};
