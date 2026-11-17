<?php
namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class SchoolStaff {
    public function membership(int $staff,int $year,int $fee): int {
        $key=['staff_id'=>$staff,'academic_year_id'=>$year];$old=DB::table('school_staff_canteen')->where($key)->first();$stamp=['updated_at'=>now()];
        if($old){DB::table('school_staff_canteen')->where('id',$old->id)->update(['monthly_fee'=>$fee,'active'=>true]+$stamp);$id=$old->id;}
        else $id=DB::table('school_staff_canteen')->insertGetId($key+['monthly_fee'=>$fee,'active'=>true,'created_at'=>now()]+$stamp);
        $start=(int)substr(DB::table('academic_years')->where('id',$year)->value('start_date'),0,4);
        for($i=11;$i<=17;$i++){
            $month=sprintf('%04d-%02d',$start+intdiv($i-1,12),($i-1)%12+1);$key=['membership_id'=>$id,'month'=>$month];$charge=DB::table('school_staff_charges')->where($key)->first();
            if(!$charge)DB::table('school_staff_charges')->insert($key+['amount'=>$fee,'created_at'=>now()]+$stamp);
            elseif(!DB::table('school_staff_receipts')->where('charge_id',$charge->id)->exists())DB::table('school_staff_charges')->where('id',$charge->id)->update(['amount'=>$fee]+$stamp);
        }
        return $id;
    }
    public function state(int $year,User $actor): array {
        $data=['people'=>[],'memberships'=>[],'charges'=>[],'receipts'=>[]];
        if(!$actor->canSchool('services.view')&&!$actor->canSchool('finance.view'))return $data;
        $data['people']=DB::table('school_staff')->orderBy('last_name')->get()->all();
        $data['memberships']=DB::table('school_staff_canteen')->where('academic_year_id',$year)->get()->all();
        if($actor->canSchool('finance.view')){
            $data['charges']=DB::table('school_staff_charges')->whereIn('membership_id',array_column($data['memberships'],'id'))->get()->all();
            $data['receipts']=DB::table('school_staff_receipts')->whereIn('charge_id',array_column($data['charges'],'id'))->get()->all();
        }
        return $data;
    }
    public function execute(string $action,array $v,?string $id,User $actor,int $year): int {
        abort_unless(app(SchoolBilling::class)->enabled($year),422,'Choisissez une année avec facturation mensuelle.');
        $stamp=['updated_at'=>now()];
        if($action==='staff-profile'){
            $v=Validator::make($v,['firstName'=>'required|string|max:100','lastName'=>'required|string|max:100','role'=>'nullable|string|max:100'])->validate();
            $values=['first_name'=>$v['firstName'],'last_name'=>$v['lastName'],'role'=>$v['role']??null]+$stamp;
            if($id){abort_unless(DB::table('school_staff')->where('id',$id)->exists(),404);DB::table('school_staff')->where('id',$id)->update($values);return (int)$id;}
            return DB::table('school_staff')->insertGetId($values+['created_at'=>now()]);
        }
        if($action==='staff-membership'){
            $v=Validator::make($v,['staffId'=>'required|integer|exists:school_staff,id','monthlyFee'=>'required|integer|min:0|max:1000000','active'=>'required|boolean'])->validate();
            if($v['active'])return $this->membership($v['staffId'],$year,$v['monthlyFee']);
            $row=DB::table('school_staff_canteen')->where(['staff_id'=>$v['staffId'],'academic_year_id'=>$year])->first()??abort(404);
            DB::table('school_staff_canteen')->where('id',$row->id)->update(['active'=>false]+$stamp);return $row->id;
        }
        if($action==='staff-receipt'){
            $v=Validator::make($v,['chargeId'=>'required|integer','amount'=>'required|integer|min:1|max:10000000','date'=>'nullable|date_format:Y-m-d|before_or_equal:today','reference'=>'nullable|string|max:191','method'=>'nullable|in:Wave,Espèces,Orange Money,Virement','type'=>'sometimes|in:Cantine personnel','requestKey'=>'required|uuid'])->validate();
            $charge=DB::table('school_staff_charges')->where('id',$v['chargeId'])->whereIn('membership_id',DB::table('school_staff_canteen')->where('academic_year_id',$year)->select('id'))->first()??abort(404);
            if($id){$old=DB::table('school_staff_receipts')->find($id)??abort(404);abort_unless($old->charge_id===$charge->id,422,'Impossible de déplacer ce paiement.');}
            elseif($old=DB::table('school_staff_receipts')->where('request_key',$v['requestKey'])->first()){abort_unless($old->charge_id===$charge->id,422);return $old->id;}
            $values=['charge_id'=>$charge->id,'amount'=>$v['amount'],'paid_at'=>$v['date']??null,'reference'=>$v['reference']??null,'method'=>$v['method']??($old->method??null)]+$stamp;
            if($id){DB::table('school_staff_receipts')->where('id',$id)->update($values);return (int)$id;}
            return DB::table('school_staff_receipts')->insertGetId($values+['request_key'=>$v['requestKey'],'created_at'=>now()]);
        }
        abort(404);
    }
}
