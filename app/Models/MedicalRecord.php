<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'provider_id',
        'facility_id',
        'record_date',
        'visit_type',
        'diagnosis',
        'treatment_plan',
        'medications',
        'vital_signs',
        'notes',
        'status',
    ];

    protected $casts = [
        'record_date' => 'datetime',
        'vital_signs' => 'json',
        'medications' => 'json',
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
