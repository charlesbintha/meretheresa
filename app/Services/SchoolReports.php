<?php
namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SchoolReports
{
 public function overview(int $classId,int $term): array {
  $year=DB::table('academic_years')->where('is_current',true)->first();
  $class=DB::table('classes')->where('academic_year_id',$year?->id)->find($classId);abort_unless($class,404);
  $period=DB::table('periods')->where('academic_year_id',$year->id)->where('term_number',$term)->first();abort_unless($period,404);
  $subjects=DB::table('subjects')->orderBy('id')->get();
  $students=DB::table('students')->join('enrollments','students.id','=','enrollments.student_id')->where('enrollments.class_id',$classId)->where('enrollments.academic_year_id',$year->id)->where('enrollments.status','confirmed')->where('students.status','active')->select('students.*')->orderBy('last_name')->orderBy('first_name')->get();
  $grades=DB::table('grades')->where('class_id',$classId)->where('period_id',$period->id)->whereIn('grade_type',['homework','exam'])->orderBy('id')->get()->keyBy(fn($g)=>$g->student_id.'-'.$g->subject_id.'-'.$g->grade_type);
  $saved=DB::table('school_report_snapshots')->where('class_id',$classId)->where('period_id',$period->id)->orderBy('id')->get()->keyBy('student_id');
  $cards=[];
  foreach($students as $s){
   $previous=$saved->get($s->id);$annotation=$previous?json_decode($previous->snapshot,true):[];
   $lines=[];$sum=0;$weight=0;$complete=$subjects->isNotEmpty();
   foreach($subjects as $subject){
    $a=$grades->get("$s->id-$subject->id-homework");$b=$grades->get("$s->id-$subject->id-exam");
    $average=$a&&$b?((float)$a->score+2*(float)$b->score)/3:null;
    $coefficient=(float)$subject->coefficient;
    if($average===null||$coefficient<=0)$complete=false;
    else {$sum+=$average*$coefficient;$weight+=$coefficient;}
    $lines[]=['subject'=>$subject->name,'coefficient'=>$coefficient,'test'=>$a?(float)$a->score:null,'exam'=>$b?(float)$b->score:null,'average'=>$average,'points'=>$average===null?null:$average*$coefficient,'mention'=>$this->mention($average)];
   }
   $average=$complete&&$weight>0?round($sum/$weight,2):null;
   $cards[]=['studentId'=>$s->id,'name'=>trim($s->first_name.' '.$s->last_name),'matricule'=>$s->matricule,'birth'=>$s->date_of_birth,'classId'=>$class->id,'class'=>$class->name,'year'=>$year->year_name,'term'=>$term,'periodId'=>$period->id,'lines'=>$lines,'complete'=>$complete,'average'=>$average,'totalPoints'=>$sum,'totalCoefficient'=>$weight,'mention'=>$this->mention($average),'rank'=>null,'savedId'=>$saved->get($s->id)?->id,'savedAt'=>$saved->get($s->id)?->created_at,'comment'=>$annotation['comment']??'','absences'=>$annotation['absences']??0,'late'=>$annotation['late']??0];
  }
  $averages=array_values(array_filter(array_column($cards,'average'),fn($v)=>$v!==null));
  $stats=['count'=>count($cards),'complete'=>count($averages),'average'=>$averages?array_sum($averages)/count($averages):null,'min'=>$averages?min($averages):null,'max'=>$averages?max($averages):null];
  foreach($cards as &$card){if($card['average']!==null)$card['rank']=1+count(array_filter($averages,fn($v)=>$v>$card['average']));$card['stats']=$stats;}unset($card);
  return ['cards'=>$cards,'stats'=>$stats,'class'=>$class->name,'term'=>$term];
 }
 public function generate(User $user,array $v): array {
  return DB::transaction(function()use($user,$v){
   DB::table('school_settings')->where('id',1)->lockForUpdate()->first();
   $data=$this->overview($v['classId'],$v['term']);$cards=collect($data['cards'])->keyBy('studentId');$result=[];
   foreach($v['students'] as $input){
    $card=$cards->get($input['id']);
    if(!$card||!$card['complete'])throw ValidationException::withMessages(['students'=>'Toutes les notes des élèves sélectionnés doivent être renseignées avant de générer leur bulletin.']);
    unset($card['savedId'],$card['savedAt']);
    $card['comment']=$input['comment']??'';$card['absences']=$input['absences']??0;$card['late']=$input['late']??0;
    $card['school']=json_decode(DB::table('school_settings')->where('id',1)->value('values'),true);
    $fingerprint=hash('sha256',json_encode($card));
    $existing=DB::table('school_report_snapshots')->where('fingerprint',$fingerprint)->first();
    if($existing){$result[]=$this->saved($existing->id);continue;}
    $card['generatedAt']=now()->toIso8601String();
    $id=DB::table('school_report_snapshots')->insertGetId(['student_id'=>$card['studentId'],'class_id'=>$v['classId'],'period_id'=>$card['periodId'],'created_by'=>$user->id,'fingerprint'=>$fingerprint,'snapshot'=>json_encode($card),'created_at'=>now(),'updated_at'=>now()]);
    $result[]=['id'=>$id]+$card;
   }
   return $result;
  });
 }
 public function saved(int $id): array {$r=DB::table('school_report_snapshots')->find($id);abort_unless($r,404);return ['id'=>$r->id]+json_decode($r->snapshot,true);}
 private function mention(?float $v): string {return $v===null?'Incomplet':($v>=16?'Très bien':($v>=14?'Bien':($v>=12?'Assez bien':($v>=10?'Passable':'À renforcer'))));}
}
