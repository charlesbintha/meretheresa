<?php

namespace App\Console\Commands;

use App\Services\TemplateImporter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportTemplate extends Command
{
    protected $signature = 'school:import-template {--replace : Remplacer les données scolaires après sauvegarde} {--database-name= : Nom exact de la base à remplacer}';

    protected $description = 'Importe les données de data.js, avec sauvegarde vérifiée et remplacement transactionnel.';

    public function handle(TemplateImporter $importer): int
    {
        $name = DB::connection()->getDatabaseName();
        if (! $this->option('replace') || $this->option('database-name') !== $name) {
            $this->error('Précisez --replace et --database-name avec le nom exact de la base ciblée.');

            return self::FAILURE;
        }
        try {
            $path = $importer->replace();
            $this->info('Données scolaires remplacées. Les comptes utilisateurs sont conservés.');
            $this->line('Sauvegarde privée : '.$path);
            $this->table(['Élèves', 'Enseignants', 'Classes', 'Paiements', 'Notes'], [[DB::table('students')->count(), DB::table('teachers')->count(), DB::table('classes')->count(), DB::table('payments')->count(), DB::table('grades')->count()]]);

            return self::SUCCESS;
        } catch (\Throwable $e) {
            report($e);
            $this->error('Import annulé. Consultez le journal Laravel privé pour le détail.');

            return self::FAILURE;
        }
    }
}
