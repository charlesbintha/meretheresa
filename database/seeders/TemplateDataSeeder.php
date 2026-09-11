<?php

namespace Database\Seeders;

use App\Services\TemplateImporter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateDataSeeder extends Seeder
{
    /**
     * Explicit replacement of school records from the original data.js dataset.
     * Uses the same verified backup and transaction as school:import-template.
     */
    public function run(TemplateImporter $importer): void
    {
        $this->command?->info('Base ciblée : '.DB::connection()->getDatabaseName());
        $backup = $importer->replace();

        $this->command?->info('Données scolaires importées. Comptes utilisateurs conservés.');
        $this->command?->line('Sauvegarde privée : '.$backup);
        $this->command?->table(['Données', 'Nombre'], [
            ['Élèves', DB::table('students')->count()],
            ['Enseignants', DB::table('teachers')->count()],
            ['Classes', DB::table('classes')->count()],
            ['Matières', DB::table('subjects')->count()],
            ['Paiements', DB::table('payments')->count()],
            ['Abonnements', DB::table('canteen_subscriptions')->count()
                + DB::table('transport_subscriptions')->count()
                + DB::table('evening_studies')->count()],
            ['Cours', DB::table('timetables')->count()],
            ['Notes', DB::table('grades')->count()],
        ]);
    }
}
