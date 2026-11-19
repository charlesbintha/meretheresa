<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{Schema,DB};
return new class extends Migration {
 public function up():void {
  Schema::create('school_treasury_accounts',function(Blueprint $t){
   $t->id();$t->string('name');$t->string('kind');$t->string('journal',10)->unique();$t->foreign('journal')->references('code')->on('accounting_journals');
   $t->string('account',20);$t->foreign('account')->references('code')->on('accounting_accounts');
   $t->string('holder')->nullable();$t->string('account_number')->nullable();$t->string('iban')->nullable();$t->string('bic')->nullable();$t->string('phone')->nullable();$t->timestamps();
  });
  foreach(['BQ'=>'BOA','CA'=>'Caisse principale'] as $code=>$name)DB::table('accounting_journals')->where('code',$code)->update(['name'=>$name]);
  foreach(['MW'=>'Wave','MO'=>'Orange Money'] as $code=>$name)DB::table('accounting_journals')->insertOrIgnore(['code'=>$code,'name'=>$name]);
  foreach(['5521'=>'Wave','5522'=>'Orange Money'] as $code=>$name)DB::table('accounting_accounts')->insertOrIgnore(['code'=>$code,'name'=>$name,'postable'=>true,'active'=>true]);
  foreach([['BOA','bank','BQ','5211'],['Caisse principale','cash','CA','5711'],['Wave','mobile','MW','5521'],['Orange Money','mobile','MO','5522']] as [$name,$kind,$journal,$account])DB::table('school_treasury_accounts')->insert(compact('name','kind','journal','account')+['created_at'=>now(),'updated_at'=>now()]);
 }
 public function down():void {
  Schema::dropIfExists('school_treasury_accounts');
  // Preserve journals and ledger accounts: historical entries may reference them.
 }
};
