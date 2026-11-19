<?php
namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\{DB,Validator};
class SchoolExpenses {
 public function state():array {
  $expenses=DB::table('school_expenses as x')->join('school_suppliers as s','s.id','=','x.supplier_id')->join('accounting_entries as e','e.id','=','x.entry_id')->select('x.*','s.name as supplier','e.status')->orderByDesc('x.date')->orderByDesc('x.id')->get();
  $payments=DB::table('school_expense_payments as p')->join('accounting_entries as e','e.id','=','p.entry_id')->join('school_treasury_accounts as t','t.id','=','p.treasury_id')->select('p.*','e.status','e.year_id','t.name as treasury')->orderBy('p.id')->get();
  foreach($expenses as $x){$x->payments=$payments->where('expense_id',$x->id)->values();$x->paid=$x->payments->where('status','posted')->sum('amount');$x->pending=$x->payments->where('status','draft')->sum('amount');$x->balance=$x->amount-$x->paid;$x->available=$x->balance-$x->pending;}
  return ['expenses'=>$expenses,'suppliers'=>DB::table('school_suppliers')->orderBy('name')->get(),'documents'=>DB::table('school_expense_documents')->select('id','expense_id','name')->get(),'years'=>DB::table('accounting_years')->orderByDesc('start')->get(),'accounts'=>DB::table('accounting_accounts')->where('postable',true)->where('active',true)->where('code','like','6%')->orderBy('code')->get(),'treasury'=>DB::table('school_treasury_accounts')->get()];
 }
 public function execute(string $action,array $v,?string $id,User $actor):int {
  return match($action){'expense-post'=>$this->post((int)$id,$v,$actor),'expense-payment-cancel'=>$this->cancelPayment((int)$id),'expense-supplier'=>$this->supplier($v,$id),'expense-save'=>$this->save($v,$id,$actor),'expense-payment'=>$this->payment((int)$id,$v,$actor),default=>abort(404)};
 }
 private function post(int $id,array $v,User $actor):int {
  abort_unless(filter_var($v['reviewed']??false,FILTER_VALIDATE_BOOLEAN),422,'Confirmez la vérification de cette écriture.');
  abort_unless(DB::table('school_expenses')->where('entry_id',$id)->exists()||DB::table('school_expense_payments')->where('entry_id',$id)->exists(),404);
  $e=DB::table('accounting_entries')->where('id',$id)->lockForUpdate()->first();abort_unless($e&&$e->status==='draft',422,'Écriture déjà validée.');
  DB::table('accounting_entries')->where('id',$id)->update(['reviewed'=>true]);
  return app(SchoolAccounting::class)->execute('accounting-post',[],(string)$id,$actor);
 }
 private function cancelPayment(int $id):int {
  $p=DB::table('school_expense_payments')->where('id',$id)->lockForUpdate()->first();abort_unless($p,404);
  $e=DB::table('accounting_entries')->where('id',$p->entry_id)->lockForUpdate()->first();abort_unless($e&&$e->status==='draft',422,'Un règlement validé ne peut pas être supprimé.');
  abort_if(DB::table('accounting_years')->where('id',$e->year_id)->value('closed'),422,'Exercice clôturé.');
  DB::table('school_expense_payments')->where('id',$id)->delete();DB::table('accounting_entries')->where('id',$p->entry_id)->delete();return $id;
 }
 private function supplier(array $v,?string $id):int {
  $v=Validator::make($v,['name'=>'required|string|max:255','phone'=>'nullable|string|max:100','email'=>'nullable|email|max:255','address'=>'nullable|string|max:255'])->validate();
  if($id){abort_unless(DB::table('school_suppliers')->where('id',$id)->exists(),404);DB::table('school_suppliers')->where('id',$id)->update($v+['updated_at'=>now()]);return (int)$id;}
  return DB::table('school_suppliers')->insertGetId($v+['created_at'=>now(),'updated_at'=>now()]);
 }
 private function save(array $v,?string $id,User $actor):int {
  $v=Validator::make($v,['supplier_id'=>'required|integer|exists:school_suppliers,id','year_id'=>'required|integer|exists:accounting_years,id','date'=>'required|date_format:Y-m-d','due_date'=>'nullable|date_format:Y-m-d|after_or_equal:date','reference'=>'required|string|max:255','memo'=>'required|string|max:255','account'=>'required|string|exists:accounting_accounts,code','amount'=>'required|integer|min:1|max:999999999999'])->validate();
  abort_unless(DB::table('accounting_accounts')->where('code',$v['account'])->where('code','like','6%')->where('active',true)->where('postable',true)->exists(),422,'Choisissez un compte de charges imputable.');
  $old=$id?DB::table('school_expenses')->where('id',$id)->lockForUpdate()->first():null;abort_if($id&&!$old,404);
  abort_if(DB::table('school_expenses')->where('supplier_id',$v['supplier_id'])->where('reference',$v['reference'])->when($id,fn($q)=>$q->where('id','!=',$id))->exists(),422,'Cette facture fournisseur est déjà enregistrée.');
  $entry=['year_id'=>$v['year_id'],'journal'=>'AC','date'=>$v['date'],'reference'=>$v['reference'],'memo'=>$v['memo'],'reviewed'=>false,'lines'=>[['account'=>$v['account'],'auxiliary'=>'FOURNISSEUR-'.$v['supplier_id'],'debit'=>$v['amount'],'credit'=>0],['account'=>'4011','auxiliary'=>'FOURNISSEUR-'.$v['supplier_id'],'debit'=>0,'credit'=>$v['amount']]]];
  $eid=app(SchoolAccounting::class)->saveExpenseEntry($entry,$old?->entry_id,$actor);
  $v['entry_id']=$eid;$v['updated_at']=now();
  if($old){DB::table('school_expenses')->where('id',$id)->update($v);return (int)$id;}
  return DB::table('school_expenses')->insertGetId($v+['created_at'=>now()]);
 }
 private function payment(int $id,array $v,User $actor):int {
  $v=Validator::make($v,['treasury_id'=>'required|integer|exists:school_treasury_accounts,id','year_id'=>'required|integer|exists:accounting_years,id','date'=>'required|date_format:Y-m-d','reference'=>'required|string|max:255','amount'=>'required|integer|min:1|max:999999999999'])->validate();
  $x=DB::table('school_expenses')->where('id',$id)->lockForUpdate()->first();abort_unless($x,404);
  abort_unless(DB::table('accounting_entries')->where('id',$x->entry_id)->where('status','posted')->exists(),422,'Validez la facture avant de préparer son règlement.');
  abort_if($v['date']<$x->date,422,'Le règlement ne peut pas précéder la facture.');
  $used=DB::table('school_expense_payments')->where('expense_id',$id)->sum('amount');abort_if($v['amount']>$x->amount-$used,422,'Le montant dépasse le reste disponible, règlements en attente compris.');
  $t=DB::table('school_treasury_accounts')->find($v['treasury_id']);
  $eid=app(SchoolAccounting::class)->saveExpenseEntry(['year_id'=>$v['year_id'],'journal'=>$t->journal,'date'=>$v['date'],'reference'=>$v['reference'],'memo'=>'Règlement '.$x->reference.' · '.$x->memo,'reviewed'=>false,'lines'=>[['account'=>'4011','auxiliary'=>'FOURNISSEUR-'.$x->supplier_id,'debit'=>$v['amount'],'credit'=>0],['account'=>$t->account,'auxiliary'=>'FOURNISSEUR-'.$x->supplier_id,'debit'=>0,'credit'=>$v['amount']]]],null,$actor);
  unset($v['year_id']);return DB::table('school_expense_payments')->insertGetId($v+['expense_id'=>$id,'entry_id'=>$eid,'created_at'=>now(),'updated_at'=>now()]);
 }
}
