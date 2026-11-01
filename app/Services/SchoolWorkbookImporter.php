<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SchoolWorkbookImporter
{
    public function import(array $data): array {
        Validator::make($data,['format'=>'required|in:1','year'=>'required|in:2026-2027','sourceHash'=>'required|string|size:64','students'=>'required|array|min:1','students.*.order'=>'required|integer|min:1|distinct|not_in:678','students.*.class'=>'required|in:'.implode(',',SchoolBilling::CLASSES),'students.*.firstName'=>'required|string|max:255','students.*.lastName'=>'required|string|max:255','students.*.receipts'=>'present|array','students.*.receipts.*.amount'=>'required|integer|min:1','students.*.receipts.*.date'=>'nullable|date_format:Y-m-d','students.*.receipts.*.reference'=>'nullable|string|max:191','students.*.receipts.*.month'=>['required','regex:/^202[67]-(0[1-9]|1[012])$/'],'students.*.receipts.*.source'=>'required|string','students.*.subscriptions'=>'present|array'])->validate();
        return DB::transaction(function()use($data){
            $settings=DB::table('school_settings')->where('id',1)->lockForUpdate()->first();
            if($old=DB::table('school_imports')->where('source_hash',$data['sourceHash'])->first())return ['alreadyImported'=>true,'yearId'=>$old->academic_year_id];
            abort_if(DB::table('academic_years')->where('year_name',$data['year'])->exists(),422,'Cette année existe déjà. Import refusé pour préserver ses données.');
            $stamp=['created_at'=>now(),'updated_at'=>now()];$billing=app(SchoolBilling::class);
            $year=DB::table('academic_years')->insertGetId(['year_name'=>$data['year'],'start_date'=>'2026-10-01','end_date'=>'2027-06-30','is_current'=>false]+$stamp);
            $classes=[];
            foreach(SchoolBilling::CLASSES as $name){$count=count(array_filter($data['students'],fn($s)=>$s['class']===$name));$classes[$name]=DB::table('classes')->insertGetId(['name'=>$name,'level'=>SchoolBilling::elementary($name)?'Élémentaire':'Maternelle','academic_year_id'=>$year,'capacity'=>max(30,$count),'room'=>null]+$stamp);}
            for($term=1;$term<=3;$term++){
                $start=\Carbon\Carbon::parse('2026-10-01')->addMonths(($term-1)*3);
                DB::table('periods')->insert(['academic_year_id'=>$year,'name'=>$term.'e trimestre','term_number'=>$term,'start_date'=>$start->toDateString(),'end_date'=>$start->copy()->addMonths(3)->subDay()->toDateString(),'is_current'=>$term===1]+$stamp);
            }
            $receipts=0;$total=0;
            foreach($data['students'] as $s){
                $mat='MAT-'.$s['order'];abort_if(DB::table('students')->where('matricule',$mat)->exists(),422,"Le matricule $mat existe déjà. Aucun rapprochement automatique.");
                $sid=DB::table('students')->insertGetId(['matricule'=>$mat,'first_name'=>$s['firstName'],'last_name'=>$s['lastName'],'status'=>'active']+$stamp);
                DB::table('enrollments')->insert(['student_id'=>$sid,'class_id'=>$classes[$s['class']],'academic_year_id'=>$year,'enrollment_date'=>$s['date']??null,'approved_date'=>$s['date']??null,'status'=>'confirmed']+$stamp);
                $billing->schoolCharges($sid,$year,$s['class'],$s['date']??null);
                foreach($s['subscriptions'] as $sub)$billing->membership($sid,$year,$sub['kind'],$sub['zone'],$sub['trip']);
                foreach($s['receipts'] as $r){
                    abort_unless(isset(SchoolBilling::LABELS[$r['kind']]),422,'Objet de paiement inconnu.');
                    $charge=DB::table('school_charges')->where(['student_id'=>$sid,'academic_year_id'=>$year,'kind'=>$r['kind'],'month'=>$r['month']])->first();
                    if(!$charge){abort_unless($r['kind']==='supplement',422,'Paiement sans échéance correspondante.');$cid=$billing->charge($sid,$year,$r['kind'],$r['month'],$r['amount']);}else{$cid=$charge->id;}
                    DB::table('school_receipts')->insert(['charge_id'=>$cid,'amount'=>$r['amount'],'paid_at'=>$r['date'],'reference'=>$r['reference'],'label'=>$r['label'],'raw_date'=>$r['rawDate'],'source_key'=>$data['sourceHash'].':'.$r['source']]+$stamp);$receipts++;$total+=$r['amount'];
                }
            }
            DB::table('school_imports')->insert(['academic_year_id'=>$year,'source_hash'=>$data['sourceHash'],'audit'=>json_encode(['excluded'=>$data['excluded'],'corrections'=>$data['corrections'],'students'=>count($data['students']),'receipts'=>$receipts,'amount'=>$total,'sourceRegistrationBalances'=>array_map(fn($s)=>['order'=>$s['order'],'balance'=>$s['sourceRegistrationBalance'],'rawDate'=>$s['rawDate']],$data['students'])],JSON_UNESCAPED_UNICODE)]+$stamp);
            DB::table('academic_years')->update(['is_current'=>false]);DB::table('academic_years')->where('id',$year)->update(['is_current'=>true]);
            DB::table('school_settings')->where('id',1)->update(['revision'=>$settings->revision+1,'updated_at'=>now()]);
            return ['yearId'=>$year,'students'=>count($data['students']),'receipts'=>$receipts,'amount'=>$total];
        });
    }
}
