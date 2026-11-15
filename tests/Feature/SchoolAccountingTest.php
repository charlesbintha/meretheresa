<?php
namespace Tests\Feature;
use App\Models\{User,SchoolRole};
use App\Services\{TemplateImporter,SchoolAccounting};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
class SchoolAccountingTest extends TestCase {
 use RefreshDatabase;
 protected function setUp():void {parent::setUp();app(TemplateImporter::class)->replace(false);$u=User::factory()->create(['school_role_id'=>SchoolRole::where('name','Administrateur')->value('id')]);$this->actingAs($u)->withSession(['school_auth_version'=>$u->auth_version]);}
 private function command($a,$v=[],$id=null){return $this->postJson('/school-api/commands',['action'=>$a,'payload'=>$v,'id'=>$id?(string)$id:null,'revision'=>DB::table('school_settings')->value('revision')]);}
 private function entry():array{return ['year_id'=>1,'journal'=>'VE','date'=>'2026-10-01','reference'=>'PIECE-001','memo'=>'Scolarité octobre','reviewed'=>true,'lines'=>[['account'=>'411101','debit'=>15000,'credit'=>0],['account'=>'706101','debit'=>0,'credit'=>15000]]];}
 public function test_balanced_posting_immutable_entries_and_reversal():void {
  $id=$this->command('accounting-entry',$this->entry())->assertOk()->json('recordId');$this->command('accounting-post',[],$id)->assertOk();
  $this->command('accounting-entry',$this->entry(),$id)->assertUnprocessable();$this->command('accounting-post',[],$id)->assertUnprocessable();
  $rev=$this->command('accounting-reverse',['date'=>'2026-10-02','year_id'=>1],$id)->assertOk()->json('recordId');$this->command('accounting-reverse',['date'=>'2026-10-03'], $id)->assertUnprocessable();
  $lines=DB::table('accounting_lines')->where('entry_id',$rev)->get();$this->assertSame(15000,(int)$lines[0]->credit);$this->assertSame('draft',DB::table('accounting_entries')->where('id',$rev)->value('status'));
  $this->getJson('/school-api/accounting')->assertOk()->assertJsonCount(2,'entries');
 }
 public function test_validation_rejects_unbalanced_unreviewed_parent_and_outside_year():void {
  $v=$this->entry();$v['lines'][1]['credit']=14000;$id=$this->command('accounting-entry',$v)->assertOk()->json('recordId');$this->command('accounting-post',[],$id)->assertUnprocessable();
  $v=$this->entry();$v['reviewed']=false;$this->command('accounting-entry',$v,$id)->assertOk();$this->command('accounting-post',[],$id)->assertUnprocessable();
  $v=$this->entry();$v['lines'][0]['account']='411';$this->command('accounting-entry',$v,$id)->assertOk();$this->command('accounting-post',[],$id)->assertUnprocessable();
  $v=$this->entry();$v['date']='2027-01-01';$this->command('accounting-entry',$v,$id)->assertUnprocessable();
  $this->command('accounting-close',[],1)->assertUnprocessable();
  $this->command('accounting-year',['name'=>'2027','start'=>'2026-12-01','end'=>'2027-12-31'])->assertUnprocessable();
 }
 public function test_closed_year_and_permissions():void {
  $this->command('accounting-close',[],1)->assertOk();$this->command('accounting-entry',$this->entry())->assertUnprocessable();
  $u=User::factory()->create(['school_role_id'=>SchoolRole::where('name','Secrétariat')->value('id')]);$this->actingAs($u)->withSession(['school_auth_version'=>$u->auth_version]);$this->getJson('/school-api/accounting')->assertForbidden();$this->command('accounting-entry',$this->entry())->assertForbidden();
 }
 public function test_source_preparation_idempotence_and_stale_receipts():void {
  $student=DB::table('students')->first();$year=DB::table('academic_years')->first();
  $cid=DB::table('school_charges')->insertGetId(['student_id'=>$student->id,'academic_year_id'=>$year->id,'kind'=>'tuition','month'=>'2026-10','due_date'=>'2026-10-01','amount'=>15000]);
  $rid=DB::table('school_receipts')->insertGetId(['charge_id'=>$cid,'amount'=>15000,'paid_at'=>'2026-10-01','reference'=>'R1','label'=>'Scolarité','method'=>null]);
  $this->command('accounting-prepare',['yearId'=>1])->assertOk();$this->command('accounting-prepare',['yearId'=>1])->assertOk();$this->assertDatabaseCount('accounting_entries',1);$e=DB::table('accounting_entries')->first();$this->assertSame('draft',$e->status);$this->assertNull(DB::table('accounting_lines')->where('entry_id',$e->id)->first()->account);
  $v=$this->entry();$v['journal']='CA';$v['lines']=[['account'=>'5711','debit'=>15000,'credit'=>0],['account'=>'411101','debit'=>0,'credit'=>15000]];$this->command('accounting-entry',$v,$e->id)->assertOk();
  DB::table('school_receipts')->where('id',$rid)->update(['amount'=>14000]);$this->command('accounting-post',[],$e->id)->assertUnprocessable();$this->command('accounting-prepare',['yearId'=>1])->assertOk();$this->assertDatabaseCount('accounting_entries',1);$this->assertSame(14000,(int)DB::table('accounting_lines')->where('entry_id',$e->id)->sum('debit'));
 }
 public function test_exports_are_real_files_and_formulas_are_literal():void {
  $payload=['format'=>'xlsx','scope'=>'students','name'=>'Élèves','headers'=>['Nom','Montant'],'rows'=>[['=1+2',15000],['Élève à Dakar',13000]]];
  $r=$this->postJson('/school-api/export',$payload)->assertOk();$bytes=$r->streamedContent();$path=tempnam(sys_get_temp_dir(),'xlsx');file_put_contents($path,$bytes);$book=\PhpOffice\PhpSpreadsheet\IOFactory::load($path);unlink($path);$this->assertSame('=1+2',$book->getActiveSheet()->getCell('A5')->getValue());$this->assertSame('s',$book->getActiveSheet()->getCell('A5')->getDataType());$this->assertSame(15000,$book->getActiveSheet()->getCell('B5')->getValue());
  $payload['format']='pdf';$r=$this->postJson('/school-api/export',$payload)->assertOk();$this->assertStringStartsWith('%PDF-',$r->getContent());
  $payload['format']='csv';$this->postJson('/school-api/export',$payload)->assertUnprocessable();
 }
}
