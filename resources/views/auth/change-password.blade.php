@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1 class="h3 fw-bold mb-4">Change Password</h1>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('change-password.update') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password *</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password *</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Minimum 8 characters</small>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password *</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
