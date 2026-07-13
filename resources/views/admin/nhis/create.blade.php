@extends('layouts.app')

@section('title', 'Register NHIS Membership')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="h3 fw-bold mb-4">Register NHIS Membership</h1>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('nhis.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
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

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="member_category" class="form-label">Member Category *</label>
                                    <select class="form-select @error('member_category') is-invalid @enderror" id="member_category" name="member_category" required>
                                        <option value="">Select Category</option>
                                        <option value="Vulnerable" {{ old('member_category') === 'Vulnerable' ? 'selected' : '' }}>Vulnerable</option>
                                        <option value="Indigent" {{ old('member_category') === 'Indigent' ? 'selected' : '' }}>Indigent</option>
                                        <option value="SSNIT" {{ old('member_category') === 'SSNIT' ? 'selected' : '' }}>SSNIT</option>
                                        <option value="Private" {{ old('member_category') === 'Private' ? 'selected' : '' }}>Private</option>
                                        <option value="Informal" {{ old('member_category') === 'Informal' ? 'selected' : '' }}>Informal</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="subscription_status" class="form-label">Subscription Status *</label>
                                    <select class="form-select @error('subscription_status') is-invalid @enderror" id="subscription_status" name="subscription_status" required>
                                        <option value="active" {{ old('subscription_status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('subscription_status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="suspended" {{ old('subscription_status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="registration_date" class="form-label">Registration Date *</label>
                                    <input type="date" class="form-control @error('registration_date') is-invalid @enderror" id="registration_date" name="registration_date" value="{{ old('registration_date', now()->format('Y-m-d')) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="expiry_date" class="form-label">Expiry Date *</label>
                                    <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="premium_paid" class="form-label">Premium Paid (GHC) *</label>
                                    <input type="number" class="form-control @error('premium_paid') is-invalid @enderror" id="premium_paid" name="premium_paid" value="{{ old('premium_paid', 0) }}" step="0.01" min="0" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="payment_method" class="form-label">Payment Method</label>
                                    <select class="form-select" id="payment_method" name="payment_method">
                                        <option value="">Select Payment Method</option>
                                        <option value="Cash" {{ old('payment_method') === 'Cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="Check" {{ old('payment_method') === 'Check' ? 'selected' : '' }}>Check</option>
                                        <option value="Bank Transfer" {{ old('payment_method') === 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="Mobile Money" {{ old('payment_method') === 'Mobile Money' ? 'selected' : '' }}>Mobile Money</option>
                                        <option value="Insurance" {{ old('payment_method') === 'Insurance' ? 'selected' : '' }}>Insurance</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('nhis.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Register NHIS Member</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
