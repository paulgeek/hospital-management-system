@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">Appointment {{ $appointment->appointment_id }}</h1>
            <div>
                <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Appointment Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Date & Time:</strong>
                                <p>{{ $appointment->appointment_date->format('M d, Y') }} at {{ $appointment->appointment_time }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Status:</strong>
                                <p>
                                    <span class="badge bg-{{ $appointment->status === 'scheduled' ? 'info' : ($appointment->status === 'completed' ? 'success' : 'warning') }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Department:</strong>
                                <p>{{ $appointment->department }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Reason:</strong>
                                <p>{{ $appointment->reason ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <strong>Notes:</strong>
                            <p>{{ $appointment->notes ?? 'No notes' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Patient Information</h5>
                    </div>
                    <div class="card-body">
                        <p>
                            <strong>{{ $appointment->patient->full_name }}</strong><br>
                            <small class="text-muted">{{ $appointment->patient->patient_id }}</small>
                        </p>
                        <p>
                            <i class="bi bi-telephone"></i> {{ $appointment->patient->phone ?? 'N/A' }}<br>
                            <i class="bi bi-envelope"></i> {{ $appointment->patient->email ?? 'N/A' }}
                        </p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Provider Information</h5>
                    </div>
                    <div class="card-body">
                        <p>
                            <strong>{{ $appointment->provider?->full_name ?? 'Not Assigned' }}</strong><br>
                            <small class="text-muted">{{ $appointment->provider?->department ?? 'N/A' }}</small>
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Facility Information</h5>
                    </div>
                    <div class="card-body">
                        <p>
                            <strong>{{ $appointment->facility->facility_name }}</strong><br>
                            <small class="text-muted">{{ $appointment->facility->facility_type }}</small>
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-geo-alt"></i> {{ $appointment->facility->address }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
