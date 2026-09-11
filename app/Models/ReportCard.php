<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportCard extends Model
{
    protected $fillable = [
        'student_id',
        'class_id',
        'period_id',
        'academic_year_id',
        'total_score',
        'average',
        'rank',
        'teacher_comment',
        'principal_comment',
        'generated_at',
    ];

    protected $casts = [
        'total_score' => 'decimal:2',
        'average' => 'decimal:2',
        'rank' => 'integer',
        'generated_at' => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
