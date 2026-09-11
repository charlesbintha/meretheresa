<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TemplateImporter
{
    public const TABLES = ['school_preferences', 'school_audit_logs', 'evaluations', 'report_cards', 'grades', 'payments', 'tuitions', 'timetables', 'canteen_subscriptions', 'transport_subscriptions', 'evening_studies', 'student_documents', 'enrollments', 'students', 'classes', 'subjects', 'teachers', 'periods', 'academic_years'];

    public function replace(bool $backup = true): ?string
    {
        $data = json_decode(file_get_contents(database_path('seed-data/template.json')), true, 512, JSON_THROW_ON_ERROR);

        return DB::transaction(function () use ($data, $backup) {
            $settings = DB::table('school_settings')->where('id', 1)->lockForUpdate()->first();
            $path = null;
            if ($backup) {
                $snapshot = ['format' => 1, 'created_at' => now()->toIso8601String(), 'tables' => []];
                foreach ([...self::TABLES, 'school_settings'] as $table) {
                    $snapshot['tables'][$table] = DB::table($table)->get()->map(fn ($r) => (array) $r)->all();
                }
                $path = storage_path('app/private/backups/school-'.now()->format('Ymd-His').'-'.Str::random(6).'.json.gz');
                if (! is_dir(dirname($path))) {
                    mkdir(dirname($path), 0700, true);
                }
                $bytes = gzencode(json_encode($snapshot, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE), 9);
                if (file_put_contents($path, $bytes) !== strlen($bytes)) {
                    throw new \RuntimeException('La sauvegarde a échoué : import annulé.');
                }
                chmod($path, 0600);
                if (gzdecode(file_get_contents($path)) !== json_encode($snapshot, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)) {
                    throw new \RuntimeException('Sauvegarde non vérifiable : import annulé.');
                }
            }
            // Foreign keys remain enabled; DELETE is transactional, unlike MySQL TRUNCATE.
            foreach (self::TABLES as $table) {
                if ($table === 'subjects') {
                    DB::table('subjects')->update(['teacher_id' => null]);
                }DB::table($table)->delete();
            }
            $now = now();
            $stamp = ['created_at' => $now, 'updated_at' => $now];
            $put = fn ($table, $row) => DB::table($table)->insert($row + $stamp);
            foreach ($data['years'] as $y) {
                $put('academic_years', ['id' => $y['id'], 'year_name' => $y['name'], 'start_date' => $y['start'], 'end_date' => $y['end'], 'is_current' => $y['active']]);
            }
            $year = collect($data['years'])->firstWhere('active', true)['id'];
            foreach ($data['teachers'] as $t) {
                $parts = explode(' ', $t['name'], 2);
                $put('teachers', ['id' => $t['id'], 'first_name' => $parts[0], 'last_name' => $parts[1] ?? '', 'email' => $t['email'], 'phone' => $t['phone'], 'hire_date' => '2025-10-01', 'specialization' => $t['subject'], 'status' => 'active']);
            }
            foreach ($data['classes'] as $c) {
                $put('classes', ['id' => $c['id'], 'name' => $c['name'], 'level' => $c['cycle'], 'capacity' => $c['capacity'], 'class_teacher_id' => $c['teacher'], 'academic_year_id' => $year, 'room' => $c['room']]);
            }
            foreach ($data['subjects'] as $s) {
                $put('subjects', ['id' => $s['id'], 'name' => $s['name'], 'code' => 'SUB-'.$s['id'], 'coefficient' => $s['coefficient'], 'teacher_id' => $s['teacher']]);
            }
            foreach ($data['years'] as $y) {
                for ($term = 1; $term <= 3; $term++) {
                    $start = \Carbon\Carbon::parse($y['start'])->addMonths(($term - 1) * 3);
                    $put('periods', ['id' => ($y['id'] - 1) * 3 + $term, 'academic_year_id' => $y['id'], 'name' => $term.'e trimestre', 'term_number' => $term, 'start_date' => $start->toDateString(), 'end_date' => $start->copy()->addMonths(3)->subDay()->toDateString(), 'is_current' => $y['active'] && $term === 2]);
                }
            }
            foreach ($data['students'] as $s) {
                $put('students', ['id' => $s['id'], 'matricule' => $s['matricule'], 'first_name' => $s['firstName'], 'last_name' => $s['lastName'], 'date_of_birth' => $s['birth'], 'place_of_birth' => 'Dakar', 'gender' => $s['gender'], 'parent_name' => $s['parent'], 'parent_phone' => $s['phone'], 'parent_email' => $s['email'], 'address' => $s['address'], 'status' => 'active']);
                $entry = collect($data['enrollments'])->firstWhere('studentId', $s['id']);
                $put('enrollments', ['id' => $s['id'], 'student_id' => $s['id'], 'class_id' => $s['classId'], 'academic_year_id' => $year, 'enrollment_date' => $entry['date'] ?? $s['joined'], 'status' => $entry ? 'pending' : 'confirmed']);
                $paid = collect($data['payments'])->where('studentId', $s['id'])->where('type', 'Scolarité')->sum('amount');
                $put('tuitions', ['id' => $s['id'], 'student_id' => $s['id'], 'academic_year_id' => $year, 'period_id' => 2, 'total_amount' => 150000, 'paid_amount' => $paid, 'remaining_amount' => 150000 - $paid, 'due_date' => '2026-03-31', 'status' => $paid >= 150000 ? 'paid' : ($paid > 0 ? 'partial' : 'pending')]);
            }
            foreach ($data['payments'] as $p) {
                $put('payments', ['id' => $p['id'], 'student_id' => $p['studentId'], 'tuition_id' => $p['type'] === 'Scolarité' ? $p['studentId'] : null, 'payment_type' => $p['type'] === 'Scolarité' ? 'tuition' : 'other', 'amount' => $p['amount'], 'payment_method' => match ($p['method']) {
                    'Espèces' => 'cash','Virement' => 'bank_transfer',default => 'mobile_money'
                }, 'display_type' => $p['type'], 'display_method' => $p['method'], 'payment_date' => $p['date'], 'receipt_number' => $p['reference']]);
            }
            foreach ($data['subscriptions'] as $s) {
                $table = match ($s['service']) {
                    'Cantine' => 'canteen_subscriptions','Transport' => 'transport_subscriptions',default => 'evening_studies'
                };
                $row = ['id' => $s['id'], 'student_id' => $s['studentId'], 'academic_year_id' => $year, 'monthly_fee' => $s['amount'], 'plan_label' => $s['plan'], 'status' => $s['status'] === 'Actif' ? 'active' : 'suspended'];
                $row += $table === 'transport_subscriptions' ? ['route' => $s['plan'], 'pickup_point' => 'Dakar', 'subscription_type' => 'round_trip'] : ['subscription_type' => 'monthly', 'start_date' => '2026-03-01', 'end_date' => '2026-03-31'];
                $put($table, $row);
            }
            foreach ($data['timetable'] as $l) {
                $put('timetables', ['id' => $l['id'], 'class_id' => $l['classId'], 'subject_id' => $l['subjectId'], 'teacher_id' => $l['teacherId'], 'academic_year_id' => $year, 'day_of_week' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'][$l['day']], 'start_time' => sprintf('%02d:00:00', $l['start']), 'end_time' => sprintf('%02d:00:00', $l['end']), 'room' => $l['room']]);
            }
            $grades = [];
            foreach ($data['grades'] as $key => $value) {
                [$student,$subject,$term,$kind] = explode('-', $key);
                $s = $data['students'][(int) $student - 1];
                $grades[] = ['student_id' => (int) $student, 'subject_id' => (int) $subject, 'period_id' => (int) $term, 'class_id' => $s['classId'], 'grade_type' => $kind === 'test' ? 'homework' : 'exam', 'score' => $value, 'max_score' => 20, 'grade_date' => ['1' => '2025-12-15', '2' => '2026-03-15', '3' => '2026-06-15'][$term], 'teacher_id' => (int) $subject] + $stamp;
            }
            foreach (array_chunk($grades, 300) as $chunk) {
                DB::table('grades')->insert($chunk);
            }
            $values = array_intersect_key($data['settings'], array_flip(['school', 'city', 'phone', 'email', 'address']));
            $values['tuitionFee'] = 150000;
            DB::table('school_settings')->where('id', 1)->update(['values' => json_encode($values), 'revision' => $settings->revision + 1, 'updated_at' => $now]);

            return $path;
        }, 3);
    }
}
