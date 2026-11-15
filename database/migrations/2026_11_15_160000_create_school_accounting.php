<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{Schema,DB};
return new class extends Migration {
 public function up(): void {
  Schema::create('accounting_accounts',function(Blueprint $t){$t->string('code',20)->primary();$t->string('name',255);$t->boolean('postable');$t->boolean('active')->default(true);});
  Schema::create('accounting_years',function(Blueprint $t){$t->id();$t->string('name')->unique();$t->date('start');$t->date('end');$t->boolean('closed')->default(false);});
  Schema::create('accounting_journals',function(Blueprint $t){$t->string('code',10)->primary();$t->string('name');});
  Schema::create('accounting_entries',function(Blueprint $t){$t->id();$t->foreignId('year_id')->constrained('accounting_years');$t->string('journal',10);$t->foreign('journal')->references('code')->on('accounting_journals');$t->date('date')->nullable();$t->string('reference')->nullable();$t->text('memo');$t->string('status')->default('draft');$t->string('number')->nullable()->unique();$t->string('source_key')->nullable()->unique();$t->string('source_hash',64)->nullable();$t->boolean('reviewed')->default(false);$t->unsignedBigInteger('reversal_of')->nullable()->unique();$t->foreign('reversal_of')->references('id')->on('accounting_entries');$t->foreignId('created_by')->nullable()->constrained('users');$t->foreignId('posted_by')->nullable()->constrained('users');$t->timestamp('posted_at')->nullable();$t->timestamps();});
  Schema::create('accounting_lines',function(Blueprint $t){$t->id();$t->foreignId('entry_id')->constrained('accounting_entries')->cascadeOnDelete();$t->string('account',20)->nullable();$t->foreign('account')->references('code')->on('accounting_accounts');$t->string('label')->default('');$t->string('auxiliary')->nullable();$t->unsignedBigInteger('debit')->default(0);$t->unsignedBigInteger('credit')->default(0);});
  $accounts=json_decode(file_get_contents(database_path('data/syscohada.json')),true);$codes=array_map('strval',array_keys($accounts));
  foreach($accounts as $code=>$name){$code=(string)$code;$leaf=!collect($codes)->contains(fn($c)=>$c!==$code&&str_starts_with($c,$code));DB::table('accounting_accounts')->insert(['code'=>$code,'name'=>$name,'postable'=>$leaf&&strlen($code)>=3&&$code[0]!=='9']);}
  foreach(['AN'=>'À nouveaux','AC'=>'Achats','VE'=>'Ventes et prestations','CA'=>'Caisse','BQ'=>'Banque','MM'=>'Monnaie électronique','OD'=>'Opérations diverses'] as $code=>$name)DB::table('accounting_journals')->insert(compact('code','name'));
  DB::table('accounting_years')->insert(['name'=>'2026','start'=>'2026-01-01','end'=>'2026-12-31']);
  foreach(DB::table('school_roles')->whereIn('name',['Comptabilité','Direction'])->get() as $role){$p=json_decode($role->permissions,true)?:[];$p[]='accounting.view';if($role->name==='Comptabilité')$p=array_merge($p,['accounting.manage','accounting.post']);DB::table('school_roles')->where('id',$role->id)->update(['permissions'=>json_encode(array_values(array_unique($p)))]);}
 }
 public function down():void {foreach(['accounting_lines','accounting_entries','accounting_journals','accounting_years','accounting_accounts'] as $t)Schema::dropIfExists($t);}
};
