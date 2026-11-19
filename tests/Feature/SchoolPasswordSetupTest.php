<?php
namespace Tests\Feature;
use App\Models\{User,SchoolRole};
use App\Mail\SchoolWelcome;
use App\Services\{SchoolWelcomeEmail,TemplateImporter};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{DB,Hash,Mail,Password};
use Tests\TestCase;
class SchoolPasswordSetupTest extends TestCase {
 use RefreshDatabase;
 protected function setUp():void {parent::setUp();app(TemplateImporter::class)->replace(false);config(['mail.default'=>'smtp','app.url'=>'http://localhost']);Mail::fake();}
 private function pending():User {return User::factory()->create(['school_role_id'=>SchoolRole::where('name','Comptabilité')->value('id'),'password_setup_required'=>true]);}
 private function link(User $u):array {app(SchoolWelcomeEmail::class)->send($u->id);$mail=Mail::sent(SchoolWelcome::class)->last();parse_str(parse_url($mail->setupUrl,PHP_URL_QUERY),$q);return [$mail->setupUrl,basename(parse_url($mail->setupUrl,PHP_URL_PATH)),$q['email']];}
 public function test_invitation_sets_password_once_then_allows_login():void {
  $u=$this->pending();[$url,$token,$email]=$this->link($u);
  $this->assertNotSame($token,DB::table('password_reset_tokens')->where('email',$email)->value('token'));
  $this->get($url)->assertOk()->assertSee('Définir mon mot de passe')->assertHeader('Referrer-Policy','no-referrer');
  $this->post('/definir-mot-de-passe',['email'=>$email,'token'=>$token,'password'=>'Mon-secret-personnel-2026','password_confirmation'=>'Mon-secret-personnel-2026'])->assertRedirect('/login');
  $this->assertFalse((bool)$u->fresh()->password_setup_required);$this->assertTrue(Hash::check('Mon-secret-personnel-2026',$u->fresh()->password));
  $this->get($url)->assertStatus(410);
  $this->post('/definir-mot-de-passe',['email'=>$email,'token'=>$token,'password'=>'Autre-secret-2026','password_confirmation'=>'Autre-secret-2026'])->assertStatus(410);
  $this->post('/login',['email'=>$email,'password'=>'Mon-secret-personnel-2026'])->assertRedirect('/');$this->assertAuthenticatedAs($u);
 }
 public function test_resend_expiry_wrong_user_and_disabled_account():void {
  $u=$this->pending();[$url,$token,$email]=$this->link($u);[$next,$newToken]=$this->link($u);$this->get($url)->assertStatus(410);$this->get($next)->assertOk();
  $other=$this->pending();$this->post('/definir-mot-de-passe',['email'=>$other->email,'token'=>$newToken,'password'=>'Secret-personnel-2026','password_confirmation'=>'Secret-personnel-2026'])->assertStatus(410);
  $u->forceFill(['is_active'=>false])->save();$this->get($next)->assertStatus(410);$u->forceFill(['is_active'=>true])->save();
  $this->travel(61)->minutes();$this->get($next)->assertStatus(410);$this->travelBack();
 }
 public function test_password_validation_does_not_consume_link_and_existing_users_keep_access():void {
  $u=$this->pending();[$url,$token,$email]=$this->link($u);
  $this->postJson('/definir-mot-de-passe',['email'=>$email,'token'=>$token,'password'=>'short','password_confirmation'=>'short'])->assertUnprocessable();$this->get($url)->assertOk();
  $existing=User::factory()->create(['school_role_id'=>$u->school_role_id,'password'=>Hash::make('Original-secret-2026')]);app(SchoolWelcomeEmail::class)->send($existing->id);$this->assertNull(Mail::sent(SchoolWelcome::class)->last()->setupUrl);
  $this->post('/login',['email'=>$existing->email,'password'=>'Original-secret-2026'])->assertRedirect('/');
 }
}
