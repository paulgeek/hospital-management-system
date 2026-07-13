@extends('layouts.app')

@section('title', 'Schedule Appointment')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="h3 fw-bold mb-4">Schedule New Appointment</h1>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('appointments.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="patient_id" class="form-label">Patient *</label>
                                    <select class="form-select @error('patient_id') is-invalid @enderror" id="patient_id" name="patient_id" required>
                                        <option value="">Select Patient</option>
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                                {{ $patient->full_name }} ({{ $patient->patient_id }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="provider_id" class="form-label">Healthcare Provider *</label>
                                    <select class="form-select @error('provider_id') is-invalid @enderror" id="provider_id" name="provider_id" required>
                                        <option value="">Select Doctor</option>
                                        @foreach($providers as $provider)
                                            <option value="{{ $provider->id }}" {{ old('provider_id') == $provider->id ? 'selected' : '' }}>
                                                {{ $provider->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="facility_id" class="form-label">Healthcare Facility *</label>
                                    <select class="form-select @error('facility_id') is-invalid @enderror" id="facility_id" name="facility_id" required>
                                        <option value="">Select Facility</option>
                                        @foreach($facilities as $facility)
                                            <option value="{{ $facility->id }}" {{ old('facility_id') == $facility->id ? 'selected' : '' }}>
                                                {{ $facility->facility_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="department" class="form-label">Department *</label>
                                    <input type="text" class="form-control @error('department') is-invalid @enderror" id="department" name="department" value="{{ old('department') }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="appointment_date" class="form-label">Appointment Date *</label>
                                    <input type="date" class="form-control @error('appointment_date') is-invalid @enderror" id="appointment_date" name="appointment_date" value="{{ old('appointment_date') }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="appointment_time" class="form-label">Appointment Time *</label>
                                    <input type="time" class="form-control @error('appointment_time') is-invalid @enderror" id="appointment_time" name="appointment_time" value="{{ old('appointment_time') }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason for Visit *</label>
                                <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="4" required>{{ old('reason') }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Schedule Appointment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
