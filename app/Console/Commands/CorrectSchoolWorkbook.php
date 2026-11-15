<?php
namespace App\Console\Commands;
use App\Services\SchoolWorkbookCorrections;
use Illuminate\Console\Command;
class CorrectSchoolWorkbook extends Command {
    protected $signature='school:correct-workbook {manifest} {--apply}';
    protected $description='Ajouter les corrections validées sans réimporter les données existantes';
    public function handle(): int {
        $data=json_decode(file_get_contents($this->argument('manifest')),true,512,JSON_THROW_ON_ERROR);
        if($this->option('apply'))$result=app(SchoolWorkbookCorrections::class)->apply($data);
        else $result=['students'=>count($data['students']),'services'=>count($data['services']),'staff'=>count($data['staff']),'decisions'=>count($data['decisions'])];
        $this->info(json_encode($result,JSON_UNESCAPED_UNICODE));return self::SUCCESS;
    }
}
