<?php

namespace App\Http\Controllers\Admin;

use App\Models\Appointment;
use App\Models\HealthcareFacility;
use App\Models\InsuranceClaim;
use App\Models\MedicalRecord;
use App\Models\NHISMembership;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController
{
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'total_patients' => Patient::count(),
            'total_appointments' => Appointment::count(),
            'pending_appointments' => Appointment::where('status', 'scheduled')->count(),
            'active_nhis_members' => NHISMembership::where('subscription_status', 'active')->count(),
            'pending_claims' => InsuranceClaim::where('claim_status', 'submitted')->count(),
            'total_users' => User::count(),
            'total_facilities' => HealthcareFacility::where('status', 'active')->count(),
            'total_medical_records' => MedicalRecord::count(),
        ];

        $recent_appointments = Appointment::with(['patient', 'facility'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recent_claims = InsuranceClaim::with(['patient', 'facility'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $patient_distribution = Patient::select('facility_id')
            ->groupBy('facility_id')
            ->with('facility')
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_appointments', 'recent_claims', 'patient_distribution', 'user'));
    }
}
