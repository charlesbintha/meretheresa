<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', fn (Blueprint $t) => $t->boolean('is_school_admin')->default(false));
        Schema::table('classes', fn (Blueprint $t) => $t->string('room')->nullable());
        Schema::table('subjects', fn (Blueprint $t) => $t->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete());
        Schema::table('periods', fn (Blueprint $t) => $t->unsignedTinyInteger('term_number')->default(1));
        Schema::table('tuitions', fn (Blueprint $t) => $t->foreignId('period_id')->nullable()->constrained()->nullOnDelete());
        Schema::table('payments', function (Blueprint $t) {
            $t->string('display_method')->nullable();
            $t->string('display_type')->nullable();
            $t->uuid('request_key')->nullable()->unique();
        });
        Schema::table('enrollments', fn (Blueprint $t) => $t->date('approved_date')->nullable());
        foreach (['canteen_subscriptions', 'transport_subscriptions', 'evening_studies'] as $table) {
            Schema::table($table, fn (Blueprint $t) => $t->string('plan_label')->nullable());
        }
        Schema::create('school_settings', function (Blueprint $t) {
            $t->id();
            $t->json('values');
            $t->unsignedBigInteger('revision')->default(1);
            $t->timestamps();
        });
        DB::table('school_settings')->insert(['id' => 1, 'values' => json_encode(['school' => 'Groupe Scolaire Mère Teresa', 'city' => 'Dakar, Sénégal', 'email' => '', 'phone' => '', 'address' => '', 'tuitionFee' => 150000]), 'revision' => 1, 'created_at' => now(), 'updated_at' => now()]);
        Schema::create('school_preferences', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $t->json('values');
            $t->timestamps();
        });
        Schema::create('school_audit_logs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->string('action');
            $t->string('record_id')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_audit_logs');
        Schema::dropIfExists('school_preferences');
        Schema::dropIfExists('school_settings');
        foreach (['canteen_subscriptions', 'transport_subscriptions', 'evening_studies'] as $table) {
            Schema::table($table, fn (Blueprint $t) => $t->dropColumn('plan_label'));
        }
        Schema::table('enrollments', fn (Blueprint $t) => $t->dropColumn('approved_date'));
        Schema::table('payments', function (Blueprint $t) {
            $t->dropUnique(['request_key']);
            $t->dropColumn(['display_method', 'display_type', 'request_key']);
        });
        Schema::table('tuitions', fn (Blueprint $t) => $t->dropConstrainedForeignId('period_id'));
        Schema::table('periods', fn (Blueprint $t) => $t->dropColumn('term_number'));
        Schema::table('subjects', fn (Blueprint $t) => $t->dropConstrainedForeignId('teacher_id'));
        Schema::table('classes', fn (Blueprint $t) => $t->dropColumn('room'));
        Schema::table('users', fn (Blueprint $t) => $t->dropColumn('is_school_admin'));
    }
};
