<?php
namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SchoolBilling
{
    public const LABELS=['registration'=>'Inscription','supplement'=>'Tenue / sport supplémentaire','tuition'=>'Scolarité','studies'=>'Études','canteen'=>'Cantine','transport'=>'Transport','canteen_adhesion'=>'Adhésion cantine','transport_adhesion'=>'Adhésion transport'];
    public const CLASSES=['GARDE','PS','MS','GS','CI','CP','CE1','CE2','CM1','CM2'];
    public static function elementary(string $class): bool {return in_array($class,['CI','CP','CE1','CE2','CM1','CM2'],true);}
    public static function tuition(string $class): int {return $class==='CM2'?16000:(self::elementary($class)?15000:13000);}
    public static function registration(string $class): int {return match($class){'GARDE'=>39000,'PS','MS'=>43000,'GS'=>57000,'CM2'=>65000,default=>59000};}
    public static function transportFee(string $zone,string $trip,?int $custom=null): int {
        if($zone==='HORS ZONE' && $trip!=='round_trip'){abort_unless($custom!==null && $custom>0,422,'Renseignez le tarif hors zone pour un seul trajet.');return $custom;}
        return ($trip==='round_trip'?['ZONE 1'=>8500,'ZONE 2'=>11000,'ZONE 3'=>13000,'HORS ZONE'=>15000]:['ZONE 1'=>7000,'ZONE 2'=>8500,'ZONE 3'=>10000])[$zone];
    }
    public function charge(int $student,int $year,string $kind,string $month,int $amount,?string $due=null): int {
        $key=['student_id'=>$student,'academic_year_id'=>$year,'kind'=>$kind,'month'=>$month];
        $existing=DB::table('school_charges')->where($key)->first();
        return $existing?->id ?? DB::table('school_charges')->insertGetId($key+['amount'=>$amount,'due_date'=>$due??$month.'-01','created_at'=>now(),'updated_at'=>now()]);
    }
    public function schoolCharges(int $student,int $year,string $class,?string $enrolled=null): void {
        $start=(int)substr(DB::table('academic_years')->where('id',$year)->value('start_date'),0,4);
        $this->charge($student,$year,'registration',"$start-10",self::registration($class)-self::tuition($class),$enrolled);
        for($i=10;$i<=18;$i++){
            $month=sprintf('%04d-%02d',$start+intdiv($i-1,12),($i-1)%12+1);
            $this->charge($student,$year,'tuition',$month,self::tuition($class));
            if(self::elementary($class)&&$i>=11&&$i<=17)$this->charge($student,$year,'studies',$month,3000);
        }
    }
    public function membership(int $student,int $year,string $kind,?string $zone=null,string $trip='round_trip',?int $custom=null): int {
        $fee=$kind==='canteen'?12000:self::transportFee($zone,$trip,$custom);
        $key=['student_id'=>$student,'academic_year_id'=>$year,'kind'=>$kind];$old=DB::table('school_service_memberships')->where($key)->first();
        $values=['zone'=>$zone,'trip'=>$trip,'monthly_fee'=>$fee,'active'=>true,'abandoned'=>false,'updated_at'=>now()];
        if($old){DB::table('school_service_memberships')->where('id',$old->id)->update($values);$id=$old->id;}else{$id=DB::table('school_service_memberships')->insertGetId($key+$values+['created_at'=>now()]);}
        $start=(int)substr(DB::table('academic_years')->where('id',$year)->value('start_date'),0,4);
        $this->charge($student,$year,$kind.'_adhesion',"$start-".($kind==='canteen'?'11':'10'),$kind==='canteen'?3000:2500);
        for($i=$kind==='canteen'?11:10;$i<=($kind==='canteen'?17:18);$i++){
            $month=sprintf('%04d-%02d',$start+intdiv($i-1,12),($i-1)%12+1);
            $cid=$this->charge($student,$year,$kind,$month,$fee);
            // A change of plan never rewrites a month that already has payments.
            if(!DB::table('school_receipts')->where('charge_id',$cid)->exists())DB::table('school_charges')->where('id',$cid)->update(['amount'=>$fee,'updated_at'=>now()]);
        }
        return $id;
    }
    public function enabled(int $year): bool {return DB::table('school_imports')->where('academic_year_id',$year)->exists();}
    public function state(int $year,User $user): array {
        $data=['enabled'=>$this->enabled($year),'charges'=>[],'receipts'=>[],'memberships'=>[]];if(!$data['enabled'])return $data;
        if($user->canSchool('finance.view')){
            $data['charges']=DB::table('school_charges')->where('academic_year_id',$year)->get()->map(fn($r)=>(array)$r)->all();
            $data['receipts']=DB::table('school_receipts')->whereIn('charge_id',array_column($data['charges'],'id'))->get()->map(fn($r)=>(array)$r)->all();
        }
        if($user->canSchool('services.view')||$user->canSchool('finance.view'))$data['memberships']=DB::table('school_service_memberships')->where('academic_year_id',$year)->get()->map(fn($r)=>(array)$r)->all();
        return $data;
    }
    private function currentCharge(int $id,int $year): object {
        return DB::table('school_charges')->where('id',$id)->where('academic_year_id',$year)->first()??abort(404);
    }
    public function execute(string $action,array $v,?string $id,User $actor,int $year): int {
        abort_unless($this->enabled($year),422,'La facturation mensuelle n’est pas activée pour cette année.');
        if($action==='billing-enrollment'){
            $v=Validator::make($v,[
                'order'=>['required','integer','min:1'], 'firstName'=>'required|string|max:100','lastName'=>'required|string|max:100',
                'classId'=>['required','integer',Rule::exists('classes','id')->where('academic_year_id',$year)],
                'date'=>'nullable|date_format:Y-m-d|before_or_equal:today','reference'=>'nullable|string|max:191',
                'general'=>'required|integer|min:0|max:1000000','uniform'=>'required|integer|min:0|max:1000000','sport'=>'required|integer|min:0|max:1000000','extra'=>'required|integer|min:0|max:1000000','october'=>'required|integer|min:0|max:1000000',
                'canteen'=>'sometimes|in:1','transport'=>'sometimes|in:1','zone'=>'nullable|in:ZONE 1,ZONE 2,ZONE 3,HORS ZONE','trip'=>'required|in:round_trip,outbound,return','monthlyFee'=>'nullable|integer|min:1|max:1000000',
            ])->validate();
            if(array_sum(array_intersect_key($v,array_flip(['general','uniform','sport','extra','october'])))>0)abort_unless($actor->canSchool('finance.manage'),403,'Le droit de gérer les finances est requis pour encaisser.');
            if(!empty($v['canteen'])||!empty($v['transport']))abort_unless($actor->canSchool('services.manage'),403,'Le droit de gérer les services est requis.');
            $mat='MAT-'.$v['order'];abort_if(DB::table('students')->where('matricule',$mat)->exists(),422,'Ce matricule existe déjà.');
            $stamp=['created_at'=>now(),'updated_at'=>now()];$class=DB::table('classes')->find($v['classId']);
            abort_unless(in_array($class->name,self::CLASSES,true),422,'Tarif de classe non défini.');
            $sid=DB::table('students')->insertGetId(['matricule'=>$mat,'first_name'=>$v['firstName'],'last_name'=>$v['lastName'],'status'=>'active']+$stamp);
            DB::table('enrollments')->insert(['student_id'=>$sid,'class_id'=>$class->id,'academic_year_id'=>$year,'enrollment_date'=>$v['date']??null,'approved_date'=>$v['date']??null,'status'=>'confirmed']+$stamp);
            $this->schoolCharges($sid,$year,$class->name,$v['date']??null);
            $month=substr(DB::table('academic_years')->where('id',$year)->value('start_date'),0,4).'-10';
            foreach(['general'=>['registration','Frais généraux'],'uniform'=>['registration','Tenue / blouse'],'sport'=>['registration','Sport'],'extra'=>['supplement','Tenue / sport supplémentaire'],'october'=>['tuition','Scolarité octobre']] as $field=>[$kind,$label]){
                if(!$v[$field])continue;
                $cid=$this->charge($sid,$year,$kind,$month,$v[$field]);
                DB::table('school_receipts')->insert(['charge_id'=>$cid,'amount'=>$v[$field],'label'=>$label,'paid_at'=>$v['date']??null,'reference'=>$v['reference']??null]+$stamp);
            }
            if(!empty($v['canteen']))$this->membership($sid,$year,'canteen');
            if(!empty($v['transport'])){abort_unless(!empty($v['zone']),422,'Choisissez une zone.');$this->membership($sid,$year,'transport',$v['zone'],$v['trip'],$v['monthlyFee']??null);}
            return $sid;
        }
        if($action==='billing-receipt'){
            $v=Validator::make($v,['chargeId'=>'required|integer','amount'=>'required|integer|min:1|max:10000000','date'=>'nullable|date_format:Y-m-d|before_or_equal:today','reference'=>'nullable|string|max:191','label'=>'required|string|max:100','method'=>'nullable|string|max:40','requestKey'=>'required|uuid'])->validate();
            $charge=$this->currentCharge($v['chargeId'],$year);
            if($id){$old=DB::table('school_receipts')->find($id)??abort(404);$this->currentCharge($old->charge_id,$year);abort_unless($old->charge_id===$charge->id,422,'Une correction ne peut pas déplacer un paiement vers un autre compte.');}
            elseif($old=DB::table('school_receipts')->where('request_key',$v['requestKey'])->first())return $old->id;
            $row=['charge_id'=>$charge->id,'amount'=>$v['amount'],'paid_at'=>$v['date']??null,'reference'=>$v['reference']??null,'label'=>$v['label'],'method'=>$v['method']??null,'updated_at'=>now()];
            if($id){DB::table('school_receipts')->where('id',$id)->update($row);return (int)$id;}
            return DB::table('school_receipts')->insertGetId($row+['request_key'=>$v['requestKey'],'created_at'=>now()]);
        }
        if($action==='billing-waiver'){
            $charge=$this->currentCharge((int)$id,$year);
            $v=Validator::make($v,['amount'=>'required|integer|min:0|max:'.$charge->amount,'reason'=>'required|string|max:500'])->validate();
            DB::table('school_charges')->where('id',$id)->update(['waiver'=>$v['amount'],'waiver_reason'=>$v['reason'],'updated_at'=>now()]);return (int)$id;
        }
        if($action==='billing-membership'){
            $v=Validator::make($v,['studentId'=>'required|integer','kind'=>'required|in:canteen,transport','active'=>'required|boolean','zone'=>'nullable|in:ZONE 1,ZONE 2,ZONE 3,HORS ZONE','trip'=>'required|in:round_trip,outbound,return','monthlyFee'=>'nullable|integer|min:1|max:1000000'])->validate();
            abort_unless(DB::table('enrollments')->where('academic_year_id',$year)->where('student_id',$v['studentId'])->exists(),422);
            if(!$v['active']){
                $old=DB::table('school_service_memberships')->where(['student_id'=>$v['studentId'],'academic_year_id'=>$year,'kind'=>$v['kind']])->first()??abort(404);
                $values=['active'=>false,'updated_at'=>now()];
                if($old->abandoned && !empty($v['zone'])){
                    $fee=self::transportFee($v['zone'],$v['trip'],$v['monthlyFee']??null);
                    $values+=['zone'=>$v['zone'],'trip'=>$v['trip'],'monthly_fee'=>$fee];
                    $october=substr(DB::table('academic_years')->where('id',$year)->value('start_date'),0,4).'-10';
                    $cid=$this->charge($v['studentId'],$year,'transport',$october,$fee);
                    DB::table('school_charges')->where('id',$cid)->update(['amount'=>$fee,'tariff_pending'=>false,'updated_at'=>now()]);
                }
                DB::table('school_service_memberships')->where('id',$old->id)->update($values);
                // Existing charges remain explicit. Cancellation/exemption is recorded by finance.
                return $old->id;
            }
            if($v['kind']==='transport')abort_unless(!empty($v['zone']),422,'Choisissez la zone.');
            return $this->membership($v['studentId'],$year,$v['kind'],$v['zone']??null,$v['trip'],$v['monthlyFee']??null);
        }
        abort(404);
    }
}
