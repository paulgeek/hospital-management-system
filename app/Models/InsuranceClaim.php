<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'claim_id',
        'patient_id',
        'facility_id',
        'claim_date',
        'service_date',
        'claim_amount',
        'approved_amount',
        'claim_status',
        'service_description',
        'medical_record_id',
        'submitted_by',
        'reviewed_by',
        'rejection_reason',
    ];

    protected $casts = [
        'claim_date' => 'date',
        'service_date' => 'date',
        'claim_amount' => 'float',
        'approved_amount' => 'float',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function facility()
    {
        return $this->belongsTo(HealthcareFacility::class);
    }

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }
}
