<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('students', function(Blueprint $t) {
            $t->date('date_of_birth')->nullable()->change(); $t->string('place_of_birth')->nullable()->change();
            $t->enum('gender',['M','F'])->nullable()->change(); $t->string('parent_name')->nullable()->change();
            $t->string('parent_phone')->nullable()->change(); $t->text('address')->nullable()->change();
        });
        Schema::table('enrollments',fn(Blueprint $t)=>$t->date('enrollment_date')->nullable()->change());
        Schema::create('school_imports',function(Blueprint $t){$t->id();$t->foreignId('academic_year_id')->unique()->constrained()->cascadeOnDelete();$t->string('source_hash')->unique();$t->json('audit');$t->timestamps();});
        Schema::create('school_charges',function(Blueprint $t){$t->id();$t->foreignId('student_id')->constrained()->cascadeOnDelete();$t->foreignId('academic_year_id')->constrained()->cascadeOnDelete();$t->string('kind',30);$t->string('month',7);$t->date('due_date');$t->unsignedInteger('amount');$t->unsignedInteger('waiver')->default(0);$t->string('waiver_reason',500)->nullable();$t->timestamps();$t->unique(['student_id','academic_year_id','kind','month'],'school_charge_unique');});
        Schema::create('school_receipts',function(Blueprint $t){$t->id();$t->foreignId('charge_id')->constrained('school_charges')->cascadeOnDelete();$t->unsignedInteger('amount');$t->date('paid_at')->nullable();$t->string('reference')->nullable();$t->string('label');$t->string('method')->nullable();$t->string('source_key')->nullable()->unique();$t->string('raw_date')->nullable();$t->uuid('request_key')->nullable()->unique();$t->timestamps();});
        Schema::create('school_service_memberships',function(Blueprint $t){$t->id();$t->foreignId('student_id')->constrained()->cascadeOnDelete();$t->foreignId('academic_year_id')->constrained()->cascadeOnDelete();$t->string('kind',30);$t->string('zone')->nullable();$t->string('trip')->default('round_trip');$t->unsignedInteger('monthly_fee');$t->boolean('active')->default(true);$t->timestamps();$t->unique(['student_id','academic_year_id','kind'],'school_membership_unique');});
    }
    public function down(): void {foreach(['school_service_memberships','school_receipts','school_charges','school_imports'] as $table)Schema::dropIfExists($table);}
};
