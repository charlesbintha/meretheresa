<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicYear extends Model
{
    protected $fillable = [
        'year_name',
        'start_date',
        'end_date',
        'is_current',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    public function classRooms(): HasMany
    {
        return $this->hasMany(ClassRoom::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function tuitions(): HasMany
    {
        return $this->hasMany(Tuition::class);
    }

    public function canteenSubscriptions(): HasMany
    {
        return $this->hasMany(CanteenSubscription::class);
    }

    public function transportSubscriptions(): HasMany
    {
        return $this->hasMany(TransportSubscription::class);
    }

    public function periods(): HasMany
    {
        return $this->hasMany(Period::class);
    }

    public function reportCards(): HasMany
    {
        return $this->hasMany(ReportCard::class);
    }
}
