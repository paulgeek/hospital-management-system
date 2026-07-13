@extends('layouts.app')

@section('title', 'Appointments Management')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">Appointments Management</h1>
            <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                <i class="bi bi-calendar-plus"></i> Schedule Appointment
            </a>
        </div>

        <div class="card">
            <div class="card-header bg-light">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" placeholder="Search..." id="searchInput">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="scheduled">Scheduled</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Appointment ID</th>
                            <th>Patient</th>
                            <th>Date & Time</th>
                            <th>Department</th>
                            <th>Provider</th>
                            <th>Status</th>
                            <th>Facility</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                            <tr>
                                <td><strong>{{ $appointment->appointment_id }}</strong></td>
                                <td>{{ $appointment->patient->full_name }}</td>
                                <td>
                                    {{ $appointment->appointment_date->format('M d, Y') }}<br>
                                    <small class="text-muted">{{ $appointment->appointment_time }}</small>
                                </td>
                                <td>{{ $appointment->department }}</td>
                                <td>{{ $appointment->provider?->full_name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $appointment->status === 'scheduled' ? 'info' : ($appointment->status === 'completed' ? 'success' : ($appointment->status === 'cancelled' ? 'danger' : 'warning')) }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td>{{ $appointment->facility->facility_name }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-outline-primary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if($appointment->status === 'scheduled')
                                            <form action="{{ route('appointments.cancel', $appointment) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-outline-danger" title="Cancel" onclick="return confirm('Cancel this appointment?')">
                                                    <i class="bi bi-x-circle"></i>
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
                                    <p class="mt-2">No appointments found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-light">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
@endsection
