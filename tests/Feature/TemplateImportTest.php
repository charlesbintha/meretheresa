<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\TemplateImporter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TemplateImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_replaces_school_records_preserves_users_and_backs_up_previous_data(): void
    {
        $user = User::factory()->create();
        app(TemplateImporter::class)->replace(false);
        $this->assertDatabaseCount('students', 288);
        $this->assertDatabaseCount('teachers', 18);
        $this->assertDatabaseCount('classes', 12);
        $this->assertDatabaseCount('grades', 10368);
        $this->assertDatabaseCount('payments', 84);
        $this->assertDatabaseCount('timetables', 180);
        $this->assertSame(6, DB::table('enrollments')->where('status', 'pending')->count());
        DB::table('students')->where('id', 1)->update(['first_name' => 'Before replacement']);
        $path = app(TemplateImporter::class)->replace();
        try {
            $backup = json_decode(gzdecode(file_get_contents($path)), true, 512, JSON_THROW_ON_ERROR);
            $this->assertSame('Before replacement', $backup['tables']['students'][0]['first_name']);
            $this->assertDatabaseHas('users', ['id' => $user->id, 'email' => $user->email]);
            $this->assertDatabaseMissing('students', ['first_name' => 'Before replacement']);
            $this->assertDatabaseCount('students', 288);
            foreach (DB::table('tuitions')->get() as $tuition) {
                $sum = DB::table('payments')->where('tuition_id', $tuition->id)->sum('amount');
                $this->assertEquals($sum, $tuition->paid_amount);
                $this->assertEquals($tuition->total_amount - $sum, $tuition->remaining_amount);
            }
        } finally {
            if ($path && is_file($path)) {
                unlink($path);
            }
        }
    }

    public function test_named_seeder_imports_data_and_keeps_the_administrator(): void
    {
        $user = User::factory()->create(['is_school_admin' => true]);
        $pattern = storage_path('app/private/backups/school-*.json.gz');
        $before = glob($pattern);
        try {
            $this->artisan('db:seed', [
                '--class' => \Database\Seeders\TemplateDataSeeder::class,
                '--force' => true,
            ])->assertSuccessful();
            $this->assertDatabaseCount('students', 288);
            $this->assertDatabaseCount('grades', 10368);
            $this->assertDatabaseHas('users', ['id' => $user->id, 'is_school_admin' => true]);
            $backups = array_values(array_diff(glob($pattern), $before));
            $this->assertCount(1, $backups);
            $snapshot = json_decode(gzdecode(file_get_contents($backups[0])), true, 512, JSON_THROW_ON_ERROR);
            $this->assertSame([], $snapshot['tables']['students']);
        } finally {
            foreach (array_diff(glob($pattern), $before) as $backup) {
                unlink($backup);
            }
        }
    }

    public function test_command_requires_exact_target_name(): void
    {
        $this->artisan('school:import-template', ['--replace' => true, '--database-name' => 'wrong'])->assertFailed();
        $this->assertDatabaseCount('students', 0);
    }
}
