<?php
namespace Tests\Feature;
use App\Models\User;
use App\Services\SchoolWorkbookImporter;
use App\Services\SchoolStudentProfiles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
class StudentProfilesTest extends TestCase {
 use RefreshDatabase;
 private function roster(): int {app(SchoolWorkbookImporter::class)->import(['format'=>1,'year'=>'2026-2027','sourceHash'=>str_repeat('a',64),'excluded'=>[],'corrections'=>[],'students'=>[['order'=>1,'class'=>'MS','firstName'=>'Élève Test','lastName'=>'DIOP','date'=>null,'rawDate'=>null,'sourceRegistrationBalance'=>0,'subscriptions'=>[],'receipts'=>[]]]]);return DB::table('students')->value('id');}
 private function details(): array{return ['format'=>1,'year'=>'2026-2027','sourceHash'=>str_repeat('c',64),'issues'=>[],'records'=>[['firstName'=>'Eleve  Test','lastName'=>'diop','schoolClass'=>'MS','source'=>'MS!A2:S2','fields'=>['birth'=>'2022-01-02','gender'=>'F','birthPlace'=>'Dakar','fatherName'=>'Parent exemple','motherPhone'=>'77-000-00-00','section'=>'A']]]];}
 private function command($id,$payload){return $this->postJson('/school-api/commands',['action'=>'student-profile','id'=>(string)$id,'payload'=>$payload,'revision'=>(int)DB::table('school_settings')->value('revision')]);}
 public function test_preview_and_import_only_fill_empty_fields_and_are_idempotent():void {
  $id=$this->roster();DB::table('students')->where('id',$id)->update(['place_of_birth'=>'Ville renseignée']);$service=app(SchoolStudentProfiles::class);$data=$this->details();
  $preview=$service->import($data);$this->assertSame(1,$preview['matched']);$this->assertCount(1,$preview['conflicts']);$this->assertDatabaseCount('school_student_profiles',0);$this->assertDatabaseHas('students',['date_of_birth'=>null]);
  $service->import($data,true);$this->assertDatabaseHas('students',['matricule'=>'MAT-1','date_of_birth'=>'2022-01-02','place_of_birth'=>'Ville renseignée','gender'=>'F']);$this->assertDatabaseHas('enrollments',['enrollment_date'=>null]);
  $this->assertTrue($service->import($data,true)['alreadyImported']);$this->assertDatabaseCount('school_student_profiles',1);$this->assertDatabaseCount('school_receipts',0);
 }
 public function test_duplicate_source_names_and_wrong_class_are_not_automatically_assigned():void {
  $this->roster();$data=$this->details();$data['records'][]=$data['records'][0];$r=app(SchoolStudentProfiles::class)->import($data,true);$this->assertSame(0,$r['matched']);$this->assertCount(2,$r['unmatched']);$this->assertCount(1,$r['missingStudents']);$this->assertDatabaseCount('school_student_profiles',0);
  $data=$this->details();$data['sourceHash']=str_repeat('d',64);$data['records'][0]['schoolClass']='GS';$r=app(SchoolStudentProfiles::class)->import($data,true);$this->assertSame(0,$r['matched']);
 }
 public function test_partial_manual_edit_preserves_enrollment_and_finances_and_respects_roles():void {
  $id=$this->roster();$this->actingAs(User::factory()->create(['is_school_admin'=>true]));$charges=DB::table('school_charges')->get()->toJson();
  $this->command($id,['motherName'=>'Mère test','motherPhone'=>'77 000 00 00','birth'=>'','gender'=>''])->assertOk();
  $this->assertDatabaseHas('enrollments',['enrollment_date'=>null]);$this->assertSame($charges,DB::table('school_charges')->get()->toJson());
  $this->getJson('/school-api/state')->assertOk()->assertJsonPath('students.0.details.motherName','Mère test');
  $this->command($id,['birth'=>'2040-01-01'])->assertUnprocessable();$this->command(99999,['fatherName'=>'Other'])->assertNotFound();
  $role=DB::table('school_roles')->insertGetId(['name'=>'Consultation test','permissions'=>json_encode(['students.view']),'is_system'=>false]);$this->actingAs(User::factory()->create(['school_role_id'=>$role]));$this->command($id,['motherName'=>'Interdit'])->assertForbidden();
  $role=DB::table('school_roles')->insertGetId(['name'=>'Sans accès','permissions'=>'[]','is_system'=>false]);$this->actingAs(User::factory()->create(['school_role_id'=>$role]));$this->getJson('/school-api/state')->assertOk()->assertJsonCount(0,'students');
 }
}
