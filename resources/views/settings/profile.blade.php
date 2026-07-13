@extends('layouts.app')

@section('title', 'User Profile Settings')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 fw-bold mb-4">Profile Settings</h1>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Personal Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->first_name }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->last_name }}" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" value="{{ Auth::user()->phone }}" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Employee ID</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->employee_id }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Department</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->department }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Account Security</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">Manage your password and account security.</p>
                        <a href="{{ route('change-password') }}" class="btn btn-primary">Change Password</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Account Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Role:</strong>
                            <p>
                                @forelse(Auth::user()->getRoleNames() as $role)
                                    <span class="badge bg-primary">{{ $role }}</span>
                                @empty
                                    <span class="badge bg-secondary">No Role</span>
                                @endforelse
                            </p>
                        </div>

                        <div class="mb-3">
                            <strong>Status:</strong>
                            <p>
                                <span class="badge bg-{{ Auth::user()->status === 'active' ? 'success' : 'warning' }}">
                                    {{ ucfirst(Auth::user()->status) }}
                                </span>
                            </p>
                        </div>

                        <div class="mb-3">
                            <strong>Member Since:</strong>
                            <p>{{ Auth::user()->created_at->format('M d, Y') }}</p>
                        </div>

                        <div>
                            <strong>Last Updated:</strong>
                            <p>{{ Auth::user()->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
