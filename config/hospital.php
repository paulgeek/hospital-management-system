<?php

return [
    'app_name' => 'Ghana Hospital Management System',
    
    'facilities' => [
        'types' => ['Hospital', 'Clinic', 'Pharmacy', 'Laboratory', 'Diagnostic Center'],
    ],

    'patients' => [
        'statuses' => ['active', 'inactive', 'transferred', 'deceased'],
        'blood_types' => ['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'],
    ],

    'appointments' => [
        'statuses' => ['scheduled', 'completed', 'cancelled', 'no-show', 'rescheduled'],
    ],

    'nhis' => [
        'member_categories' => ['Vulnerable', 'Indigent', 'SSNIT', 'Private', 'Informal'],
        'statuses' => ['active', 'inactive', 'suspended', 'expired'],
        'payment_methods' => ['Cash', 'Check', 'Bank Transfer', 'Mobile Money', 'Insurance'],
    ],

    'claims' => [
        'statuses' => ['draft', 'submitted', 'under_review', 'approved', 'rejected', 'paid'],
    ],

    'medical_records' => [
        'visit_types' => ['Consultation', 'Follow-up', 'Emergency', 'Admission', 'Discharge'],
        'statuses' => ['draft', 'completed', 'signed', 'archived'],
    ],

    'roles' => [
        'administrator' => 'Administrator',
        'doctor' => 'Doctor',
        'nurse' => 'Nurse',
        'pharmacist' => 'Pharmacist',
        'patient' => 'Patient',
        'nhis_officer' => 'NHIS Officer',
        'finance' => 'Finance Officer',
    ],

    'ghana_regions' => [
        'Greater Accra',
        'Ashanti',
        'Central',
        'Northern',
        'Volta',
        'Eastern',
        'Western',
        'Upper East',
        'Upper West',
        'Brong-Ahafo',
        'North East',
        'Savanna',
        'Ahafo',
        'Oti',
    ],
];
