@extends('layouts.app')

@section('title', 'Insurance Claims')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">Insurance Claims Management</h1>
            <a href="{{ route('claims.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Create New Claim
            </a>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);">
                    <h3>{{ \App\Models\InsuranceClaim::where('claim_status', 'submitted')->count() }}</h3>
                    <p><i class="bi bi-clock-history"></i> Pending Review</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                    <h3>{{ \App\Models\InsuranceClaim::where('claim_status', 'approved')->count() }}</h3>
                    <p><i class="bi bi-check-circle"></i> Approved</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);">
                    <h3>{{ \App\Models\InsuranceClaim::where('claim_status', 'rejected')->count() }}</h3>
                    <p><i class="bi bi-x-circle"></i> Rejected</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card" style="background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);">
                    <h3>GHC {{ number_format(\App\Models\InsuranceClaim::sum('claim_amount'), 2) }}</h3>
                    <p><i class="bi bi-cash-coin"></i> Total Claims</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-light">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" placeholder="Search claim ID or patient..." id="searchInput">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="draft">Draft</option>
                            <option value="submitted">Submitted</option>
                            <option value="under_review">Under Review</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Claim ID</th>
                            <th>Patient</th>
                            <th>Claim Date</th>
                            <th>Amount</th>
                            <th>Approved</th>
                            <th>Status</th>
                            <th>Facility</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($claims as $claim)
                            <tr>
                                <td><strong>{{ $claim->claim_id }}</strong></td>
                                <td>{{ $claim->patient->full_name }}</td>
                                <td>{{ $claim->claim_date->format('M d, Y') }}</td>
                                <td class="text-end">GHC {{ number_format($claim->claim_amount, 2) }}</td>
                                <td class="text-end">GHC {{ number_format($claim->approved_amount ?? 0, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $claim->claim_status === 'approved' ? 'success' : ($claim->claim_status === 'rejected' ? 'danger' : ($claim->claim_status === 'submitted' ? 'info' : 'warning')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $claim->claim_status)) }}
                                    </span>
                                </td>
                                <td>{{ $claim->facility->facility_name }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('claims.show', $claim) }}" class="btn btn-outline-primary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if($claim->claim_status === 'draft')
                                            <a href="{{ route('claims.edit', $claim) }}" class="btn btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif
                                        @if($claim->claim_status === 'draft')
                                            <form action="{{ route('claims.submit', $claim) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-outline-info" title="Submit" onclick="return confirm('Submit this claim for review?')">
                                                    <i class="bi bi-send"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                    <p class="mt-2">No claims found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-light">
                {{ $claims->links() }}
            </div>
        </div>
    </div>
@endsection
