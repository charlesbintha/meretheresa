<?php
namespace App\Services;
use Illuminate\Support\Facades\{DB,Validator};
use App\Models\User;
class SchoolAccounting {
 public function state(int $year):array {
  $years=DB::table('accounting_years')->orderByDesc('start')->get();$year=$year?:($years->first()->id??0);
  $entries=DB::table('accounting_entries')->where('year_id',$year)->orderByDesc('id')->get();$lines=DB::table('accounting_lines')->whereIn('entry_id',$entries->pluck('id'))->get()->groupBy('entry_id');
  foreach($entries as $entry)$entry->lines=$lines[$entry->id]??[];
  return ['yearId'=>$year,'years'=>$years,'accounts'=>DB::table('accounting_accounts')->orderBy('code')->get(),'journals'=>DB::table('accounting_journals')->get(),'entries'=>$entries,'treasury'=>DB::table('school_treasury_accounts')->orderBy('id')->get()];
 }
 public function execute(string $action,array $v,?string $id,User $actor):int {
  return match($action){'accounting-treasury'=>$this->treasury((int)$id,$v),'accounting-entry'=>$this->save($v,$id,$actor),'accounting-post'=>$this->post((int)$id,$actor),'accounting-reverse'=>$this->reverse((int)$id,$v,$actor),'accounting-prepare'=>$this->prepare((int)($v['yearId']??0),$actor),'accounting-year'=>$this->year($v),'accounting-close'=>$this->close((int)$id),'accounting-account'=>$this->account($v),default=>abort(404)};
 }
 private function treasury(int $id,array $v):int {
  abort_unless(DB::table('school_treasury_accounts')->where('id',$id)->exists(),404);
  $v=Validator::make($v,['holder'=>'nullable|string|max:255','account_number'=>'nullable|string|max:255','iban'=>'nullable|string|max:255','bic'=>'nullable|string|max:255','phone'=>'nullable|string|max:255'])->validate();
  DB::table('school_treasury_accounts')->where('id',$id)->update($v+['updated_at'=>now()]);return $id;
 }
 private function year(array $v):int {
  $v=Validator::make($v,['name'=>'required|string|max:50|unique:accounting_years,name','start'=>'required|date_format:Y-m-d','end'=>'required|date_format:Y-m-d|after_or_equal:start'])->validate();
  abort_if(DB::table('accounting_years')->where('start','<=',$v['end'])->where('end','>=',$v['start'])->exists(),422,'Les exercices ne peuvent pas se chevaucher.');return DB::table('accounting_years')->insertGetId($v);
 }
 private function close(int $id):int {
  $y=DB::table('accounting_years')->find($id);abort_unless($y,404);abort_if($y->closed,422,'Exercice déjà clôturé.');
  abort_if(DB::table('accounting_entries')->where('year_id',$id)->where('status','draft')->exists(),422,'Vérifiez tous les brouillons avant de clôturer.');
  DB::table('accounting_years')->where('id',$id)->update(['closed'=>true]);return $id;
 }
 private function account(array $v):int {
  $v=Validator::make($v,['code'=>'required|regex:/^[1-8][0-9]{3,11}$/|unique:accounting_accounts,code','name'=>'required|string|max:255','parent'=>'required|exists:accounting_accounts,code'])->validate();
  abort_unless(str_starts_with($v['code'],$v['parent'])&&strlen($v['code'])>strlen($v['parent']),422,'Le numéro doit prolonger le compte parent.');
  abort_if(DB::table('accounting_lines')->where('account',$v['parent'])->exists(),422,'Ce compte est déjà utilisé. Créez un compte frère plutôt que de subdiviser un compte utilisé.');
  abort_if(DB::table('accounting_accounts')->where('code','like',$v['code'].'%')->exists(),422,'Ce numéro contient déjà des sous-comptes.');
  DB::table('accounting_accounts')->where('code',$v['parent'])->update(['postable'=>false]);DB::table('accounting_accounts')->insert(['code'=>$v['code'],'name'=>$v['name'],'postable'=>true]);return 0;
 }
 private function openYear(int $id):object {$y=DB::table('accounting_years')->where('id',$id)->lockForUpdate()->first();abort_unless($y,422,'Exercice inconnu.');abort_if($y->closed,422,'Cet exercice est clôturé.');return $y;}
 public function saveExpenseEntry(array $v,?int $id,User $actor):int {return $this->save($v,$id?(string)$id:null,$actor,true);}
 private function expenseLinked(int $id):bool {return DB::table('school_expenses')->where('entry_id',$id)->exists()||DB::table('school_expense_payments')->where('entry_id',$id)->exists();}
 private function save(array $v,?string $id,User $actor,bool $expense=false):int {
  abort_if($id&&!$expense&&$this->expenseLinked((int)$id),422,'Modifiez cette écriture depuis Dépenses et fournisseurs.');
  $v=Validator::make($v,['year_id'=>'required|integer|exists:accounting_years,id','journal'=>'required|exists:accounting_journals,code','date'=>'nullable|date_format:Y-m-d','reference'=>'nullable|string|max:255','memo'=>'required|string|max:2000','reviewed'=>'boolean','lines'=>'required|array|min:2|max:100','lines.*.account'=>'nullable|exists:accounting_accounts,code','lines.*.label'=>'nullable|string|max:255','lines.*.auxiliary'=>'nullable|string|max:255','lines.*.debit'=>'required|integer|min:0|max:999999999999','lines.*.credit'=>'required|integer|min:0|max:999999999999'])->validate();
  $old=$id?DB::table('accounting_entries')->where('id',$id)->lockForUpdate()->first():null;
  abort_if($id&&!$old,404);abort_if($old&&$old->status!=='draft',422,'Une écriture validée ne peut plus être modifiée.');
  if($old)$this->openYear($old->year_id);$y=$this->openYear($v['year_id']);abort_if(!empty($v['date'])&&($v['date']<$y->start||$v['date']>$y->end),422,'Date hors exercice.');
  if($old?->source_key){$source=$this->source($old->source_key);abort_unless($source&&$old->source_hash===$this->fingerprint($source),422,'L’encaissement source a changé. Relancez la préparation des brouillons.');}
  $lines=$v['lines'];unset($v['lines']);$v['date']=$v['date']?:null;$v['reviewed']=$v['reviewed']??false;$v['updated_at']=now();
  if($id)DB::table('accounting_entries')->where('id',$id)->update($v);else $id=DB::table('accounting_entries')->insertGetId($v+['created_by'=>$actor->id,'created_at'=>now()]);
  DB::table('accounting_lines')->where('entry_id',$id)->delete();foreach($lines as $l)DB::table('accounting_lines')->insert(['entry_id'=>$id,'account'=>$l['account']?:null,'label'=>$l['label']??'','auxiliary'=>$l['auxiliary']??null,'debit'=>$l['debit'],'credit'=>$l['credit']]);return (int)$id;
 }
 private function post(int $id,User $actor):int {
  $e=DB::table('accounting_entries')->where('id',$id)->lockForUpdate()->first();abort_unless($e,404);abort_if($e->status!=='draft',422,'Écriture déjà validée.');$y=$this->openYear($e->year_id);
  abort_unless($e->date&&$e->date>=$y->start&&$e->date<=$y->end&&trim($e->reference??'')!==''&&$e->reviewed,422,'Vérifiez l’écriture, la date et la référence avant validation.');
  $lines=DB::table('accounting_lines')->where('entry_id',$id)->get();abort_unless($lines->count()>=2&&$lines->sum('debit')>0&&$lines->sum('debit')===$lines->sum('credit'),422,'Les débits et crédits doivent être égaux et strictement positifs.');
  foreach($lines as $l){abort_unless(($l->debit>0 xor $l->credit>0)&&DB::table('accounting_accounts')->where('code',$l->account)->where('active',true)->where('postable',true)->exists(),422,'Chaque ligne doit avoir un compte imputable et un montant sur un seul côté.');}
  if($e->source_key){$source=$this->source($e->source_key);abort_unless($source&&$e->source_hash===$this->fingerprint($source),422,'L’encaissement a été modifié : repréparez ce brouillon.');abort_unless($lines->sum('debit')===$source->amount,422,'Le total doit correspondre à l’encaissement source.');}
  $number=$y->name.'-'.$e->journal.'-'.str_pad((string)$id,6,'0',STR_PAD_LEFT);
  DB::table('accounting_entries')->where('id',$id)->update(['status'=>'posted','number'=>$number,'posted_by'=>$actor->id,'posted_at'=>now(),'updated_at'=>now()]);return $id;
 }
 private function reverse(int $id,array $v,User $actor):int {
  abort_if($this->expenseLinked($id),422,'Cette écriture est liée à une dépense. La contrepassation liée aux dépenses doit être traitée avec le comptable.');
  $e=DB::table('accounting_entries')->find($id);abort_unless($e&&$e->status==='posted',422,'Choisissez une écriture validée.');abort_if(DB::table('accounting_entries')->where('reversal_of',$id)->exists(),422,'Une contrepassation existe déjà.');
  $lines=DB::table('accounting_lines')->where('entry_id',$id)->get()->map(fn($l)=>['account'=>$l->account,'label'=>$l->label,'auxiliary'=>$l->auxiliary,'debit'=>$l->credit,'credit'=>$l->debit])->all();
  $new=$this->save(['year_id'=>$v['year_id']??$e->year_id,'journal'=>'OD','date'=>$v['date']??null,'reference'=>'EXT-'.$e->number,'memo'=>'Contrepassation '.$e->number.' · '.$e->memo,'lines'=>$lines],null,$actor);DB::table('accounting_entries')->where('id',$new)->update(['reversal_of'=>$id]);return $new;
 }
 private function source(string $key):?object {[$type,$id]=explode(':',$key);return in_array($type,['school_receipts','school_staff_receipts'],true)?DB::table($type)->find($id):null;}
 private function fingerprint(object $r):string {return hash('sha256',json_encode([$r->charge_id,(int)$r->amount,$r->paid_at,$r->reference,$r->method??null]));}
 public function prepare(int $year,User $actor):int {
  $y=$this->openYear($year);$n=0;
  foreach(['school_receipts','school_staff_receipts'] as $table)foreach(DB::table($table)->orderBy('id')->get() as $r){
   if($r->paid_at&&($r->paid_at<$y->start||$r->paid_at>$y->end))continue;
   $charge=DB::table($table==='school_receipts'?'school_charges':'school_staff_charges')->find($r->charge_id);
   if($table==='school_staff_receipts'){$membership=DB::table('school_staff_canteen')->find($charge->membership_id);$charge->academic_year_id=$membership->academic_year_id;$charge->staff_id=$membership->staff_id;}
   if(!$r->paid_at){$schoolYear=DB::table('academic_years')->find($charge->academic_year_id);if(substr($schoolYear->start_date,0,4)!==substr($y->start,0,4))continue;}
   $key=$table.':'.$r->id;$hash=$this->fingerprint($r);$old=DB::table('accounting_entries')->where('source_key',$key)->first();
   if($old&&($old->status==='posted'||$old->source_hash===$hash))continue;
   if($old)$this->openYear($old->year_id);
   $method=mb_strtolower(trim($r->method??''));$cash=in_array($method,['espèces','especes','cash'],true)?'5711':(in_array($method,['virement','virement bancaire','bank_transfer'],true)?'5211':(match($method){'wave'=>'5521','orange money'=>'5522','mobile money','mobile_money'=>'552',default=>null}));
   $memo='Encaissement à vérifier · '.$key.' · '.($r->label??'Cantine personnel').' · Vérifier la créance ou l’à-nouveau correspondant.';
   $fields=['year_id'=>$year,'journal'=>$cash==='5711'?'CA':($cash==='5211'?'BQ':(match($cash){'5521'=>'MW','5522'=>'MO','552'=>'MM',default=>'OD'})),'date'=>$r->paid_at,'reference'=>$r->reference,'memo'=>$memo,'source_hash'=>$hash,'reviewed'=>false,'updated_at'=>now()];
   if($old){$id=$old->id;DB::table('accounting_entries')->where('id',$id)->update($fields);DB::table('accounting_lines')->where('entry_id',$id)->delete();}else $id=DB::table('accounting_entries')->insertGetId($fields+['source_key'=>$key,'created_by'=>$actor->id,'created_at'=>now()]);
   $aux=$table==='school_receipts'?DB::table('students')->where('id',$charge->student_id)->value('matricule'):'PERSONNEL-'.$charge->staff_id;
   foreach([[$cash,$r->amount,0],['411101',0,$r->amount]] as [$account,$debit,$credit])DB::table('accounting_lines')->insert(['entry_id'=>$id,'account'=>$account,'debit'=>$debit,'credit'=>$credit,'auxiliary'=>$aux,'label'=>'Encaissement source '.$r->id]);$n++;
  }return $n;
 }
}
