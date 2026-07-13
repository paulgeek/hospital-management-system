<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'phone',
        'email',
        'national_id',
        'address',
        'region',
        'district',
        'town',
        'facility_id',
        'user_id',
        'blood_type',
        'allergy_information',
        'emergency_contact',
        'emergency_contact_phone',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function facility()
    {
        return $this->belongsTo(HealthcareFacility::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function insurance()
    {
        return $this->hasOne(NHISMembership::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function insuranceClaims()
    {
        return $this->hasMany(InsuranceClaim::class);
    }
}
