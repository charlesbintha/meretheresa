<?php
namespace Tests\Feature;
use App\Models\User;
use App\Services\SchoolWorkbookImporter;
use App\Services\SchoolWorkbookCorrections;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
class SchoolCorrectionsTest extends TestCase {
    use RefreshDatabase;
    private function student(int $order): array{return ['order'=>$order,'class'=>'CE1','firstName'=>'Prénom '.$order,'lastName'=>'Test','date'=>null,'rawDate'=>null,'sourceRegistrationBalance'=>0,'receipts'=>[],'subscriptions'=>[]];}
    private function seedImport(): void {app(SchoolWorkbookImporter::class)->import(['format'=>1,'year'=>'2026-2027','sourceHash'=>str_repeat('a',64),'students'=>[$this->student(1)],'excluded'=>[],'corrections'=>[]]);}
    private function correctionManifest(): array {
        $service=$this->student(1);$service['subscriptions']=[['kind'=>'transport','zone'=>null,'trip'=>'round_trip','abandoned'=>true]];
        $service['receipts']=[['kind'=>'transport','month'=>'2026-10','amount'=>13000,'date'=>null,'reference'=>null,'rawDate'=>null,'source'=>'TRANSPORT!I2','label'=>'Transport']];
        return ['format'=>2,'year'=>'2026-2027','sourceHash'=>str_repeat('a',64),'correctionHash'=>str_repeat('b',64),'students'=>[$this->student(957),$this->student(678)],'services'=>[$service],'staff'=>[['firstName'=>'Agent','lastName'=>'Cantine','role'=>'Administration','source'=>'CANTINE!C561','monthlyFee'=>6000]],'decisions'=>[['sheet'=>'CLASSE','row'=>144,'order'=>957]]];
    }
    private function command($action,$v,$id=null){return $this->postJson('/school-api/commands',['action'=>$action,'payload'=>$v,'id'=>$id?(string)$id:null,'revision'=>(int)DB::table('school_settings')->value('revision')]);}
    public function test_patch_is_additive_idempotent_and_keeps_abandoned_october_without_future_debt(): void {
        $this->seedImport();$c=DB::table('school_charges')->where('kind','tuition')->first();DB::table('school_receipts')->insert(['charge_id'=>$c->id,'amount'=>777,'reference'=>'USER-EDIT','label'=>'Manuel']);
        $r=app(SchoolWorkbookCorrections::class)->apply($this->correctionManifest());$this->assertSame(2,$r['students']);$this->assertSame(13000,$r['received']);
        $this->assertDatabaseHas('school_receipts',['amount'=>777,'reference'=>'USER-EDIT']);$this->assertDatabaseHas('students',['matricule'=>'MAT-678']);$this->assertDatabaseHas('students',['matricule'=>'MAT-957']);
        $this->assertDatabaseHas('school_service_memberships',['active'=>false,'abandoned'=>true,'zone'=>null,'monthly_fee'=>null]);
        $this->assertSame(0,DB::table('school_charges')->where('kind','transport')->where('month','>','2026-10')->count());
        $this->assertDatabaseHas('school_charges',['kind'=>'transport','month'=>'2026-10','amount'=>13000,'tariff_pending'=>true]);
        $this->assertTrue(app(SchoolWorkbookCorrections::class)->apply($this->correctionManifest())['alreadyApplied']);$this->assertDatabaseCount('students',3);$this->assertDatabaseCount('school_receipts',2);
        $this->assertDatabaseCount('school_staff',1);$this->assertDatabaseCount('school_staff_charges',7);$this->assertSame(42000,(int)DB::table('school_staff_charges')->sum('amount'));$this->assertDatabaseCount('school_staff_receipts',0);
        $this->actingAs(User::factory()->create(['is_school_admin'=>true]));$sid=DB::table('students')->where('matricule','MAT-1')->value('id');
        $this->command('billing-membership',['studentId'=>$sid,'kind'=>'transport','active'=>0,'zone'=>'ZONE 3','trip'=>'round_trip'])->assertOk();
        $this->assertDatabaseHas('school_charges',['kind'=>'transport','month'=>'2026-10','tariff_pending'=>false,'amount'=>13000]);
        $this->assertSame(0,DB::table('school_charges')->where('kind','transport')->where('month','>','2026-10')->count());
    }
    public function test_conflict_rolls_back_all_new_records(): void {
        $this->seedImport();$d=$this->correctionManifest();$d['services'][0]['firstName']='Autre identité';
        try{app(SchoolWorkbookCorrections::class)->apply($d);$this->fail('Expected conflict');}catch(\Symfony\Component\HttpKernel\Exception\HttpException $e){$this->assertSame(422,$e->getStatusCode());}
        $this->assertDatabaseCount('students',1);$this->assertDatabaseCount('school_staff',0);$this->assertDatabaseCount('school_corrections',0);
    }
    public function test_staff_permissions_receipts_and_paid_month_tariff_preservation(): void {
        $this->seedImport();app(SchoolWorkbookCorrections::class)->apply($this->correctionManifest());$u=User::factory()->create(['is_school_admin'=>true]);$this->actingAs($u);
        $sid=DB::table('school_staff')->value('id');$cid=DB::table('school_staff_charges')->value('id');$request=['chargeId'=>$cid,'amount'=>6000,'date'=>'2026-11-01','reference'=>'STAFF-1','method'=>'Wave','type'=>'Cantine personnel','requestKey'=>(string)\Illuminate\Support\Str::uuid()];
        $this->command('staff-receipt',$request)->assertOk();$this->command('staff-receipt',$request)->assertOk();$this->assertDatabaseCount('school_staff_receipts',1);$this->assertDatabaseHas('school_staff_receipts',['charge_id'=>$cid,'method'=>'Wave']);
        $this->command('staff-membership',['staffId'=>$sid,'monthlyFee'=>5000,'active'=>1])->assertOk();$this->assertDatabaseHas('school_staff_charges',['id'=>$cid,'amount'=>6000]);$this->assertSame(6,DB::table('school_staff_charges')->where('amount',5000)->count());
        $role=DB::table('school_roles')->where('name','Secrétariat')->value('id');$limited=User::factory()->create(['school_role_id'=>$role]);$this->actingAs($limited);
        $this->command('staff-receipt',$request)->assertForbidden();$this->getJson('/school-api/state')->assertOk()->assertJsonCount(0,'staffCanteen.receipts')->assertJsonCount(0,'staffCanteen.charges');
    }
}
