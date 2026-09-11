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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('period_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_id')->constrained()->onDelete('cascade');
            $table->enum('grade_type', ['homework', 'quiz', 'exam', 'participation']);
            $table->decimal('score', 5, 2);
            $table->decimal('max_score', 5, 2);
            $table->date('grade_date');
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes for faster lookups
            $table->index('student_id');
            $table->index('subject_id');
            $table->index('period_id');
            $table->index('class_id');
            $table->index('teacher_id');
            $table->index('grade_type');
            $table->index('grade_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
