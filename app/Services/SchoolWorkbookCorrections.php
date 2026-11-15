<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class SchoolWorkbookCorrections {
    public function apply(array $data): array {
        Validator::make($data,['format'=>'required|in:2','year'=>'required|in:2026-2027','sourceHash'=>'required|string|size:64','correctionHash'=>'required|string|size:64','students'=>'present|array','services'=>'present|array','staff'=>'present|array','decisions'=>'required|array'])->validate();
        return DB::transaction(function()use($data){
            $settings=DB::table('school_settings')->where('id',1)->lockForUpdate()->first();
            if($old=DB::table('school_corrections')->where('correction_hash',$data['correctionHash'])->first())return ['alreadyApplied'=>true,'audit'=>json_decode($old->audit,true)];
            $import=DB::table('school_imports')->where('source_hash',$data['sourceHash'])->first()??abort(422,'Import source introuvable.');$year=$import->academic_year_id;
            abort_unless(DB::table('academic_years')->where('id',$year)->value('year_name')===$data['year'],422);
            $stamp=['created_at'=>now(),'updated_at'=>now()];$billing=app(SchoolBilling::class);$stats=['students'=>0,'serviceRecords'=>0,'staff'=>0,'receipts'=>0,'received'=>0];
            foreach($data['students'] as $s){
                Validator::make($s,['order'=>'required|integer|min:1','class'=>'required|in:'.implode(',',SchoolBilling::CLASSES),'firstName'=>'required|string','lastName'=>'required|string','receipts'=>'present|array'])->validate();
                abort_if(DB::table('students')->where('matricule','MAT-'.$s['order'])->exists(),422,'Matricule déjà créé : MAT-'.$s['order']);
                $class=DB::table('classes')->where(['academic_year_id'=>$year,'name'=>$s['class']])->sole();
                $sid=DB::table('students')->insertGetId(['matricule'=>'MAT-'.$s['order'],'first_name'=>$s['firstName'],'last_name'=>$s['lastName'],'status'=>'active']+$stamp);
                DB::table('enrollments')->insert(['student_id'=>$sid,'class_id'=>$class->id,'academic_year_id'=>$year,'enrollment_date'=>$s['date'],'approved_date'=>$s['date'],'status'=>'confirmed']+$stamp);
                $billing->schoolCharges($sid,$year,$s['class'],$s['date']);$stats['students']++;
            }
            foreach(array_merge($data['students'],$data['services']) as $s){
                $student=DB::table('students')->where('matricule','MAT-'.$s['order'])->sole();$sid=$student->id;
                abort_unless($student->first_name===$s['firstName'] && $student->last_name===$s['lastName'],422,'Identité modifiée depuis le premier import.');
                abort_unless(DB::table('enrollments')->where(['student_id'=>$sid,'academic_year_id'=>$year])->exists(),422);
                $abandoned=false;
                foreach($s['subscriptions'] as $sub){
                    abort_if(DB::table('school_service_memberships')->where(['student_id'=>$sid,'academic_year_id'=>$year,'kind'=>$sub['kind']])->exists(),422,'Adhésion déjà créée : MAT-'.$s['order']);
                    if($sub['abandoned']??false){
                        $abandoned=true;
                        DB::table('school_service_memberships')->insert(['student_id'=>$sid,'academic_year_id'=>$year,'kind'=>'transport','zone'=>null,'trip'=>'round_trip','monthly_fee'=>null,'active'=>false,'abandoned'=>true]+$stamp);
                        // Keep the known adhesion tariff and actual October cash only; the former zone is unknown.
                        $billing->charge($sid,$year,'transport_adhesion','2026-10',2500);
                    }else $billing->membership($sid,$year,$sub['kind'],$sub['zone'],$sub['trip']);
                    $stats['serviceRecords']++;
                }
                foreach($s['receipts'] as $r){
                    Validator::make($r,['amount'=>'required|integer|min:1','date'=>'nullable|date_format:Y-m-d','kind'=>'required|in:'.implode(',',array_keys(SchoolBilling::LABELS)),'month'=>['required','regex:/^202[67]-(0[1-9]|1[012])$/'],'source'=>'required|string'])->validate();
                    $key=$data['sourceHash'].':'.$r['source'];abort_if(DB::table('school_receipts')->where('source_key',$key)->exists(),422,'Versement déjà importé : '.$r['source']);
                    $charge=DB::table('school_charges')->where(['student_id'=>$sid,'academic_year_id'=>$year,'kind'=>$r['kind'],'month'=>$r['month']])->first();
                    if(!$charge){
                        abort_unless($r['kind']==='supplement'||($abandoned&&$r['kind']==='transport'&&$r['month']==='2026-10'),422,'Échéance introuvable.');
                        $cid=$billing->charge($sid,$year,$r['kind'],$r['month'],$r['amount']);
                        if($abandoned)DB::table('school_charges')->where('id',$cid)->update(['tariff_pending'=>true]);
                    }else $cid=$charge->id;
                    DB::table('school_receipts')->insert(['charge_id'=>$cid,'amount'=>$r['amount'],'paid_at'=>$r['date'],'reference'=>$r['reference'],'label'=>$r['label'],'raw_date'=>$r['rawDate'],'source_key'=>$key]+$stamp);$stats['receipts']++;$stats['received']+=$r['amount'];
                }
            }
            foreach($data['staff'] as $s){
                Validator::make($s,['firstName'=>'required|string|max:100','lastName'=>'required|string|max:100','role'=>'nullable|string|max:100','source'=>'required|string','monthlyFee'=>'required|integer|min:0|max:1000000'])->validate();
                abort_if(DB::table('school_staff')->where(['first_name'=>$s['firstName'],'last_name'=>$s['lastName']])->exists(),422,'Personnel déjà créé, rapprochement nécessaire.');
                $sid=DB::table('school_staff')->insertGetId(['first_name'=>$s['firstName'],'last_name'=>$s['lastName'],'role'=>$s['role'],'source_key'=>$data['sourceHash'].':'.$s['source']]+$stamp);
                app(SchoolStaff::class)->membership($sid,$year,$s['monthlyFee']);$stats['staff']++;
            }
            DB::table('school_corrections')->insert(['academic_year_id'=>$year,'source_hash'=>$data['sourceHash'],'correction_hash'=>$data['correctionHash'],'audit'=>json_encode($stats+['decisions'=>$data['decisions']],JSON_UNESCAPED_UNICODE)]+$stamp);
            DB::table('school_settings')->where('id',1)->update(['revision'=>$settings->revision+1,'updated_at'=>now()]);return $stats;
        });
    }
}
