<?php

namespace Tests\Feature;

use App\Models\SchoolRole;
use App\Models\User;
use App\Services\TemplateImporter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SchoolAccountsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        app(TemplateImporter::class)->replace(false);
    }

    private function user(string $role = 'Administrateur'): User
    {
        return User::factory()->create(['school_role_id' => SchoolRole::where('name', $role)->value('id'), 'password' => Hash::make('Original-secret-2026')]);
    }

    private function login(User $user): void
    {
        $this->actingAs($user->fresh())->withSession(['school_auth_version' => $user->fresh()->auth_version]);
    }

    private function command(string $action, array $payload = [], ?int $id = null)
    {
        return $this->postJson('/school-api/commands', ['action' => $action, 'payload' => $payload, 'id' => $id === null ? null : (string) $id, 'revision' => DB::table('school_settings')->value('revision')]);
    }

    public function test_account_creation_assigns_role_and_hashes_password(): void
    {
        $this->login($this->user());
        $this->command('account', ['name' => 'Agent comptable', 'email' => 'account@example.test', 'roleId' => SchoolRole::where('name', 'Comptabilité')->value('id'), 'password' => 'Private-password-2026', 'password_confirmation' => 'Private-password-2026'])->assertOk();
        $user = User::where('email', 'account@example.test')->firstOrFail();
        $this->assertTrue(Hash::check('Private-password-2026', $user->password));
        $this->assertFalse($user->isSchoolAdministrator());
        $this->assertTrue($user->canSchool('finance.manage'));
        $this->assertFalse($user->canSchool('grades.view'));
        $long = str_repeat('a', 73);
        $this->command('account-password', ['password'=>$long, 'password_confirmation'=>$long], $user->id)->assertUnprocessable();
        $this->command('role', ['name'=>'Invalid', 'permissions'=>[]], -1)->assertUnprocessable();
        $state = $this->getJson('/school-api/state')->assertOk()->json();
        $this->assertArrayNotHasKey('password', $state['users'][0]);
        $this->assertArrayNotHasKey('auth_version', $state['users'][0]);
        $this->command('account', ['name' => 'Doublon', 'email' => $user->email, 'roleId' => $user->school_role_id, 'password' => 'Private-password-2026', 'password_confirmation' => 'Private-password-2026'])->assertUnprocessable();
    }

    public function test_roles_filter_sensitive_data_and_prevent_forged_commands(): void
    {
        $user = $this->user('Pédagogie');
        $this->login($user);
        $this->getJson('/school-api/state')->assertOk()->assertJsonCount(288, 'students')->assertJsonCount(10368, 'grades')->assertJsonCount(0, 'payments')->assertJsonCount(0, 'tuitions')->assertJsonCount(0, 'users')->assertJsonCount(0, 'roles');
        foreach (['account', 'account-status', 'account-password', 'role', 'role-delete', 'payment', 'student', 'settings'] as $action) {
            $this->command($action)->assertForbidden();
        }
        $this->command('preferences', ['theme' => 'dark'])->assertOk();
        $this->login($this->user('Direction'));
        $this->getJson('/school-api/state')->assertOk()->assertJsonCount(84, 'payments');
        $this->command('grades')->assertForbidden();
    }

    public function test_profile_cannot_escalate_privileges_and_requires_current_password(): void
    {
        $user = $this->user('Pédagogie');
        $this->login($user);
        $profile = ['name' => 'Nom modifié', 'email' => $user->email, 'phone' => '770000000'];
        $this->command('profile', $profile + ['is_school_admin' => true])->assertUnprocessable();
        $this->command('profile', $profile)->assertOk();
        $profile['email'] = 'new-email@example.test';
        $this->command('profile', $profile + ['current_password' => 'incorrect'])->assertUnprocessable();
        $this->assertDatabaseHas('users', ['id' => $user->id, 'email' => $user->email]);
        $this->command('profile', $profile + ['current_password' => 'Original-secret-2026', 'password' => 'New-secret-2026', 'password_confirmation' => 'New-secret-2026'])->assertOk()->assertJsonStructure(['csrfToken']);
        $this->assertTrue(Hash::check('New-secret-2026', $user->fresh()->password));
        $this->assertFalse($user->fresh()->isSchoolAdministrator());
        $this->assertSame(2, $user->fresh()->auth_version);
        $this->getJson('/school-api/state')->assertOk();
    }

    public function test_deactivation_revokes_sessions_and_blocks_login(): void
    {
        $admin = $this->user();
        $user = $this->user('Secrétariat');
        $this->login($admin);
        $this->command('account-status', ['isActive' => false], $user->id)->assertOk();
        $this->actingAs($user->fresh())->withSession(['school_auth_version' => 1])->getJson('/school-api/state')->assertUnauthorized();
        $this->post('/login', ['email' => $user->email, 'password' => 'Original-secret-2026'])->assertSessionHasErrors('email');
        $this->login($admin);
        $this->command('account-status', ['isActive' => true], $user->id)->assertOk();
        $this->actingAs($user->fresh())->withSession(['school_auth_version' => 1])->getJson('/school-api/state')->assertUnauthorized();
    }

    public function test_last_admin_system_role_and_assigned_roles_are_protected(): void
    {
        $admin = $this->user();
        $this->login($admin);
        $this->command('account-status', ['isActive' => false], $admin->id)->assertUnprocessable();
        $this->command('account', ['name' => $admin->name, 'email' => $admin->email, 'roleId' => SchoolRole::where('name', 'Direction')->value('id')], $admin->id)->assertUnprocessable();
        $system = SchoolRole::where('is_system', true)->firstOrFail();
        $this->command('role', ['name' => 'Renommé', 'permissions' => []], $system->id)->assertUnprocessable();
        $this->command('role-delete', [], $system->id)->assertUnprocessable();
        $assigned = $this->user('Direction');
        $this->command('role-delete', [], $assigned->school_role_id)->assertUnprocessable();
    }

    public function test_custom_role_edit_and_password_reset_revoke_existing_sessions(): void
    {
        $admin = $this->user();
        $this->login($admin);
        $result = $this->command('role', ['name' => 'Service limité', 'permissions' => ['services.manage']])->assertOk();
        $role = SchoolRole::findOrFail($result->json('recordId'));
        $this->assertContains('students.view', $role->permissions);
        $this->assertContains('services.view', $role->permissions);
        $user = User::factory()->create(['school_role_id' => $role->id]);
        $this->command('role', ['name' => $role->name, 'permissions' => []], $role->id)->assertOk();
        $this->assertSame(2, $user->fresh()->auth_version);
        $this->actingAs($user->fresh())->withSession(['school_auth_version' => 1])->getJson('/school-api/state')->assertUnauthorized();
        $this->login($admin);
        $this->command('account-password', ['password' => 'Replacement-secret-2026', 'password_confirmation' => 'Replacement-secret-2026'], $user->id)->assertOk();
        $this->assertTrue(Hash::check('Replacement-secret-2026', $user->fresh()->password));
        $this->command('role', ['name' => 'Escalation', 'permissions' => ['users.manage']])->assertUnprocessable();
        $this->assertSame(3, $user->fresh()->auth_version);
    }
}
