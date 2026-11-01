<?php
namespace Tests\Feature;
use App\Models\User;
use App\Services\SchoolBilling;
use App\Services\SchoolWorkbookImporter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
class SchoolWorkbookTest extends TestCase {
    use RefreshDatabase;
    private function manifest(): array {return ['format'=>1,'year'=>'2026-2027','sourceHash'=>str_repeat('a',64),'excluded'=>[],'corrections'=>[],'students'=>[['order'=>1,'class'=>'CM1','firstName'=>'Élève','lastName'=>'Test','date'=>null,'rawDate'=>'2023-09-10','sourceRegistrationBalance'=>0,'subscriptions'=>[['kind'=>'transport','zone'=>'ZONE 1','trip'=>'round_trip']],'receipts'=>[['kind'=>'tuition','month'=>'2026-10','amount'=>7500,'date'=>null,'rawDate'=>null,'reference'=>null,'label'=>'Scolarité octobre','source'=>'CLASSE!I2']]]]];}
    private function admin(): User {$u=User::factory()->create();$u->forceFill(['is_school_admin'=>true])->save();$this->actingAs($u);return $u;}
    private function command($action,$payload,$id=null){return $this->postJson('/school-api/commands',['action'=>$action,'payload'=>$payload,'id'=>$id?(string)$id:null,'revision'=>(int)DB::table('school_settings')->value('revision')]);}
    public function test_import_preserves_years_and_amounts_is_idempotent_and_does_not_invent_personal_data(): void {
        DB::table('academic_years')->insert(['year_name'=>'2025-2026','start_date'=>'2025-10-01','end_date'=>'2026-06-30','is_current'=>true]);
        $data=$this->manifest();$result=app(SchoolWorkbookImporter::class)->import($data);
        $this->assertDatabaseCount('academic_years',2);$this->assertDatabaseHas('students',['matricule'=>'MAT-1','date_of_birth'=>null,'gender'=>null]);
        $this->assertDatabaseCount('school_receipts',1);$this->assertDatabaseHas('school_receipts',['amount'=>7500,'paid_at'=>null,'reference'=>null]);
        $this->assertSame(7,DB::table('school_charges')->where('kind','studies')->count());
        $this->assertDatabaseMissing('school_charges',['kind'=>'studies','month'=>'2027-06']);
        $this->assertDatabaseHas('school_charges',['kind'=>'tuition','month'=>'2027-02','amount'=>15000]);
        $this->assertDatabaseHas('school_charges',['kind'=>'transport_adhesion','amount'=>2500]);
        $this->assertTrue(app(SchoolWorkbookImporter::class)->import($data)['alreadyImported']);$this->assertDatabaseCount('students',1);
    }
    public function test_pre_school_has_no_studies_and_excluded_matricule_cannot_be_imported(): void {
        $data=$this->manifest();$data['students'][0]['class']='MS';app(SchoolWorkbookImporter::class)->import($data);
        $this->assertSame(0,DB::table('school_charges')->where('kind','studies')->count());
        $data['students'][0]['order']=678;$this->expectException(\Illuminate\Validation\ValidationException::class);app(SchoolWorkbookImporter::class)->import($data);
    }
    public function test_receipt_correction_waiver_and_permissions(): void {
        app(SchoolWorkbookImporter::class)->import($this->manifest());$this->admin();$c=DB::table('school_charges')->where('kind','tuition')->where('month','2026-10')->first();$r=DB::table('school_receipts')->first();
        $this->command('billing-receipt',['chargeId'=>$c->id,'amount'=>7500,'date'=>'2026-10-02','reference'=>'RECU-1','label'=>'Scolarité','requestKey'=>(string)\Illuminate\Support\Str::uuid()],$r->id)->assertOk();
        $this->assertDatabaseCount('school_receipts',1);$this->assertDatabaseHas('school_receipts',['reference'=>'RECU-1']);
        $this->command('billing-waiver',['amount'=>7500,'reason'=>'Exonération validée'],$c->id)->assertOk();
        $this->command('billing-waiver',['amount'=>16000,'reason'=>'Trop'],$c->id)->assertUnprocessable();
        $this->command('payment',[])->assertUnprocessable();
        $role=DB::table('school_roles')->where('name','Secrétariat')->first();$u=User::factory()->create(['school_role_id'=>$role->id]);$this->actingAs($u);
        $this->command('billing-waiver',['amount'=>0,'reason'=>'Fraude'],$c->id)->assertForbidden();
        $this->getJson('/school-api/state')->assertOk()->assertJsonCount(0,'billing.receipts')->assertJsonCount(0,'billing.charges');
    }
    public function test_out_of_zone_single_trip_requires_a_manual_price(): void {
        app(SchoolWorkbookImporter::class)->import($this->manifest());$this->admin();$sid=DB::table('students')->value('id');
        $v=['studentId'=>$sid,'kind'=>'transport','active'=>true,'zone'=>'HORS ZONE','trip'=>'return'];
        $this->command('billing-membership',$v)->assertUnprocessable();
        $this->command('billing-membership',$v+['monthlyFee'=>9000])->assertOk();
        $this->assertDatabaseHas('school_service_memberships',['zone'=>'HORS ZONE','trip'=>'return','monthly_fee'=>9000]);
    }
}
