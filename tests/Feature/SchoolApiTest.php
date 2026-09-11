<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\TemplateImporter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class SchoolApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        app(TemplateImporter::class)->replace(false);
    }

    private function admin(): User
    {
        $u = User::factory()->create();
        $u->forceFill(['is_school_admin' => true])->save();
        $this->actingAs($u);

        return $u;
    }

    private function command(string $action, array $payload = [], ?int $id = null, ?int $revision = null)
    {
        return $this->postJson('/school-api/commands', ['action' => $action, 'payload' => $payload, 'id' => $id === null ? null : (string) $id, 'revision' => $revision ?? DB::table('school_settings')->value('revision')]);
    }

    public function test_access_requires_an_administrator(): void
    {
        $this->getJson('/school-api/state')->assertUnauthorized();
        $this->actingAs(User::factory()->create())->getJson('/school-api/state')->assertForbidden();
        $this->admin();
        $this->getJson('/school-api/state')->assertOk()->assertJsonCount(288, 'students')->assertJsonCount(84, 'payments');
        $this->get('/')->assertOk()->assertSee('template/server.js');
    }

    public function test_payment_is_atomic_and_idempotent(): void
    {
        $this->admin();
        $tuition = DB::table('tuitions')->where('remaining_amount', '>', 0)->first();
        $v = ['studentId' => $tuition->student_id, 'amount' => (int) $tuition->remaining_amount, 'type' => 'Scolarité', 'method' => 'Wave', 'date' => '2026-03-16', 'requestKey' => (string) Str::uuid()];
        $rev = DB::table('school_settings')->value('revision');
        $this->command('payment', $v, null, $rev)->assertOk();
        $this->assertDatabaseHas('tuitions', ['id' => $tuition->id, 'status' => 'paid', 'remaining_amount' => 0]);
        $this->command('payment', $v, null, $rev)->assertOk();
        $this->assertDatabaseCount('payments', 85);
        $v['requestKey'] = (string) Str::uuid();
        $this->command('payment', $v)->assertUnprocessable();
        $this->assertDatabaseCount('payments', 85);
    }

    public function test_revision_and_validation_prevent_overwrite(): void
    {
        $this->admin();
        $revision = DB::table('school_settings')->value('revision');
        $this->command('preferences', ['theme' => 'dark'])->assertOk();
        $this->command('preferences', ['theme' => 'light'], null, $revision)->assertConflict();
        $this->command('payment', ['amount' => -50])->assertUnprocessable();
        $this->assertDatabaseCount('payments', 84);
    }

    public function test_grade_writes_validate_the_whole_batch(): void
    {
        $this->admin();
        $s = DB::table('enrollments')->where('status', 'confirmed')->first();
        $v = ['classId' => $s->class_id, 'subjectId' => 1, 'term' => 2, 'rows' => [['studentId' => $s->student_id, 'test' => 18, 'exam' => 19]]];
        $this->command('grades', $v)->assertOk();
        $this->assertDatabaseHas('grades', ['student_id' => $s->student_id, 'subject_id' => 1, 'period_id' => 2, 'grade_type' => 'homework', 'score' => 18]);
        $v['rows'][] = ['studentId' => 288, 'test' => 30, 'exam' => 15];
        $v['rows'][0]['test'] = 2;
        $this->command('grades', $v)->assertUnprocessable();
        $this->assertDatabaseHas('grades', ['student_id' => $s->student_id, 'subject_id' => 1, 'period_id' => 2, 'grade_type' => 'homework', 'score' => 18]);
    }

    public function test_timetable_conflicts_and_year_isolation(): void
    {
        $this->admin();
        $l = DB::table('timetables')->first();
        $this->command('lesson', ['classId' => $l->class_id, 'subjectId' => $l->subject_id, 'teacherId' => $l->teacher_id, 'day' => 0, 'start' => 8, 'room' => $l->room])->assertUnprocessable();
        $this->command('year-activate', [], 2)->assertOk()->assertJsonCount(0, 'state.students')->assertJsonCount(0, 'state.payments');
        $this->command('lesson-delete', [], $l->id)->assertUnprocessable();
        $this->assertDatabaseCount('timetables', 180);
    }
}
