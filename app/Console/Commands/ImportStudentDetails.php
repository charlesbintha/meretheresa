<?php
namespace App\Console\Commands;
use App\Services\SchoolStudentProfiles;
use Illuminate\Console\Command;
class ImportStudentDetails extends Command {
 protected $signature='school:import-details {manifest} {--apply} {--report=}';
 protected $description='Rapprocher les fiches par identité et classe et compléter seulement les champs vides';
 public function handle(): int {
  $r=app(SchoolStudentProfiles::class)->import(json_decode(file_get_contents($this->argument('manifest')),true,512,JSON_THROW_ON_ERROR),(bool)$this->option('apply'));
  if($path=$this->option('report')){file_put_contents($path,json_encode($r,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));chmod($path,0600);}
  $audit=$r['audit']??$r;$this->info(json_encode(['alreadyImported'=>$r['alreadyImported']??false,'matched'=>$audit['matched'],'updatedFields'=>$audit['updatedFields'],'unmatched'=>count($audit['unmatched']),'conflicts'=>count($audit['conflicts']),'missingStudents'=>count($audit['missingStudents']),'sourceIssues'=>count($audit['issues'])]));return self::SUCCESS;
 }
}
