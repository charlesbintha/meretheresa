<?php
namespace App\Console\Commands;
use App\Models\{User,SchoolRole};
use App\Services\{TemplateImporter,SchoolBilling};
use Illuminate\Console\Command;
use Illuminate\Support\Facades\{DB,Hash};
use Illuminate\Support\Str;
class CreateDemoSchool extends Command {
 protected $signature='school:create-demo';
 protected $description='Initialise une base de démonstration vide uniquement, avec données fictives et administrateur.';
 public function handle(): int {
  if(!config('school.demo')||DB::connection()->getDriverName()!=='sqlite'||!str_ends_with(DB::connection()->getDatabaseName(),'horizon-demo.sqlite')||DB::table('students')->exists()||DB::table('users')->exists()){$this->error('Initialisation refusée : exige SCHOOL_DEMO=true et une base SQLite horizon-demo.sqlite vide.');return self::FAILURE;}
  $password=Str::password(20,symbols:false);
  DB::transaction(function()use($password){
   app(TemplateImporter::class)->replace(false);
   // All contacts are synthetic and cannot send mail to actual families.
   foreach(DB::table('students')->get() as $s)DB::table('students')->where('id',$s->id)->update(['first_name'=>'Élève','last_name'=>sprintf('Démo %03d',$s->id),'matricule'=>'DEMO-'.str_pad($s->id,4,'0',STR_PAD_LEFT),'parent_name'=>'Parent fictif '.$s->id,'parent_email'=>'parent'.$s->id.'@example.invalid','parent_phone'=>'','address'=>'Adresse fictive · Dakar']);
   foreach(DB::table('teachers')->get() as $t)DB::table('teachers')->where('id',$t->id)->update(['first_name'=>'Enseignant','last_name'=>'Démo '.$t->id,'email'=>'enseignant'.$t->id.'@example.invalid','phone'=>'']);
   $year=DB::table('academic_years')->where('is_current',true)->first();
   DB::table('academic_years')->where('id','!=',$year->id)->update(['year_name'=>'Archives démo']);
   DB::table('academic_years')->where('id',$year->id)->update(['year_name'=>'2026–2027','start_date'=>'2026-10-01','end_date'=>'2027-06-30']);
   foreach(DB::table('periods')->where('academic_year_id',$year->id)->get() as $p){$start=\Carbon\Carbon::parse('2026-10-01')->addMonths(($p->term_number-1)*3);DB::table('periods')->where('id',$p->id)->update(['start_date'=>$start->toDateString(),'end_date'=>$start->copy()->addMonths(3)->subDay()->toDateString(),'is_current'=>$p->term_number===1]);}
   DB::table('enrollments')->where('academic_year_id',$year->id)->update(['enrollment_date'=>'2026-10-01']);
   DB::table('school_settings')->where('id',1)->update(['values'=>json_encode(['school'=>'Groupe scolaire Horizon','city'=>'Dakar','address'=>'Avenue des Écoles · Adresse de démonstration','phone'=>'Téléphone démo','email'=>'contact@horizon.example','tuitionFee'=>150000])]);
   DB::table('school_imports')->insert(['academic_year_id'=>$year->id,'source_hash'=>hash('sha256','horizon-fictitious-v1'),'audit'=>json_encode(['demo'=>true]),'created_at'=>now(),'updated_at'=>now()]);
   $billing=app(SchoolBilling::class);
   foreach(DB::table('enrollments')->where('academic_year_id',$year->id)->where('status','confirmed')->get() as $e){
    for($i=10;$i<=18;$i++){$month=sprintf('%04d-%02d',2026+intdiv($i-1,12),($i-1)%12+1);$billing->charge($e->student_id,$year->id,'tuition',$month,15000);if($i>=11&&$i<=17)$billing->charge($e->student_id,$year->id,'studies',$month,3000);}
    if($e->student_id%2===0)$billing->membership($e->student_id,$year->id,'canteen');if($e->student_id%3===0)$billing->membership($e->student_id,$year->id,'transport','ZONE 1');
   }
   foreach(DB::table('school_charges')->whereIn('month',['2026-10','2026-11'])->where('kind','tuition')->get()->filter(fn($c)=>$c->month==='2026-10'||$c->student_id%3!==0) as $c)DB::table('school_receipts')->insert(['charge_id'=>$c->id,'amount'=>$c->student_id%5===0?5000:$c->amount,'paid_at'=>$c->month.'-05','reference'=>'DEMO-RECU-'.$c->id,'label'=>'Scolarité','method'=>'Espèces','created_at'=>now(),'updated_at'=>now()]);
   DB::table('grades')->delete();$first=DB::table('periods')->where('academic_year_id',$year->id)->where('term_number',1)->value('id');
   $subjects=DB::table('subjects')->get();$rows=[];
   foreach(DB::table('enrollments')->where('academic_year_id',$year->id)->where('status','confirmed')->get() as $e)foreach($subjects as $subject)foreach(['homework','exam'] as $type)$rows[]=['student_id'=>$e->student_id,'subject_id'=>$subject->id,'class_id'=>$e->class_id,'period_id'=>$first,'grade_type'=>$type,'score'=>8+(($e->student_id*3+$subject->id*2+($type==='exam'?1:0))%49)/4,'max_score'=>20,'grade_date'=>'2026-11-15','teacher_id'=>$subject->teacher_id,'created_at'=>now(),'updated_at'=>now()];
   foreach(array_chunk($rows,300) as $chunk)DB::table('grades')->insert($chunk);
   User::create(['name'=>'Administrateur Horizon','email'=>'admin@horizon.example','password'=>Hash::make($password)])->forceFill(['school_role_id'=>SchoolRole::where('is_system',true)->firstOrFail()->id,'is_school_admin'=>true,'is_active'=>true,'password_setup_required'=>false])->save();
  });
  $this->line('DEMO_LOGIN=admin@horizon.example');$this->line('DEMO_PASSWORD='.$password);$this->info('Démonstration créée : '.DB::table('students')->count().' élèves fictifs.');return self::SUCCESS;
 }
}
