<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class SchoolStudentProfiles {
 public const CORE=['firstName'=>'first_name','lastName'=>'last_name','birth'=>'date_of_birth','birthPlace'=>'place_of_birth','gender'=>'gender','address'=>'address','parent'=>'parent_name','phone'=>'parent_phone','email'=>'parent_email'];
 public const EXTRA=['section','orphanStatus','familyStatus','emergencyContact','fatherName','fatherPhone','fatherEmail','motherName','motherPhone','motherEmail','guardianName','guardianPhone','guardianEmail'];
 public static function normalize(string $s): string {return trim(preg_replace('/[^A-Z0-9]+/',' ',strtoupper(Str::ascii($s))));}
 private function key($last,$first,$class): string {return implode('|',array_map(self::normalize(...),[$last,$first,$class]));}
 public function edit(int $id,int $year,array $v): int {
  abort_unless(DB::table('enrollments')->where(['student_id'=>$id,'academic_year_id'=>$year])->exists(),404);
  $rules=array_fill_keys(array_merge(array_keys(self::CORE),self::EXTRA),'sometimes|nullable|string|max:500');
  $rules['birthPlace']='sometimes|nullable|string|max:255';$rules['parent']='sometimes|nullable|string|max:255';$rules['phone']='sometimes|nullable|string|max:150';
  $rules['firstName']='sometimes|required|string|max:100';$rules['lastName']=$rules['firstName'];$rules['birth']='sometimes|nullable|date_format:Y-m-d|before_or_equal:today';$rules['gender']='sometimes|nullable|in:F,M';$rules['email']='sometimes|nullable|email|max:191';
  $v=Validator::make($v,$rules)->validate();$core=[];$row=DB::table('school_student_profiles')->where('student_id',$id)->first();$extra=$row?json_decode($row->details,true):[];
  foreach($v as $k=>$value){if(isset(self::CORE[$k]))$core[self::CORE[$k]]=$value;else $extra[$k]=$value;}
  if($core)DB::table('students')->where('id',$id)->update($core+['updated_at'=>now()]);
  if($row)DB::table('school_student_profiles')->where('id',$row->id)->update(['details'=>json_encode($extra,JSON_UNESCAPED_UNICODE),'updated_at'=>now()]);
  else DB::table('school_student_profiles')->insert(['student_id'=>$id,'details'=>json_encode($extra,JSON_UNESCAPED_UNICODE),'created_at'=>now(),'updated_at'=>now()]);
  return $id;
 }
 public function import(array $data,bool $apply=false): array {
  Validator::make($data,['format'=>'required|in:1','year'=>'required|string','sourceHash'=>'required|string|size:64','records'=>'required|array','records.*.firstName'=>'required|string','records.*.lastName'=>'required|string','records.*.schoolClass'=>'required|string','records.*.source'=>'required|string','records.*.fields'=>'required|array'])->validate();
  return DB::transaction(function()use($data,$apply){
   $settings=DB::table('school_settings')->where('id',1)->lockForUpdate()->first();
   if($old=DB::table('school_detail_imports')->where('source_hash',$data['sourceHash'])->first())return ['alreadyImported'=>true,'audit'=>json_decode($old->audit,true)];
   $year=DB::table('academic_years')->where('year_name',$data['year'])->value('id');abort_unless($year,422,'Année introuvable.');
   $roster=DB::table('students as s')->join('enrollments as e','e.student_id','=','s.id')->join('classes as c','c.id','=','e.class_id')->where('e.academic_year_id',$year)->select('s.*','c.name as school_class')->get();
   $index=[];foreach($roster as $s)$index[$this->key($s->last_name,$s->first_name,$s->school_class)][]=$s;
   $sourceCounts=[];foreach($data['records'] as $r){$k=$this->key($r['lastName'],$r['firstName'],$r['schoolClass']);$sourceCounts[$k]=($sourceCounts[$k]??0)+1;}
   $report=['matched'=>0,'updatedFields'=>0,'unmatched'=>[],'conflicts'=>[],'missingStudents'=>[],'issues'=>$data['issues']??[],'dateConversions'=>$data['dateConversions']??[]];$matched=[];
   foreach($data['records'] as $r){
    $key=$this->key($r['lastName'],$r['firstName'],$r['schoolClass']);$matches=$index[$key]??[];
    if(count($matches)!==1||$sourceCounts[$key]!==1){$report['unmatched'][]=['source'=>$r['source'],'lastName'=>$r['lastName'],'firstName'=>$r['firstName'],'class'=>$r['schoolClass'],'reason'=>count($matches)>1||$sourceCounts[$key]>1?'Identité ambiguë':'Nom ou classe à rapprocher'];continue;}
    $s=$matches[0];$matched[]=$s->id;$report['matched']++;$old=DB::table('school_student_profiles')->where('student_id',$s->id)->first();$extra=$old?json_decode($old->details,true):[];$core=[];
    foreach($r['fields'] as $field=>$value){
     abort_unless(isset(self::CORE[$field])||in_array($field,self::EXTRA,true),422,'Champ inconnu.');
     abort_if(in_array($field,['firstName','lastName'],true),422,'Cet import ne renomme pas les élèves.');
     if($value===null||trim((string)$value)==='')continue;
     if($field==='birth')Validator::make(['birth'=>$value],['birth'=>'date_format:Y-m-d|before_or_equal:today'])->validate();
     if($field==='gender')Validator::make(['gender'=>$value],['gender'=>'in:F,M'])->validate();
     $previous=isset(self::CORE[$field])?$s->{self::CORE[$field]}:($extra[$field]??null);
     if($previous!==null&&trim((string)$previous)!==''){
      if((string)$previous!==(string)$value)$report['conflicts'][]=['matricule'=>$s->matricule,'source'=>$r['source'],'field'=>$field,'current'=>$previous,'sourceValue'=>$value];continue;
     }
     if(isset(self::CORE[$field]))$core[self::CORE[$field]]=$value;else $extra[$field]=$value;$report['updatedFields']++;
    }
    if($apply){
     if($core)DB::table('students')->where('id',$s->id)->update($core+['updated_at'=>now()]);
     $values=['details'=>json_encode($extra,JSON_UNESCAPED_UNICODE),'source_cell'=>$r['source'],'source_hash'=>$data['sourceHash'],'updated_at'=>now()];
     if($old)DB::table('school_student_profiles')->where('id',$old->id)->update($values);else DB::table('school_student_profiles')->insert(['student_id'=>$s->id,'created_at'=>now()]+$values);
    }
   }
   foreach($roster as $s)if(!in_array($s->id,$matched,true))$report['missingStudents'][]=['matricule'=>$s->matricule,'firstName'=>$s->first_name,'lastName'=>$s->last_name,'class'=>$s->school_class];
   if($apply){DB::table('school_detail_imports')->insert(['academic_year_id'=>$year,'source_hash'=>$data['sourceHash'],'audit'=>json_encode($report,JSON_UNESCAPED_UNICODE),'created_at'=>now(),'updated_at'=>now()]);DB::table('school_settings')->where('id',1)->update(['revision'=>$settings->revision+1,'updated_at'=>now()]);}
   return $report;
  });
 }
}
