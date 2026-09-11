<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    protected $fillable = [
        'matricule',
        'first_name',
        'last_name',
        'date_of_birth',
        'place_of_birth',
        'gender',
        'parent_name',
        'parent_phone',
        'parent_email',
        'address',
        'photo',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function studentDocuments(): HasMany
    {
        return $this->hasMany(StudentDocument::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function tuitions(): HasMany
    {
        return $this->hasMany(Tuition::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function canteenSubscription(): HasOne
    {
        return $this->hasOne(CanteenSubscription::class);
    }

    public function transportSubscription(): HasOne
    {
        return $this->hasOne(TransportSubscription::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function reportCards(): HasMany
    {
        return $this->hasMany(ReportCard::class);
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }
}
