<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'provider_id',
        'facility_id',
        'appointment_date',
        'appointment_time',
        'department',
        'reason',
        'status',
        'notes',
        'reminder_sent',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'reminder_sent' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function facility()
    {
        return $this->belongsTo(HealthcareFacility::class);
    }
}
