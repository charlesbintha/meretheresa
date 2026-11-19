<?php
namespace App\Services;
use App\Mail\SchoolWelcome;
use App\Models\User;
use Illuminate\Support\Facades\{DB,Mail,Log,Password};
class SchoolWelcomeEmail {
 public function send(int $id):array {
  $user=User::with('schoolRole')->findOrFail($id);
  if(!$user->is_active)return ['status'=>'skipped','message'=>'Compte désactivé : aucun email envoyé.'];
  try {
   if(in_array(config('mail.default'),['log','array'],true))throw new \RuntimeException('Mail delivery not configured');
   config(['mail.mailers.smtp.timeout'=>20]);
   $url=rtrim(config('app.url'),'/').'/login';
   $setupUrl=null;
   if($user->password_setup_required){
    $token=Password::broker()->createToken($user);
    $setupUrl=rtrim(config('app.url'),'/').'/definir-mot-de-passe/'.rawurlencode($token).'?'.http_build_query(['email'=>$user->email]);
   }
   Mail::to($user->email)->send(new SchoolWelcome($user->name,$user->email,$user->schoolRole?->name??'Équipe scolaire',$url,false,$setupUrl));
   DB::table('users')->where('id',$id)->update(['welcome_email_status'=>'sent','welcome_email_sent_at'=>now()]);
   return ['status'=>'sent','message'=>'Compte enregistré. Email de bienvenue transmis au serveur de messagerie.'];
  }catch(\Throwable $e){
   DB::table('users')->where('id',$id)->update(['welcome_email_status'=>'failed']);
   Log::warning('Welcome email failed',['user_id'=>$id,'exception_type'=>get_class($e)]);
   return ['status'=>'failed','message'=>'Compte enregistré, mais l’email de bienvenue n’a pas pu être envoyé. Utilisez « Renvoyer l’email ».'];
  }
 }
}
