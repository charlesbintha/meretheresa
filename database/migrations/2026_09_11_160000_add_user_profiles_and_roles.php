<?php

use App\Support\SchoolPermissions;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description', 500)->nullable();
            $table->json('permissions');
            $table->boolean('is_system')->default(false);
            $table->timestamps();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('school_role_id')->nullable()->constrained('school_roles')->restrictOnDelete();
            $table->string('phone', 25)->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('auth_version')->default(1);
            $table->timestamp('last_login_at')->nullable();
        });
        $roles = [
            ['Administrateur', 'Accès complet. Gestion des comptes et des rôles.', array_keys(SchoolPermissions::CATALOG), true],
            ['Direction', 'Consultation de tous les modules de l’établissement.', ['students.view', 'academics.view', 'grades.view', 'finance.view', 'services.view'], false],
            ['Secrétariat', 'Gestion des dossiers scolaires et de l’organisation.', ['students.manage', 'academics.manage', 'services.manage'], false],
            ['Comptabilité', 'Encaissements, scolarités et services.', ['finance.manage', 'services.manage'], false],
            ['Pédagogie', 'Notes et bulletins pour l’ensemble de l’établissement.', ['grades.manage'], false],
        ];
        foreach ($roles as [$name, $description, $permissions, $system]) {
            $id = DB::table('school_roles')->insertGetId(['name' => $name, 'description' => $description, 'permissions' => json_encode(SchoolPermissions::normalize($permissions)), 'is_system' => $system, 'created_at' => now(), 'updated_at' => now()]);
            if ($system) {
                DB::table('users')->where('is_school_admin', true)->update(['school_role_id' => $id]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('school_role_id');
            $table->dropColumn(['phone', 'is_active', 'auth_version', 'last_login_at']);
        });
        Schema::dropIfExists('school_roles');
    }
};
