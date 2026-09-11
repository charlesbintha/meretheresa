<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransportSubscription extends Model
{
    protected $fillable = [
        'student_id',
        'academic_year_id',
        'route',
        'pickup_point',
        'subscription_type',
        'monthly_fee',
        'status',
    ];

    protected $casts = [
        'monthly_fee' => 'decimal:2',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
