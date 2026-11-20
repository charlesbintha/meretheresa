<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('school_report_snapshots',function(Blueprint $t){$t->id();$t->foreignId('student_id')->constrained()->cascadeOnDelete();$t->foreignId('class_id')->constrained()->cascadeOnDelete();$t->foreignId('period_id')->constrained()->cascadeOnDelete();$t->foreignId('created_by')->constrained('users');$t->string('fingerprint',64)->unique();$t->json('snapshot');$t->timestamps();});
 }
 public function down(): void {Schema::dropIfExists('school_report_snapshots');}
};
