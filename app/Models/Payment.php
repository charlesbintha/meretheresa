<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'student_id',
        'tuition_id',
        'payment_type',
        'amount',
        'payment_method',
        'payment_date',
        'receipt_number',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function tuition(): BelongsTo
    {
        return $this->belongsTo(Tuition::class);
    }

    /**
     * Get status attribute for subscription payments
     */
    public function getStatusAttribute()
    {
        return $this->payment_method === 'pending' ? 'unpaid' : 'paid';
    }

    /**
     * Scope for canteen payments
     */
    public function scopeCanteen($query)
    {
        return $query->where('payment_type', 'canteen');
    }

    /**
     * Scope for transport payments
     */
    public function scopeTransport($query)
    {
        return $query->where('payment_type', 'transport');
    }

    /**
     * Scope for tuition payments
     */
    public function scopeTuition($query)
    {
        return $query->where('payment_type', 'tuition');
    }

    /**
     * Scope for pending payments
     */
    public function scopePending($query)
    {
        return $query->where('payment_method', 'pending');
    }

    /**
     * Scope for paid payments
     */
    public function scopePaid($query)
    {
        return $query->where('payment_method', '!=', 'pending');
    }
}
