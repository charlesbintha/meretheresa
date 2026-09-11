<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SchoolStore
{
    public const DAYS = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

    public const SERVICES = ['Cantine' => 'canteen_subscriptions', 'Transport' => 'transport_subscriptions', 'Études du soir' => 'evening_studies'];

    private function fail(string $message): never
    {
        throw ValidationException::withMessages(['record' => $message]);
    }

    public function year(): int
    {
        return (int) (DB::table('academic_years')->where('is_current', true)->value('id') ?? 0);
    }

    private function period(int $term = 2): int
    {
        return (int) (DB::table('periods')->where('academic_year_id', $this->year())->where('term_number', $term)->value('id') ?? 0);
    }

    private function requiredYear(): int
    {
        $y = $this->year();
        if (! $y) {
            $this->fail('Créez puis activez une année scolaire.');
        }

return $y;
    }

    private function row(string $table, int|string $id): object
    {
        return DB::table($table)->find($id) ?? abort(404);
    }

    private function rules(array $payload, array $rules): array
    {
        return Validator::make($payload, $rules)->validate();
    }

    private function write(string $table, ?int $id, array $values): int
    {
        $values['updated_at'] = now();
        if ($id) {
            $this->row($table, $id);
            DB::table($table)->where('id', $id)->update($values);

            return $id;
        }

return DB::table($table)->insertGetId($values + ['created_at' => now()]);
    }

    private function currentClass(int $id): object
    {
        $c = $this->row('classes', $id);
        if ((int) $c->academic_year_id !== $this->year()) {
            $this->fail('La classe ne fait pas partie de l’année active.');
        }

return $c;
    }

    private function capacity(int $class, ?int $student = null): void
    {
        $c = $this->currentClass($class);
        $q = DB::table('enrollments')->where('class_id', $class)->where('academic_year_id', $this->year())->whereIn('status', ['confirmed', 'pending']);
        if ($student) {
            $q->where('student_id', '!=', $student);
        }if ($q->count() >= $c->capacity) {
            $this->fail('Cette classe est complète.');
        }
    }

    public function state(int $user): array
    {
        $y = $this->year();
        $settings = DB::table('school_settings')->find(1);
        $values = json_decode($settings->values, true);
        $pref = json_decode(DB::table('school_preferences')->where('user_id', $user)->value('values') ?? '{}', true);
        $classes = DB::table('classes')->where('academic_year_id', $y)->get();
        $enrollments = DB::table('enrollments')->where('academic_year_id', $y)->get()->keyBy('student_id');
        $students = DB::table('students')->whereIn('id', $enrollments->keys())->get();
        $periods = DB::table('periods')->where('academic_year_id', $y)->get()->keyBy('id');
        $grades = [];
        foreach (DB::table('grades')->whereIn('period_id', $periods->keys())->whereIn('grade_type', ['homework', 'exam'])->orderBy('id')->get() as $g) {
            $term = $periods[$g->period_id]->term_number;
            $kind = $g->grade_type === 'homework' ? 'test' : 'exam';
            $grades["{$g->student_id}-{$g->subject_id}-{$term}-{$kind}"] = (float) $g->score;
        }
        $subs = [];
        foreach (self::SERVICES as $service => $table) {
            foreach (DB::table($table)->where('academic_year_id', $y)->get() as $s) {
                $subs[] = ['id' => $table.':'.$s->id, 'studentId' => (int) $s->student_id, 'service' => $service, 'plan' => $s->plan_label ?? ($s->route ?? $s->notes ?? ''), 'amount' => (float) $s->monthly_fee, 'status' => $s->status === 'active' ? 'Actif' : 'Suspendu'];
            }
        }
        $year = DB::table('academic_years')->find($y);
        $payments = DB::table('payments')->whereIn('student_id', $students->pluck('id'))->where(function ($q) use ($y, $year) {
            $q->whereIn('tuition_id', DB::table('tuitions')->where('academic_year_id', $y)->select('id'));
            if ($year) {
                $q->orWhere(fn ($q) => $q->whereNull('tuition_id')->whereBetween('payment_date', [$year->start_date, $year->end_date]));
            }
        })->get();

        return ['version' => 2, 'revision' => (int) $settings->revision, 'activeYear' => $y, 'students' => $students->map(function ($s) use ($enrollments) {
            $e = $enrollments[$s->id];

            return ['id' => $s->id, 'matricule' => $s->matricule, 'firstName' => $s->first_name, 'lastName' => $s->last_name, 'birth' => $s->date_of_birth, 'gender' => $s->gender, 'parent' => $s->parent_name, 'phone' => $s->parent_phone, 'email' => $s->parent_email ?? '', 'address' => $s->address, 'classId' => (int) $e->class_id, 'status' => $s->status !== 'active' || $e->status === 'cancelled' ? 'Archivé' : ($e->status === 'pending' ? 'En attente' : 'Actif'), 'joined' => $e->enrollment_date];
        })->all(),
            'classes' => $classes->map(fn ($c) => ['id' => $c->id, 'name' => $c->name, 'cycle' => $c->level, 'capacity' => (int) $c->capacity, 'teacher' => (int) $c->class_teacher_id, 'room' => $c->room ?? ''])->all(),
            'teachers' => DB::table('teachers')->get()->map(fn ($t) => ['id' => $t->id, 'name' => trim($t->first_name.' '.$t->last_name), 'email' => $t->email, 'phone' => $t->phone ?? '', 'subject' => $t->specialization ?? '', 'status' => $t->status === 'active' ? 'Actif' : 'Archivé'])->all(),
            'subjects' => DB::table('subjects')->get()->map(fn ($s) => ['id' => $s->id, 'name' => $s->name, 'coefficient' => (int) $s->coefficient, 'teacher' => (int) $s->teacher_id])->all(),
            'years' => DB::table('academic_years')->get()->map(fn ($a) => ['id' => $a->id, 'name' => $a->year_name, 'start' => $a->start_date, 'end' => $a->end_date, 'active' => (bool) $a->is_current])->all(),
            'enrollments' => $enrollments->values()->map(fn ($e) => ['id' => $e->id, 'studentId' => (int) $e->student_id, 'date' => $e->enrollment_date, 'approvedDate' => $e->approved_date, 'status' => match ($e->status) {
                'pending' => 'En attente','confirmed' => 'Validée',default => 'Refusée'
            }])->all(),
            'payments' => $payments->map(fn ($p) => ['id' => $p->id, 'studentId' => (int) $p->student_id, 'amount' => (float) $p->amount, 'date' => $p->payment_date, 'reference' => $p->receipt_number, 'type' => $p->display_type ?? match ($p->payment_type) {
                'tuition' => 'Scolarité','canteen' => 'Cantine','transport' => 'Transport',default => 'Autre'
            }, 'method' => $p->display_method ?? match ($p->payment_method) {
                'cash' => 'Espèces','bank_transfer' => 'Virement','check' => 'Chèque',default => 'Mobile Money'
            }])->all(),
            'tuitions' => DB::table('tuitions')->where('academic_year_id', $y)->get()->map(fn ($t) => ['id' => $t->id, 'studentId' => (int) $t->student_id, 'total' => (float) $t->total_amount, 'paid' => (float) $t->paid_amount, 'balance' => (float) $t->remaining_amount, 'dueDate' => $t->due_date, 'term' => (int) ($periods[$t->period_id]->term_number ?? 2)])->all(),
            'timetable' => DB::table('timetables')->where('academic_year_id', $y)->get()->map(fn ($l) => ['id' => $l->id, 'classId' => (int) $l->class_id, 'subjectId' => (int) $l->subject_id, 'teacherId' => (int) $l->teacher_id, 'day' => array_search($l->day_of_week, self::DAYS), 'start' => (int) substr($l->start_time, 0, 2), 'end' => (int) substr($l->end_time, 0, 2), 'room' => $l->room ?? ''])->all(),
            'subscriptions' => $subs, 'grades' => (object) $grades, 'settings' => $values + ['theme' => $pref['theme'] ?? 'light', 'compact' => $pref['compact'] ?? false], 'widgets' => $pref['widgets'] ?? ['revenue', 'enrollments', 'activity', 'collections', 'agenda'], 'notificationsRead' => $pref['notificationsRead'] ?? false, 'user' => ['name' => DB::table('users')->where('id', $user)->value('name')]];
    }

    public function command(string $action, array $v, ?string $id, int $user, int $revision): array
    {
        return DB::transaction(function () use ($action, $v, $id, $user, $revision) {
            $s = DB::table('school_settings')->where('id', 1)->lockForUpdate()->first();
            if ($action === 'payment' && ! empty($v['requestKey']) && ($p = DB::table('payments')->where('request_key', $v['requestKey'])->first())) {
                return ['recordId' => $p->id, 'state' => $this->state($user)];
            }
            abort_if((int) $s->revision !== $revision, 409, 'Les données ont changé. Actualisez puis réessayez.');
            $record = match ($action) {
                'student' => $this->student($v, $id),'teacher' => $this->teacher($v, $id),'class' => $this->classroom($v, $id),'subject' => $this->subject($v, $id),'year' => $this->academicYear($v, $id),'year-activate' => $this->activate($id),'enrollment' => $this->enrollment($v),'enrollment-approve' => $this->decide($id, true),'enrollment-reject' => $this->decide($id, false),'payment' => $this->payment($v),'subscription' => $this->subscription($v),'subscription-toggle' => $this->toggleSubscription($id),'lesson' => $this->lesson($v, $id),'lesson-delete' => $this->deleteLesson($id),'grades' => $this->grades($v),'settings' => $this->settings($v),'preferences' => $this->preferences($v, $user),default => abort(404)
            };
            DB::table('school_settings')->where('id', 1)->update(['revision' => $s->revision + 1, 'updated_at' => now()]);
            DB::table('school_audit_logs')->insert(['user_id' => $user, 'action' => $action, 'record_id' => (string) $record, 'created_at' => now(), 'updated_at' => now()]);

            return ['recordId' => $record, 'state' => $this->state($user)];
        }, 3);
    }

    private function charge(int $student, int $year): void
    {
        if (DB::table('tuitions')->where('student_id', $student)->where('academic_year_id', $year)->exists()) {
            return;
        }$values = json_decode(DB::table('school_settings')->find(1)->values, true);
        $fee = $values['tuitionFee'] ?? 150000;
        $period = DB::table('periods')->where('academic_year_id', $year)->where('is_current', true)->first() ?? DB::table('periods')->where('academic_year_id', $year)->first();
        $this->write('tuitions', null, ['student_id' => $student, 'academic_year_id' => $year, 'period_id' => $period?->id, 'total_amount' => $fee, 'paid_amount' => 0, 'remaining_amount' => $fee, 'due_date' => $period?->end_date ?? today()->toDateString(), 'status' => 'pending']);
    }

    private function student(array $v, ?string $id): int
    {
        $v = $this->rules($v, ['firstName' => 'required|string|max:60', 'lastName' => 'required|string|max:60', 'birth' => 'required|date|before_or_equal:today', 'gender' => 'required|in:F,M', 'classId' => 'required|integer|exists:classes,id', 'status' => 'required|in:Actif,En attente,Archivé', 'parent' => 'required|string|max:100', 'phone' => 'required|string|min:8|max:25', 'email' => 'nullable|email|max:191', 'address' => 'nullable|string|max:500']);
        $year = $this->requiredYear();
        $this->capacity($v['classId'], $id ? (int) $id : null);
        $values = ['first_name' => $v['firstName'], 'last_name' => $v['lastName'], 'date_of_birth' => $v['birth'], 'place_of_birth' => 'Dakar', 'gender' => $v['gender'], 'parent_name' => $v['parent'], 'parent_phone' => $v['phone'], 'parent_email' => $v['email'] ?? null, 'address' => $v['address'] ?? '', 'status' => $v['status'] === 'Archivé' ? 'inactive' : 'active'];
        if (! $id) {
            $values['matricule'] = 'MT-'.now()->format('y').'-'.strtoupper(Str::random(10));
        }
        $sid = $this->write('students', $id ? (int) $id : null, $values);
        $entry = DB::table('enrollments')->where('student_id', $sid)->where('academic_year_id', $year)->first();
        $this->write('enrollments', $entry?->id, ['student_id' => $sid, 'class_id' => $v['classId'], 'academic_year_id' => $year, 'enrollment_date' => $entry?->enrollment_date ?? today()->toDateString(), 'status' => match ($v['status']) {
            'Actif' => 'confirmed','En attente' => 'pending',default => 'cancelled'
        }, 'approved_date' => $v['status'] === 'Actif' ? ($entry?->approved_date ?? today()->toDateString()) : null]);
        $this->charge($sid, $year);

        return $sid;
    }

    private function teacher(array $v, ?string $id): int
    {
        $v = $this->rules($v, ['name' => 'required|string|max:100', 'email' => ['required', 'email', 'max:191', Rule::unique('teachers', 'email')->ignore($id)], 'phone' => 'required|string|min:8|max:25', 'subject' => 'required|string|max:100']);
        $name = explode(' ', $v['name'], 2);

        return $this->write('teachers', $id ? (int) $id : null, ['first_name' => $name[0], 'last_name' => $name[1] ?? '', 'email' => $v['email'], 'phone' => $v['phone'], 'specialization' => $v['subject'], 'hire_date' => $id ? $this->row('teachers', $id)->hire_date : today()->toDateString(), 'status' => 'active']);
    }

    private function classroom(array $v, ?string $id): int
    {
        $y = $this->requiredYear();
        $v = $this->rules($v, ['name' => ['required', 'string', 'max:35', Rule::unique('classes', 'name')->where('academic_year_id', $y)->ignore($id)], 'cycle' => 'required|in:Maternelle,Élémentaire,Collège,Lycée', 'capacity' => 'required|integer|min:1|max:100', 'teacher' => 'required|integer|exists:teachers,id', 'room' => 'required|string|max:40']);
        if ($id) {
            $this->currentClass((int) $id);
            if (DB::table('enrollments')->where('class_id', $id)->whereIn('status', ['pending', 'confirmed'])->count() > $v['capacity']) {
                $this->fail('Capacité inférieure au nombre d’élèves.');
            }
        }

return $this->write('classes', $id ? (int) $id : null, ['name' => $v['name'], 'level' => $v['cycle'], 'capacity' => $v['capacity'], 'class_teacher_id' => $v['teacher'], 'room' => $v['room'], 'academic_year_id' => $y]);
    }

    private function subject(array $v, ?string $id): int
    {
        $v = $this->rules($v, ['name' => ['required', 'string', 'max:60', Rule::unique('subjects', 'name')->ignore($id)], 'coefficient' => 'required|integer|min:1|max:10', 'teacher' => 'required|integer|exists:teachers,id']);
        $values = ['name' => $v['name'], 'coefficient' => $v['coefficient'], 'teacher_id' => $v['teacher']];
        if (! $id) {
            $values['code'] = 'SUB-'.strtoupper(Str::random(10));
        }

return $this->write('subjects', $id ? (int) $id : null, $values);
    }

    private function academicYear(array $v, ?string $id): int
    {
        $v = $this->rules($v, ['name' => ['required', 'string', 'max:30', Rule::unique('academic_years', 'year_name')->ignore($id)], 'start' => 'required|date', 'end' => 'required|date|after:start']);
        $y = $this->write('academic_years', $id ? (int) $id : null, ['year_name' => $v['name'], 'start_date' => $v['start'], 'end_date' => $v['end']] + (! $id ? ['is_current' => ! DB::table('academic_years')->exists()] : []));
        if (! $id) {
            for ($term = 1; $term <= 3; $term++) {
                $start = \Carbon\Carbon::parse($v['start'])->addMonths(($term - 1) * 3);
                $this->write('periods', null, ['academic_year_id' => $y, 'name' => $term.'e trimestre', 'term_number' => $term, 'start_date' => $start->toDateString(), 'end_date' => $start->copy()->addMonths(3)->subDay()->toDateString(), 'is_current' => $term === 2]);
            }
        }

return $y;
    }

    private function activate(?string $id): int
    {
        $this->row('academic_years', (int) $id);
        DB::table('academic_years')->update(['is_current' => false]);
        DB::table('academic_years')->where('id', $id)->update(['is_current' => true]);

        return (int) $id;
    }

    private function enrollment(array $v): int
    {
        $v = $this->rules($v, ['studentId' => 'required|integer|exists:students,id', 'classId' => 'required|integer|exists:classes,id', 'date' => 'required|date']);
        $y = $this->requiredYear();
        $this->capacity($v['classId'], $v['studentId']);
        $entry = DB::table('enrollments')->where('student_id', $v['studentId'])->where('academic_year_id', $y)->first();
        if ($entry && $entry->status !== 'cancelled') {
            $this->fail('Une inscription existe déjà pour cette année.');
        }$id = $this->write('enrollments', $entry?->id, ['student_id' => $v['studentId'], 'class_id' => $v['classId'], 'academic_year_id' => $y, 'enrollment_date' => $v['date'], 'status' => 'pending']);
        DB::table('students')->where('id', $v['studentId'])->update(['status' => 'active']);
        $this->charge($v['studentId'], $y);

        return $id;
    }

    private function decide(?string $id, bool $approve): int
    {
        $e = $this->row('enrollments', (int) $id);
        if ((int) $e->academic_year_id !== $this->year()) {
            $this->fail('Année scolaire inactive.');
        }if ($e->status !== 'pending') {
            $this->fail('Cette demande a déjà été traitée.');
        }if ($approve) {
            $this->capacity($e->class_id, $e->student_id);
        }DB::table('enrollments')->where('id', $id)->update(['status' => $approve ? 'confirmed' : 'cancelled', 'approved_date' => $approve ? today()->toDateString() : null, 'updated_at' => now()]);

        return (int) $id;
    }

    private function payment(array $v): int
    {
        $v = $this->rules($v, ['studentId' => 'required|integer|exists:students,id', 'amount' => 'required|integer|min:1|max:10000000', 'type' => 'required|in:Scolarité,Inscription,Cantine,Transport,Études du soir', 'method' => 'required|in:Wave,Espèces,Orange Money,Virement', 'date' => 'required|date', 'notes' => 'nullable|string|max:300', 'requestKey' => 'required|uuid']);
        $y = $this->requiredYear();
        $year = $this->row('academic_years', $y);
        if ($v['date'] < $year->start_date || $v['date'] > $year->end_date) {
            $this->fail('Le paiement doit appartenir à l’année active.');
        }if (! DB::table('enrollments')->where('student_id', $v['studentId'])->where('academic_year_id', $y)->exists()) {
            $this->fail('Élève non inscrit cette année.');
        }
        $tuition = null;
        if ($v['type'] === 'Scolarité') {
            $tuition = DB::table('tuitions')->where('student_id', $v['studentId'])->where('academic_year_id', $y)->where('remaining_amount', '>', 0)->orderBy('due_date')->lockForUpdate()->first();
            if (! $tuition || $v['amount'] > (float) $tuition->remaining_amount) {
                $this->fail('Le montant dépasse le solde de l’échéance de scolarité.');
            }DB::table('tuitions')->where('id', $tuition->id)->update(['paid_amount' => (float) $tuition->paid_amount + $v['amount'], 'remaining_amount' => (float) $tuition->remaining_amount - $v['amount'], 'status' => (float) $tuition->remaining_amount == (float) $v['amount'] ? 'paid' : 'partial', 'updated_at' => now()]);
        }
        $id = $this->write('payments', null, ['student_id' => $v['studentId'], 'tuition_id' => $tuition?->id, 'payment_type' => match ($v['type']) {
            'Scolarité' => 'tuition','Cantine' => 'canteen','Transport' => 'transport',default => 'other'
        }, 'display_type' => $v['type'], 'payment_method' => match ($v['method']) {
            'Espèces' => 'cash','Virement' => 'bank_transfer',default => 'mobile_money'
        }, 'display_method' => $v['method'], 'amount' => $v['amount'], 'payment_date' => $v['date'], 'receipt_number' => 'REC-'.now()->format('Y').'-'.strtoupper(Str::random(12)), 'request_key' => $v['requestKey'], 'notes' => $v['notes'] ?? null]);

        return $id;
    }

    private function subscription(array $v): string
    {
        $v = $this->rules($v, ['studentId' => 'required|integer|exists:students,id', 'service' => ['required', Rule::in(array_keys(self::SERVICES))], 'plan' => 'required|string|max:100', 'amount' => 'required|integer|min:1|max:1000000']);
        $y = $this->requiredYear();
        $table = self::SERVICES[$v['service']];
        if (DB::table($table)->where('student_id', $v['studentId'])->where('academic_year_id', $y)->exists()) {
            $this->fail('Un abonnement existe déjà pour cet élève.');
        }$year = $this->row('academic_years', $y);
        $values = ['student_id' => $v['studentId'], 'academic_year_id' => $y, 'plan_label' => $v['plan'], 'monthly_fee' => $v['amount'], 'status' => 'active'];
        $values += $table === 'transport_subscriptions' ? ['route' => $v['plan'], 'pickup_point' => 'À préciser', 'subscription_type' => 'round_trip'] : ['subscription_type' => 'monthly', 'start_date' => $year->start_date, 'end_date' => $year->end_date];

        return $table.':'.$this->write($table, null, $values);
    }

    private function toggleSubscription(?string $id): string
    {
        [$table,$key] = array_pad(explode(':', $id ?? ''), 2, null);
        if (! in_array($table, self::SERVICES, true) || ! ctype_digit($key ?? '')) {
            abort(404);
        }$s = $this->row($table, $key);
        if ((int) $s->academic_year_id !== $this->year()) {
            $this->fail('Année scolaire inactive.');
        }DB::table($table)->where('id', $key)->update(['status' => $s->status === 'active' ? 'suspended' : 'active', 'updated_at' => now()]);

        return $id;
    }

    private function lesson(array $v, ?string $id): int
    {
        $v = $this->rules($v, ['classId' => 'required|integer|exists:classes,id', 'subjectId' => 'required|integer|exists:subjects,id', 'teacherId' => 'required|integer|exists:teachers,id', 'day' => 'required|integer|min:0|max:4', 'start' => ['required', 'integer', Rule::in([8, 10, 14, 16])], 'room' => 'required|string|max:40']);
        $y = $this->requiredYear();
        $this->currentClass($v['classId']);
        if ($id && (int) $this->row('timetables', $id)->academic_year_id !== $y) {
            $this->fail('Année scolaire inactive.');
        }$start = sprintf('%02d:00:00', $v['start']);
        $end = sprintf('%02d:00:00', $v['start'] + 2);
        $q = DB::table('timetables')->where('academic_year_id', $y)->where('day_of_week', self::DAYS[$v['day']])->where('start_time', '<', $end)->where('end_time', '>', $start)->where(fn ($q) => $q->where('class_id', $v['classId'])->orWhere('teacher_id', $v['teacherId'])->orWhere('room', $v['room']));
        if ($id) {
            $q->where('id', '!=', $id);
        }if ($q->exists()) {
            $this->fail('Créneau occupé pour la classe, l’enseignant ou la salle.');
        }

return $this->write('timetables', $id ? (int) $id : null, ['class_id' => $v['classId'], 'subject_id' => $v['subjectId'], 'teacher_id' => $v['teacherId'], 'academic_year_id' => $y, 'day_of_week' => self::DAYS[$v['day']], 'start_time' => $start, 'end_time' => $end, 'room' => $v['room']]);
    }

    private function deleteLesson(?string $id): int
    {
        $l = $this->row('timetables', (int) $id);
        if ((int) $l->academic_year_id !== $this->year()) {
            $this->fail('Année scolaire inactive.');
        }DB::table('timetables')->where('id', $id)->delete();

        return (int) $id;
    }

    private function grades(array $v): int
    {
        $v = $this->rules($v, ['classId' => 'required|integer|exists:classes,id', 'subjectId' => 'required|integer|exists:subjects,id', 'term' => 'required|integer|min:1|max:3', 'rows' => 'required|array|min:1|max:100', 'rows.*.studentId' => 'required|integer|distinct|exists:students,id', 'rows.*.test' => 'required|numeric|min:0|max:20', 'rows.*.exam' => 'required|numeric|min:0|max:20']);
        $class = $this->currentClass($v['classId']);
        $period = $this->period($v['term']);
        if (! $period) {
            $this->fail('Trimestre introuvable.');
        }$teacher = DB::table('subjects')->where('id', $v['subjectId'])->value('teacher_id') ?: $class->class_teacher_id;
        if (! $teacher) {
            $this->fail('Affectez un enseignant à cette matière.');
        }foreach ($v['rows'] as $r) {
            if (! DB::table('enrollments')->where('class_id', $class->id)->where('student_id', $r['studentId'])->where('academic_year_id', $this->year())->where('status', 'confirmed')->exists()) {
                $this->fail('Un élève n’est pas inscrit dans cette classe.');
            }foreach (['test' => 'homework', 'exam' => 'exam'] as $kind => $type) {
                $lookup = ['student_id' => $r['studentId'], 'subject_id' => $v['subjectId'], 'period_id' => $period, 'grade_type' => $type];
                $old = DB::table('grades')->where($lookup)->first();
                $this->write('grades', $old?->id, $lookup + ['class_id' => $class->id, 'score' => $r[$kind], 'max_score' => 20, 'grade_date' => today()->toDateString(), 'teacher_id' => $teacher]);
            }
        }

return count($v['rows']);
    }

    private function settings(array $v): int
    {
        $v = $this->rules($v, ['school' => 'required|string|max:100', 'city' => 'required|string|max:100', 'email' => 'required|email|max:191', 'phone' => 'required|string|max:25', 'address' => 'required|string|max:500', 'tuitionFee' => 'sometimes|integer|min:0|max:10000000']);
        $current = json_decode(DB::table('school_settings')->find(1)->values, true);
        DB::table('school_settings')->where('id', 1)->update(['values' => json_encode(array_replace($current, $v))]);

        return 1;
    }

    private function preferences(array $v, int $user): int
    {
        $v = $this->rules($v, ['theme' => 'sometimes|in:light,dark', 'compact' => 'sometimes|boolean', 'notificationsRead' => 'sometimes|boolean', 'widgets' => 'sometimes|array|max:6', 'widgets.*' => ['string', 'distinct', Rule::in(['revenue', 'enrollments', 'activity', 'collections', 'agenda', 'distribution'])]]);
        $p = DB::table('school_preferences')->where('user_id', $user)->first();
        $values = array_replace(json_decode($p?->values ?? '{}', true), $v);

        return $this->write('school_preferences', $p?->id, ['user_id' => $user, 'values' => json_encode($values)]);
    }
}
