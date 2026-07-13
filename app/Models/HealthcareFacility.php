<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthcareFacility extends Model
{
    use HasFactory;

    protected $fillable = [
        'facility_code',
        'facility_name',
        'facility_type',
        'region',
        'district',
        'town',
        'address',
        'phone',
        'email',
        'nhis_accredited',
        'accreditation_number',
        'license_number',
        'director_name',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function insuranceClaims()
    {
        return $this->hasMany(InsuranceClaim::class);
    }
}
