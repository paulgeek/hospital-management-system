@extends('layouts.app')

@section('title', 'Edit Patient')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="h3 fw-bold mb-4">Edit Patient</h1>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('patients.update', $patient) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label">First Name *</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $patient->first_name) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">Last Name *</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $patient->last_name) }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone', $patient->phone) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $patient->email) }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="blood_type" class="form-label">Blood Type</label>
                                    <select class="form-select" id="blood_type" name="blood_type">
                                        <option value="">Select Blood Type</option>
                                        <option value="O+" {{ old('blood_type', $patient->blood_type) === 'O+' ? 'selected' : '' }}>O+</option>
                                        <option value="O-" {{ old('blood_type', $patient->blood_type) === 'O-' ? 'selected' : '' }}>O-</option>
                                        <option value="A+" {{ old('blood_type', $patient->blood_type) === 'A+' ? 'selected' : '' }}>A+</option>
                                        <option value="A-" {{ old('blood_type', $patient->blood_type) === 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ old('blood_type', $patient->blood_type) === 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B-" {{ old('blood_type', $patient->blood_type) === 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="AB+" {{ old('blood_type', $patient->blood_type) === 'AB+' ? 'selected' : '' }}>AB+</option>
                                        <option value="AB-" {{ old('blood_type', $patient->blood_type) === 'AB-' ? 'selected' : '' }}>AB-</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $patient->address) }}">
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="region" class="form-label">Region</label>
                                    <input type="text" class="form-control" id="region" name="region" value="{{ old('region', $patient->region) }}">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="district" class="form-label">District</label>
                                    <input type="text" class="form-control" id="district" name="district" value="{{ old('district', $patient->district) }}">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="town" class="form-label">Town</label>
                                    <input type="text" class="form-control" id="town" name="town" value="{{ old('town', $patient->town) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="allergy_information" class="form-label">Allergies / Medical Notes</label>
                                <textarea class="form-control" id="allergy_information" name="allergy_information" rows="4">{{ old('allergy_information', $patient->allergy_information) }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('patients.show', $patient) }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Patient</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
