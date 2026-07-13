@extends('layouts.app')

@section('title', 'Patients Management')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">Patient Management</h1>
            <a href="{{ route('patients.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Register New Patient
            </a>
        </div>

        <div class="card">
            <div class="card-header bg-light">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Search patients..." id="searchInput">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Patient ID</th>
                            <th>Name</th>
                            <th>Date of Birth</th>
                            <th>Contact</th>
                            <th>Facility</th>
                            <th>Status</th>
                            <th>NHIS</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $patient)
                            <tr>
                                <td><strong>{{ $patient->patient_id }}</strong></td>
                                <td>{{ $patient->full_name }}</td>
                                <td>{{ $patient->date_of_birth->format('M d, Y') }}</td>
                                <td>
                                    {{ $patient->phone ?? 'N/A' }}<br>
                                    <small class="text-muted">{{ $patient->email ?? 'N/A' }}</small>
                                </td>
                                <td>{{ $patient->facility->facility_name }}</td>
                                <td>
                                    <span class="badge bg-{{ $patient->status === 'active' ? 'success' : 'warning' }}">
                                        {{ ucfirst($patient->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($patient->insurance)
                                        <span class="badge bg-info">{{ $patient->insurance->nhis_number }}</span>
                                    @else
                                        <span class="badge bg-secondary">None</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('patients.show', $patient) }}" class="btn btn-outline-primary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('patients.edit', $patient) }}" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('patients.destroy', $patient) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                    <p class="mt-2">No patients found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-light">
                {{ $patients->links() }}
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('table tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>
@endsection
