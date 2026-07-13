@extends('layouts.app')

@section('title', 'Create Insurance Claim')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="h3 fw-bold mb-4">Create Insurance Claim</h1>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('claims.store') }}" method="POST">
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
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="claim_date" class="form-label">Claim Date *</label>
                                    <input type="date" class="form-control @error('claim_date') is-invalid @enderror" id="claim_date" name="claim_date" value="{{ old('claim_date', now()->format('Y-m-d')) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="service_date" class="form-label">Service Date *</label>
                                    <input type="date" class="form-control @error('service_date') is-invalid @enderror" id="service_date" name="service_date" value="{{ old('service_date') }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="claim_amount" class="form-label">Claim Amount (GHC) *</label>
                                    <input type="number" class="form-control @error('claim_amount') is-invalid @enderror" id="claim_amount" name="claim_amount" value="{{ old('claim_amount', 0) }}" step="0.01" min="0" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="medical_record_id" class="form-label">Medical Record</label>
                                    <select class="form-select" id="medical_record_id" name="medical_record_id">
                                        <option value="">Select Medical Record</option>
                                        @foreach($medical_records as $record)
                                            <option value="{{ $record->id }}" {{ old('medical_record_id') == $record->id ? 'selected' : '' }}>
                                                Record #{{ $record->id }} - {{ $record->created_at->format('M d, Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="service_description" class="form-label">Service Description *</label>
                                <textarea class="form-control @error('service_description') is-invalid @enderror" id="service_description" name="service_description" rows="4" required>{{ old('service_description') }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('claims.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Create Claim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
