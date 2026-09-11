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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ex: 6ème Année, CM2
            $table->string('level'); // ex: Primaire, Collège
            $table->foreignId('academic_year_id')->constrained()->onDelete('cascade');
            $table->integer('capacity')->default(30);
            $table->foreignId('class_teacher_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
