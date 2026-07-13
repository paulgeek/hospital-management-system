@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="mb-4">
            <h1 class="h3 fw-bold">Dashboard</h1>
            <p class="text-muted">Welcome back, {{ auth()->user()->full_name }}!</p>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <h3>{{ $stats['total_patients'] }}</h3>
                    <p><i class="bi bi-people"></i> Total Patients</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                    <h3>{{ $stats['pending_appointments'] }}</h3>
                    <p><i class="bi bi-calendar-event"></i> Pending Appointments</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);">
                    <h3>{{ $stats['pending_claims'] }}</h3>
                    <p><i class="bi bi-exclamation-triangle"></i> Pending Claims</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);">
                    <h3>{{ $stats['active_nhis_members'] }}</h3>
                    <p><i class="bi bi-shield-check"></i> Active NHIS Members</p>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);">
                    <h3>{{ $stats['total_medical_records'] }}</h3>
                    <p><i class="bi bi-file-earmark-medical"></i> Medical Records</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #ea580c 0%, #f97316 100%);">
                    <h3>{{ $stats['total_users'] }}</h3>
                    <p><i class="bi bi-people-fill"></i> System Users</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #475569 0%, #64748b 100%);">
                    <h3>{{ $stats['total_facilities'] }}</h3>
                    <p><i class="bi bi-hospital"></i> Healthcare Facilities</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);">
                    <h3>{{ \App\Models\Appointment::where('status', 'completed')->count() }}</h3>
                    <p><i class="bi bi-check-circle"></i> Completed Visits</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Appointments -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="bi bi-calendar-event"></i> Recent Appointments
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @if($recent_appointments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <tbody>
                                        @foreach($recent_appointments as $appointment)
                                            <tr>
                                                <td>
                                                    <strong>{{ $appointment->patient->full_name }}</strong><br>
                                                    <small class="text-muted">{{ $appointment->appointment_date->format('M d, Y') }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $appointment->status === 'scheduled' ? 'info' : ($appointment->status === 'completed' ? 'success' : 'warning') }}">
                                                        {{ ucfirst($appointment->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-outline-primary">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-4 text-center text-muted">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mt-2">No recent appointments</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Claims -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="bi bi-file-earmark-text"></i> Recent Insurance Claims
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @if($recent_claims->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <tbody>
                                        @foreach($recent_claims as $claim)
                                            <tr>
                                                <td>
                                                    <strong>{{ $claim->patient->full_name }}</strong><br>
                                                    <small class="text-muted">GHC {{ number_format($claim->claim_amount, 2) }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $claim->claim_status === 'approved' ? 'success' : ($claim->claim_status === 'rejected' ? 'danger' : ($claim->claim_status === 'submitted' ? 'info' : 'warning')) }}">
                                                        {{ ucfirst(str_replace('_', ' ', $claim->claim_status)) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('claims.show', $claim) }}" class="btn btn-sm btn-outline-primary">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-4 text-center text-muted">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mt-2">No recent claims</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <a href="{{ route('patients.create') }}" class="btn btn-primary w-100">
                                    <i class="bi bi-plus-circle"></i> Register Patient
                                </a>
                            </div>
                            <div class="col-md-3 mb-2">
                                <a href="{{ route('appointments.create') }}" class="btn btn-primary w-100">
                                    <i class="bi bi-calendar-plus"></i> Schedule Appointment
                                </a>
                            </div>
                            <div class="col-md-3 mb-2">
                                <a href="{{ route('nhis.create') }}" class="btn btn-primary w-100">
                                    <i class="bi bi-plus-circle"></i> Add NHIS Member
                                </a>
                            </div>
                            <div class="col-md-3 mb-2">
                                <a href="{{ route('claims.create') }}" class="btn btn-primary w-100">
                                    <i class="bi bi-plus-circle"></i> Create Claim
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
