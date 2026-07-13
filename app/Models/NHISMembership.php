<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NHISMembership extends Model
{
    use HasFactory;

    protected $table = 'nhis_memberships';

    protected $fillable = [
        'patient_id',
        'nhis_number',
        'member_category',
        'registration_date',
        'expiry_date',
        'subscription_status',
        'premium_paid',
        'payment_method',
        'renewal_date',
        'exemption_status',
        'exemption_reason',
    ];

    protected $casts = [
        'registration_date' => 'date',
        'expiry_date' => 'date',
        'renewal_date' => 'date',
        'premium_paid' => 'float',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function isPolicyActive()
    {
        return $this->subscription_status === 'active' && now() < $this->expiry_date;
    }
}
