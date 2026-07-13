@extends('layouts.app')

@section('title', 'Register New Patient')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="h3 fw-bold mb-4">Register New Patient</h1>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('patients.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label">First Name *</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">Last Name *</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="date_of_birth" class="form-label">Date of Birth *</label>
                                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label">Gender *</label>
                                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="national_id" class="form-label">National ID</label>
                                    <input type="text" class="form-control @error('national_id') is-invalid @enderror" id="national_id" name="national_id" value="{{ old('national_id') }}">
                                    @error('national_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="blood_type" class="form-label">Blood Type</label>
                                    <select class="form-select" id="blood_type" name="blood_type">
                                        <option value="">Select Blood Type</option>
                                        <option value="O+" {{ old('blood_type') === 'O+' ? 'selected' : '' }}>O+</option>
                                        <option value="O-" {{ old('blood_type') === 'O-' ? 'selected' : '' }}>O-</option>
                                        <option value="A+" {{ old('blood_type') === 'A+' ? 'selected' : '' }}>A+</option>
                                        <option value="A-" {{ old('blood_type') === 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ old('blood_type') === 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B-" {{ old('blood_type') === 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="AB+" {{ old('blood_type') === 'AB+' ? 'selected' : '' }}>AB+</option>
                                        <option value="AB-" {{ old('blood_type') === 'AB-' ? 'selected' : '' }}>AB-</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="region" class="form-label">Region</label>
                                    <input type="text" class="form-control" id="region" name="region" value="{{ old('region') }}">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="district" class="form-label">District</label>
                                    <input type="text" class="form-control" id="district" name="district" value="{{ old('district') }}">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="town" class="form-label">Town</label>
                                    <input type="text" class="form-control" id="town" name="town" value="{{ old('town') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="facility_id" class="form-label">Healthcare Facility *</label>
                                <select class="form-select @error('facility_id') is-invalid @enderror" id="facility_id" name="facility_id" required>
                                    <option value="">Select Facility</option>
                                    @foreach($facilities as $facility)
                                        <option value="{{ $facility->id }}" {{ old('facility_id') == $facility->id ? 'selected' : '' }}>
                                            {{ $facility->facility_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('facility_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('patients.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Register Patient</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
