@extends('layouts.app')

@section('title', 'Claim ' . $claim->claim_id)

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">{{ $claim->claim_id }}</h1>
            <div>
                @if($claim->claim_status === 'draft')
                    <a href="{{ route('claims.edit', $claim) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form action="{{ route('claims.submit', $claim) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-send"></i> Submit
                        </button>
                    </form>
                @elseif($claim->claim_status === 'submitted')
                    <form action="{{ route('claims.approve', $claim) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="approved_amount" value="{{ $claim->claim_amount }}">
                        <button type="submit" class="btn btn-success" onclick="return confirm('Approve this claim?')">
                            <i class="bi bi-check-circle"></i> Approve
                        </button>
                    </form>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="bi bi-x-circle"></i> Reject
                    </button>
                @endif
                <a href="{{ route('claims.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Claim Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Claim ID:</strong>
                                <p>{{ $claim->claim_id }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Status:</strong>
                                <p>
                                    <span class="badge bg-{{ $claim->claim_status === 'approved' ? 'success' : ($claim->claim_status === 'rejected' ? 'danger' : 'info') }}">
                                        {{ ucfirst(str_replace('_', ' ', $claim->claim_status)) }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Claim Date:</strong>
                                <p>{{ $claim->claim_date->format('M d, Y') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Service Date:</strong>
                                <p>{{ $claim->service_date->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Claim Amount:</strong>
                                <p class="h5 text-primary">GHC {{ number_format($claim->claim_amount, 2) }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Approved Amount:</strong>
                                <p class="h5 text-success">GHC {{ number_format($claim->approved_amount ?? 0, 2) }}</p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <strong>Service Description:</strong>
                            <p>{{ $claim->service_description }}</p>
                        </div>

                        @if($claim->rejection_reason)
                            <div class="alert alert-danger">
                                <strong>Rejection Reason:</strong><br>
                                {{ $claim->rejection_reason }}
                            </div>
                        @endif

                        @if($claim->reviewed_by)
                            <div class="alert alert-info">
                                <strong>Reviewed By:</strong> {{ $claim->reviewed_by }}
                            </div>
                        @endif
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
                            <strong><a href="{{ route('patients.show', $claim->patient) }}">{{ $claim->patient->full_name }}</a></strong><br>
                            <small class="text-muted">{{ $claim->patient->patient_id }}</small>
                        </p>
                        <a href="{{ route('patients.show', $claim->patient) }}" class="btn btn-sm btn-primary">View Patient</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Facility Information</h5>
                    </div>
                    <div class="card-body">
                        <p>
                            <strong>{{ $claim->facility->facility_name }}</strong><br>
                            <small class="text-muted">{{ $claim->facility->facility_type }}</small>
                        </p>
                        <p class="mb-0">{{ $claim->facility->address }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Claim</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('claims.reject', $claim) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="rejection_reason" class="form-label">Rejection Reason *</label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject Claim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
