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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('period_id')->constrained()->onDelete('cascade');
            $table->enum('behavior_rating', ['excellent', 'good', 'average', 'needs_improvement']);
            $table->enum('attendance_rating', ['excellent', 'good', 'average', 'poor']);
            $table->enum('participation_rating', ['excellent', 'good', 'average', 'poor']);
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->text('comments')->nullable();
            $table->timestamps();

            // Indexes for faster lookups
            $table->index('student_id');
            $table->index('subject_id');
            $table->index('period_id');
            $table->index('teacher_id');
            // Ensure one evaluation per student per subject per period
            $table->unique(['student_id', 'subject_id', 'period_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
