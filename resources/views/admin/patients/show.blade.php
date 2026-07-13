@extends('layouts.app')

@section('title', $patient->full_name)

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">{{ $patient->full_name }}</h1>
            <div>
                <a href="{{ route('patients.edit', $patient) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('patients.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>

        <div class="row">
            <!-- Patient Information -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Personal Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Patient ID:</strong>
                                <p>{{ $patient->patient_id }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Status:</strong>
                                <p>
                                    <span class="badge bg-{{ $patient->status === 'active' ? 'success' : 'warning' }}">
                                        {{ ucfirst($patient->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Date of Birth:</strong>
                                <p>{{ $patient->date_of_birth->format('M d, Y') }} (Age: {{ now()->diffInYears($patient->date_of_birth) }})</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Gender:</strong>
                                <p>{{ $patient->gender }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Phone:</strong>
                                <p>{{ $patient->phone ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Email:</strong>
                                <p>{{ $patient->email ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>National ID:</strong>
                                <p>{{ $patient->national_id ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Blood Type:</strong>
                                <p>{{ $patient->blood_type ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <strong>Region:</strong>
                                <p>{{ $patient->region ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <strong>District:</strong>
                                <p>{{ $patient->district ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <strong>Town:</strong>
                                <p>{{ $patient->town ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <strong>Address:</strong>
                            <p>{{ $patient->address ?? 'N/A' }}</p>
                        </div>

                        <div class="mb-3">
                            <strong>Allergies/Notes:</strong>
                            <p>{{ $patient->allergy_information ?? 'No known allergies' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Emergency Contact -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Emergency Contact</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Contact Name:</strong>
                                <p>{{ $patient->emergency_contact ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Contact Phone:</strong>
                                <p>{{ $patient->emergency_contact_phone ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Information -->
            <div class="col-lg-4">
                <!-- Facility -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Healthcare Facility</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <strong>{{ $patient->facility->facility_name }}</strong><br>
                            <small class="text-muted">{{ $patient->facility->facility_type }}</small>
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-geo-alt"></i> {{ $patient->facility->district }}, {{ $patient->facility->region }}
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-telephone"></i> {{ $patient->facility->phone }}
                        </p>
                        @if($patient->facility->nhis_accredited)
                            <span class="badge bg-success mt-2">NHIS Accredited</span>
                        @endif
                    </div>
                </div>

                <!-- NHIS Membership -->
                @if($patient->insurance)
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">NHIS Membership</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                <strong>{{ $patient->insurance->nhis_number }}</strong><br>
                                <small class="text-muted">{{ $patient->insurance->member_category }}</small>
                            </p>
                            <p class="mb-2">
                                <strong>Status:</strong><br>
                                <span class="badge bg-{{ $patient->insurance->subscription_status === 'active' ? 'success' : 'warning' }}">
                                    {{ ucfirst($patient->insurance->subscription_status) }}
                                </span>
                            </p>
                            <p class="mb-0">
                                <strong>Expires:</strong><br>
                                {{ $patient->insurance->expiry_date->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                @else
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">NHIS Membership</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-0">No NHIS membership registered</p>
                            <a href="{{ route('nhis.create') }}" class="btn btn-sm btn-primary mt-2">Add NHIS Membership</a>
                        </div>
                    </div>
                @endif

                <!-- Statistics -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Appointments:</strong>
                            <p class="text-primary">{{ $patient->appointments->count() }}</p>
                        </div>
                        <div class="mb-3">
                            <strong>Medical Records:</strong>
                            <p class="text-primary">{{ $patient->medicalRecords->count() }}</p>
                        </div>
                        <div>
                            <strong>Insurance Claims:</strong>
                            <p class="text-primary">{{ $patient->insuranceClaims->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
