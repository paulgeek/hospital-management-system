@extends('layouts.app')

@section('title', $membership->nhis_number)

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">{{ $membership->nhis_number }}</h1>
            <div>
                <a href="{{ route('nhis.edit', $membership) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('nhis.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Membership Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>NHIS Number:</strong>
                                <p>{{ $membership->nhis_number }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Category:</strong>
                                <p>
                                    <span class="badge bg-secondary">{{ $membership->member_category }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Status:</strong>
                                <p>
                                    <span class="badge bg-{{ $membership->subscription_status === 'active' ? 'success' : 'warning' }}">
                                        {{ ucfirst($membership->subscription_status) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Premium Paid:</strong>
                                <p>GHC {{ number_format($membership->premium_paid, 2) }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Registration Date:</strong>
                                <p>{{ $membership->registration_date->format('M d, Y') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Expiry Date:</strong>
                                <p>
                                    {{ $membership->expiry_date->format('M d, Y') }}
                                    @if($membership->expiry_date < now())
                                        <span class="badge bg-danger ms-2">Expired</span>
                                    @elseif($membership->expiry_date < now()->addDays(30))
                                        <span class="badge bg-warning ms-2">Expiring Soon</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if($membership->payment_method)
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Payment Method:</strong>
                                    <p>{{ $membership->payment_method }}</p>
                                </div>
                                @if($membership->renewal_date)
                                    <div class="col-md-6 mb-3">
                                        <strong>Last Renewal:</strong>
                                        <p>{{ $membership->renewal_date->format('M d, Y') }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if($membership->exemption_status)
                            <div class="alert alert-info">
                                <strong>Exemption Status:</strong> {{ $membership->exemption_reason ?? 'Exempted' }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Patient Information</h5>
                    </div>
                    <div class="card-body">
                        <p>
                            <strong><a href="{{ route('patients.show', $membership->patient) }}">{{ $membership->patient->full_name }}</a></strong><br>
                            <small class="text-muted">{{ $membership->patient->patient_id }}</small>
                        </p>
                        <p>
                            <i class="bi bi-calendar"></i> {{ $membership->patient->date_of_birth->format('M d, Y') }}<br>
                            <i class="bi bi-telephone"></i> {{ $membership->patient->phone ?? 'N/A' }}
                        </p>
                        <a href="{{ route('patients.show', $membership->patient) }}" class="btn btn-sm btn-primary">View Patient</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
