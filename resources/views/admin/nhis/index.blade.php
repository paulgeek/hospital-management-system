@extends('layouts.app')

@section('title', 'NHIS Members')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">NHIS Members Management</h1>
            <a href="{{ route('nhis.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Register NHIS Member
            </a>
        </div>

        <div class="card">
            <div class="card-header bg-light">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" placeholder="Search NHIS number or patient..." id="searchInput">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="suspended">Suspended</option>
                            <option value="expired">Expired</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="categoryFilter">
                            <option value="">All Categories</option>
                            <option value="Vulnerable">Vulnerable</option>
                            <option value="Indigent">Indigent</option>
                            <option value="SSNIT">SSNIT</option>
                            <option value="Private">Private</option>
                            <option value="Informal">Informal</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>NHIS Number</th>
                            <th>Patient Name</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Registration Date</th>
                            <th>Expiry Date</th>
                            <th>Premium Paid</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($memberships as $membership)
                            <tr>
                                <td><strong>{{ $membership->nhis_number }}</strong></td>
                                <td>{{ $membership->patient->full_name }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $membership->member_category }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $membership->subscription_status === 'active' ? 'success' : ($membership->subscription_status === 'expired' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($membership->subscription_status) }}
                                    </span>
                                </td>
                                <td>{{ $membership->registration_date->format('M d, Y') }}</td>
                                <td>
                                    {{ $membership->expiry_date->format('M d, Y') }}
                                    @if($membership->expiry_date < now())
                                        <span class="badge bg-danger ms-2">Expired</span>
                                    @elseif($membership->expiry_date < now()->addDays(30))
                                        <span class="badge bg-warning ms-2">Expiring Soon</span>
                                    @endif
                                </td>
                                <td>GHC {{ number_format($membership->premium_paid, 2) }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('nhis.show', $membership) }}" class="btn btn-outline-primary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('nhis.edit', $membership) }}" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if($membership->expiry_date < now())
                                            <a href="{{ route('nhis.renew', $membership) }}" class="btn btn-outline-success" title="Renew">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                    <p class="mt-2">No NHIS members found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-light">
                {{ $memberships->links() }}
            </div>
        </div>
    </div>
@endsection
