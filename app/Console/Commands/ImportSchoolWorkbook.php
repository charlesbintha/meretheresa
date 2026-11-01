<?php
namespace App\Console\Commands;
use App\Services\SchoolWorkbookImporter;
use Illuminate\Console\Command;
class ImportSchoolWorkbook extends Command {
    protected $signature='school:import-workbook {manifest} {--apply : Importer et activer l’année 2026-2027}';
    protected $description='Contrôler ou importer le manifeste privé des inscriptions 2026-2027, sans remplacer les années existantes';
    public function handle(): int {
        $path=$this->argument('manifest');if(!is_file($path)){$this->error('Manifeste introuvable.');return self::FAILURE;}
        $data=json_decode(file_get_contents($path),true,512,JSON_THROW_ON_ERROR);
        if(!$this->option('apply')){$this->info(json_encode(['year'=>$data['year'],'students'=>count($data['students']),'receipts'=>array_sum(array_map(fn($s)=>count($s['receipts']),$data['students'])),'excluded'=>count($data['excluded'])],JSON_UNESCAPED_UNICODE));return self::SUCCESS;}
        $this->info(json_encode(app(SchoolWorkbookImporter::class)->import($data),JSON_UNESCAPED_UNICODE));return self::SUCCESS;
    }
}
