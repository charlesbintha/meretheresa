<?php
namespace Tests\Feature;
use App\Models\{User,SchoolRole};
use App\Services\TemplateImporter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{DB,Storage};
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
class SchoolExpensesTest extends TestCase {
 use RefreshDatabase;
 protected function setUp():void {parent::setUp();app(TemplateImporter::class)->replace(false);$u=User::factory()->create(['school_role_id'=>SchoolRole::where('name','Administrateur')->value('id')]);$this->actingAs($u)->withSession(['school_auth_version'=>$u->auth_version]);}
 private function command($a,$v=[],$id=null){return $this->postJson('/school-api/commands',['action'=>$a,'payload'=>$v,'id'=>$id?(string)$id:null,'revision'=>DB::table('school_settings')->value('revision')]);}
 private function invoice():array {
  $supplier=$this->command('expense-supplier',['name'=>'Fournisseur test'])->assertOk()->json('recordId');
  $code=DB::table('accounting_accounts')->where('postable',true)->where('code','like','6%')->value('code');
  return ['supplier_id'=>$supplier,'year_id'=>1,'date'=>'2026-10-01','due_date'=>'2026-10-31','reference'=>'FAC-TEST','memo'=>'Fournitures','account'=>$code,'amount'=>25000];
 }
 public function test_invoice_partial_payment_posting_and_overpayment_protection():void {
  $v=$this->invoice();$id=$this->command('expense-save',$v)->assertOk()->json('recordId');$x=DB::table('school_expenses')->find($id);
  $this->assertDatabaseHas('accounting_entries',['id'=>$x->entry_id,'journal'=>'AC','status'=>'draft']);
  $this->command('expense-save',$v)->assertUnprocessable();
  $pay=['year_id'=>1,'treasury_id'=>DB::table('school_treasury_accounts')->where('name','BOA')->value('id'),'date'=>'2026-10-03','reference'=>'VIR-1','amount'=>10000];
  $this->command('expense-payment',$pay,$id)->assertUnprocessable();
  $this->command('expense-post',['reviewed'=>false],$x->entry_id)->assertUnprocessable();
  $this->command('expense-post',['reviewed'=>true],$x->entry_id)->assertOk();
  $this->command('expense-save',$v,$id)->assertUnprocessable();
  $pid=$this->command('expense-payment',$pay,$id)->assertOk()->json('recordId');$p=DB::table('school_expense_payments')->find($pid);
  $this->assertDatabaseHas('accounting_entries',['id'=>$p->entry_id,'journal'=>'BQ','status'=>'draft']);
  $this->getJson('/school-api/expenses')->assertOk()->assertJsonPath('expenses.0.paid',0)->assertJsonPath('expenses.0.pending',10000);
  $this->command('expense-payment',array_replace($pay,['amount'=>16000]),$id)->assertUnprocessable();
  $this->command('expense-post',['reviewed'=>true],$p->entry_id)->assertOk();
  $this->command('expense-payment-cancel',[],$pid)->assertUnprocessable();
  $this->command('accounting-reverse',['year_id'=>1,'date'=>'2026-10-04'],$p->entry_id)->assertUnprocessable();
  $this->getJson('/school-api/expenses')->assertOk()->assertJsonPath('expenses.0.paid',10000)->assertJsonPath('expenses.0.balance',15000);
  $pay['amount']=15000;$pay['treasury_id']=DB::table('school_treasury_accounts')->where('name','Wave')->value('id');
  $pid=$this->command('expense-payment',$pay,$id)->assertOk()->json('recordId');$p=DB::table('school_expense_payments')->find($pid);
  $this->assertDatabaseHas('accounting_entries',['id'=>$p->entry_id,'journal'=>'MW']);
  $this->command('expense-payment-cancel',[],$pid)->assertOk();
  $this->getJson('/school-api/expenses')->assertOk()->assertJsonPath('expenses.0.available',15000);
 }
 public function test_edit_draft_link_integrity_documents_and_permissions():void {
  Storage::fake('local');$v=$this->invoice();$id=$this->command('expense-save',$v)->assertOk()->json('recordId');$entry=DB::table('school_expenses')->find($id)->entry_id;
  $v['amount']=30000;$this->command('expense-save',$v,$id)->assertOk();$this->assertSame(30000,(int)DB::table('accounting_lines')->where('entry_id',$entry)->sum('credit'));
  $this->command('accounting-entry',[],$entry)->assertUnprocessable();
  $response=$this->post('/school-api/expenses/'.$id.'/documents',['document'=>UploadedFile::fake()->create('facture.pdf',20,'application/pdf')],['Accept'=>'application/json'])->assertCreated();$doc=$response->json('id');
  $this->get('/school-api/expense-documents/'.$doc)->assertOk()->assertDownload('facture.pdf');
  $this->post('/school-api/expenses/'.$id.'/documents',['document'=>UploadedFile::fake()->create('script.html',5,'text/html')],['Accept'=>'application/json'])->assertUnprocessable();
  $u=User::factory()->create(['school_role_id'=>SchoolRole::where('name','Secrétariat')->value('id')]);$this->actingAs($u)->withSession(['school_auth_version'=>$u->auth_version]);
  $this->getJson('/school-api/expenses')->assertForbidden();$this->command('expense-save',$v)->assertForbidden();$this->get('/school-api/expense-documents/'.$doc)->assertForbidden();
 }
}
