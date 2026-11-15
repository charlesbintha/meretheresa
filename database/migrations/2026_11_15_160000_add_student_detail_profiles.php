<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('school_student_profiles',function(Blueprint $t){$t->id();$t->foreignId('student_id')->unique()->constrained()->cascadeOnDelete();$t->json('details');$t->string('source_cell')->nullable();$t->string('source_hash',64)->nullable();$t->timestamps();});
  Schema::create('school_detail_imports',function(Blueprint $t){$t->id();$t->foreignId('academic_year_id')->constrained();$t->string('source_hash',64)->unique();$t->json('audit');$t->timestamps();});
 }
 public function down(): void {Schema::dropIfExists('school_detail_imports');Schema::dropIfExists('school_student_profiles');}
};
