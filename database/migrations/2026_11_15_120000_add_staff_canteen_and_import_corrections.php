<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('school_corrections',function(Blueprint $t){$t->id();$t->foreignId('academic_year_id')->constrained();$t->string('source_hash',64);$t->string('correction_hash',64)->unique();$t->json('audit');$t->timestamps();});
        Schema::table('school_service_memberships',function(Blueprint $t){$t->unsignedInteger('monthly_fee')->nullable()->change();$t->boolean('abandoned')->default(false);});
        Schema::table('school_charges',fn(Blueprint $t)=>$t->boolean('tariff_pending')->default(false));
        Schema::create('school_staff',function(Blueprint $t){$t->id();$t->string('first_name');$t->string('last_name');$t->string('role')->nullable();$t->string('source_key')->nullable()->unique();$t->timestamps();});
        Schema::create('school_staff_canteen',function(Blueprint $t){$t->id();$t->foreignId('staff_id')->constrained('school_staff');$t->foreignId('academic_year_id')->constrained();$t->unsignedInteger('monthly_fee');$t->boolean('active')->default(true);$t->timestamps();$t->unique(['staff_id','academic_year_id']);});
        Schema::create('school_staff_charges',function(Blueprint $t){$t->id();$t->foreignId('membership_id')->constrained('school_staff_canteen');$t->string('month',7);$t->unsignedInteger('amount');$t->timestamps();$t->unique(['membership_id','month']);});
        Schema::create('school_staff_receipts',function(Blueprint $t){$t->id();$t->foreignId('charge_id')->constrained('school_staff_charges');$t->unsignedInteger('amount');$t->date('paid_at')->nullable();$t->string('reference')->nullable();$t->uuid('request_key')->unique();$t->timestamps();});
    }
    public function down(): void {
        foreach(['school_staff_receipts','school_staff_charges','school_staff_canteen','school_staff','school_corrections'] as $table)Schema::dropIfExists($table);
        Schema::table('school_charges',fn(Blueprint $t)=>$t->dropColumn('tariff_pending'));
        Schema::table('school_service_memberships',fn(Blueprint $t)=>$t->dropColumn('abandoned'));
    }
};
