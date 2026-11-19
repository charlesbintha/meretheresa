<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB,Hash,Password};
use Illuminate\Support\Str;
class SchoolPasswordSetupController extends Controller {
 private function headers($response){return $response->header('Cache-Control','no-store, private')->header('Referrer-Policy','no-referrer')->header('X-Robots-Tag','noindex, nofollow');}
 public function show(Request $r,string $token){
  $email=(string)$r->query('email','');$user=User::where('email',$email)->first();
  $valid=$user&&$user->is_active&&$user->password_setup_required&&Password::broker()->tokenExists($user,$token);
  return $this->headers(response()->view('school.password-setup',compact('email','token','valid'),$valid?200:410));
 }
 public function store(Request $r){
  $v=$r->validate(['email'=>'required|email','token'=>'required|string|max:255','password'=>'required|string|min:12|max:72|confirmed','password_confirmation'=>'required|string']);
  if(strlen($v['password'])>72)return back()->withErrors(['password'=>'Le mot de passe ne doit pas dépasser 72 octets.']);
  $status=DB::transaction(function()use($v){
   $user=User::where('email',$v['email'])->lockForUpdate()->first();
   if(!$user||!$user->is_active||!$user->password_setup_required)return Password::INVALID_TOKEN;
   return Password::broker()->reset($v,function(User $u,string $password){
    $u->password=Hash::make($password);$u->password_setup_required=false;$u->remember_token=Str::random(60);$u->auth_version++;$u->save();
    DB::table('sessions')->where('user_id',$u->id)->delete();
    DB::table('school_audit_logs')->insert(['user_id'=>$u->id,'action'=>'password-setup','record_id'=>(string)$u->id,'created_at'=>now(),'updated_at'=>now()]);
   });
  });
  if($status!==Password::PASSWORD_RESET)return $this->headers(response()->view('school.password-setup',['valid'=>false,'email'=>'','token'=>''],410));
  return redirect()->route('login')->with('status','Votre mot de passe est défini. Vous pouvez maintenant vous connecter.');
 }
}
