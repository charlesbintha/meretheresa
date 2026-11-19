<?php
namespace Tests\Feature;
use App\Models\{User,SchoolRole};
use App\Mail\SchoolWelcome;
use App\Services\TemplateImporter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{DB,Mail};
use Tests\TestCase;
class SchoolWelcomeEmailTest extends TestCase {
 use RefreshDatabase;
 protected function setUp():void {parent::setUp();app(TemplateImporter::class)->replace(false);$u=User::factory()->create(['school_role_id'=>SchoolRole::where('name','Administrateur')->value('id')]);$this->actingAs($u)->withSession(['school_auth_version'=>$u->auth_version]);config(['mail.default'=>'smtp','app.url'=>'https://app.lesbambinos.sn']);}
 private function command($action,$payload=[],$id=null){return $this->postJson('/school-api/commands',['action'=>$action,'payload'=>$payload,'id'=>$id?(string)$id:null,'revision'=>DB::table('school_settings')->value('revision')]);}
 private function values():array{return ['name'=>'Awa Test','email'=>'awa@example.test','roleId'=>SchoolRole::where('name','Comptabilité')->value('id'),'password'=>'Private-password-2026','password_confirmation'=>'Private-password-2026'];}
 public function test_creation_sends_personalized_welcome_without_password_and_edit_does_not():void {
  Mail::fake();$v=$this->values();$id=$this->command('account',$v)->assertOk()->assertJsonPath('welcomeEmail.status','sent')->json('recordId');
  Mail::assertSent(SchoolWelcome::class,function($m){return $m->hasTo('awa@example.test')&&$m->displayName==='Awa Test'&&$m->roleName==='Comptabilité'&&$m->loginUrl==='https://app.lesbambinos.sn/login';});
  $this->assertDatabaseHas('users',['id'=>$id,'welcome_email_status'=>'sent']);
  $mail=new SchoolWelcome('Awa <test>','awa@example.test','Comptabilité','https://app.lesbambinos.sn/login');$html=$mail->render();$this->assertStringContainsString('Accéder à mon espace',$html);$this->assertStringContainsString('Awa &lt;test&gt;',$html);$this->assertStringNotContainsString($v['password'],$html);
  $preview=new SchoolWelcome('Charles','charles@example.test','Aperçu','https://app.lesbambinos.sn/login',true);$this->assertStringContainsString('Aucun compte supplémentaire',$preview->render());$this->assertStringContainsString('[TEST]',$preview->envelope()->subject);
  unset($v['password'],$v['password_confirmation']);$this->command('account',$v,$id)->assertOk();Mail::assertSentCount(1);
  $this->command('account-welcome',[],$id)->assertOk();Mail::assertSentCount(2);
 }
 public function test_transport_failure_preserves_account_and_allows_retry():void {
  Mail::shouldReceive('to')->once()->andThrow(new \RuntimeException('SMTP unavailable'));
  $id=$this->command('account',$this->values())->assertOk()->assertJsonPath('welcomeEmail.status','failed')->json('recordId');
  $this->assertDatabaseHas('users',['id'=>$id,'welcome_email_status'=>'failed']);Mail::fake();$this->command('account-welcome',[],$id)->assertOk()->assertJsonPath('welcomeEmail.status','sent');
  $u=User::factory()->create(['school_role_id'=>SchoolRole::where('name','Secrétariat')->value('id')]);$this->actingAs($u)->withSession(['school_auth_version'=>$u->auth_version]);$this->command('account-welcome',[],$id)->assertForbidden();Mail::assertSentCount(1);
 }
 public function test_invalid_creation_and_inactive_account_do_not_send():void {
  Mail::fake();$v=$this->values();$v['password_confirmation']='incorrect';$this->command('account',$v)->assertUnprocessable();Mail::assertNothingSent();
  $u=User::factory()->create(['is_active'=>false]);$this->command('account-welcome',[],$u->id)->assertOk()->assertJsonPath('welcomeEmail.status','skipped');Mail::assertNothingSent();
 }
}
