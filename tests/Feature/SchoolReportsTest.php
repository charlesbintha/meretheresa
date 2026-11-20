<?php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Services\TemplateImporter;
class SchoolReportsTest extends TestCase {
 use RefreshDatabase;
 private function fixture():array {
  app(TemplateImporter::class)->replace(false);$this->actingAs(User::factory()->create(['is_school_admin'=>true]));
  $e=DB::table('enrollments')->where('status','confirmed')->first();$period=DB::table('periods')->where('academic_year_id',$e->academic_year_id)->where('term_number',1)->first();
  DB::table('grades')->where('period_id',$period->id)->where('class_id',$e->class_id)->delete();
  $students=DB::table('enrollments')->where('class_id',$e->class_id)->where('status','confirmed')->take(2)->pluck('student_id');
  foreach($students as $sid)foreach(DB::table('subjects')->get() as $s)foreach(['homework','exam'] as $kind)DB::table('grades')->insert(['student_id'=>$sid,'subject_id'=>$s->id,'class_id'=>$e->class_id,'period_id'=>$period->id,'grade_type'=>$kind,'score'=>14,'max_score'=>20,'teacher_id'=>$s->teacher_id,'grade_date'=>'2026-11-20']);
  return [$e->class_id,$students];
 }
 public function test_generation_archives_complete_results_and_tied_ranks_without_duplicates():void {
  [$class,$students]=$this->fixture();$url="/school-api/reports?classId=$class&term=1";$data=$this->getJson($url)->assertOk()->json();$complete=collect($data['cards'])->where('complete',true);$this->assertCount(2,$complete);$this->assertSame([1,1],$complete->pluck('rank')->all());
  $v=['classId'=>$class,'term'=>1,'students'=>[['id'=>$students[0],'comment'=>'Bon travail','absences'=>2,'late'=>1]]];$card=$this->postJson('/school-api/reports',$v)->assertOk()->json('cards.0');$this->assertEquals(14,$card['average']);$this->assertEquals(2,$card['absences']);
  $this->postJson('/school-api/reports',$v)->assertOk();$this->assertDatabaseCount('school_report_snapshots',1);
  DB::table('grades')->where('student_id',$students[0])->update(['score'=>0]);
  $this->getJson('/school-api/reports/'.$card['id'])->assertOk()->assertJsonPath('average',14);
  $this->postJson('/school-api/reports',$v)->assertOk()->assertJsonPath('cards.0.average',0);$this->assertDatabaseCount('school_report_snapshots',2);
 }
 public function test_incomplete_batch_rejected_atomically_and_read_only_cannot_generate():void {
  [$class,$students]=$this->fixture();DB::table('grades')->where('student_id',$students[1])->delete();
  $this->postJson('/school-api/reports',['classId'=>$class,'term'=>1,'students'=>[['id'=>$students[0]],['id'=>$students[1]]]])->assertUnprocessable();$this->assertDatabaseCount('school_report_snapshots',0);
  $this->actingAs(User::factory()->create())->getJson("/school-api/reports?classId=$class&term=1")->assertForbidden();
 }
 public function test_demo_command_refuses_normal_database():void {$this->artisan('school:create-demo')->assertExitCode(1);}
}
