<?php

namespace App\Http\Controllers\Admin;

use App\Models\InsuranceClaim;
use App\Models\Patient;
use App\Models\HealthcareFacility;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InsuranceClaimController
{
    public function index()
    {
        $claims = InsuranceClaim::with(['patient', 'facility'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.claims.index', compact('claims'));
    }

    public function create()
    {
        $patients = Patient::where('status', 'active')->get();
        $facilities = HealthcareFacility::where('status', 'active')->get();
        $medical_records = MedicalRecord::where('status', 'completed')->get();
        return view('admin.claims.create', compact('patients', 'facilities', 'medical_records'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'facility_id' => 'required|exists:healthcare_facilities,id',
            'claim_date' => 'required|date',
            'service_date' => 'required|date',
            'claim_amount' => 'required|numeric|min:0',
            'service_description' => 'required|string',
            'medical_record_id' => 'nullable|exists:medical_records,id',
        ]);

        $validated['claim_id'] = 'CLM-' . Str::upper(Str::random(10));
        $validated['claim_status'] = 'draft';

        InsuranceClaim::create($validated);

        return redirect()->route('claims.index')->with('success', 'Claim created successfully');
    }

    public function show(InsuranceClaim $claim)
    {
        return view('admin.claims.show', compact('claim'));
    }

    public function edit(InsuranceClaim $claim)
    {
        $patients = Patient::where('status', 'active')->get();
        $facilities = HealthcareFacility::where('status', 'active')->get();
        return view('admin.claims.edit', compact('claim', 'patients', 'facilities'));
    }

    public function update(Request $request, InsuranceClaim $claim)
    {
        $validated = $request->validate([
            'service_description' => 'required|string',
            'claim_amount' => 'required|numeric|min:0',
        ]);

        if ($claim->claim_status === 'draft') {
            $claim->update($validated);
        }

        return redirect()->route('claims.show', $claim)->with('success', 'Claim updated successfully');
    }

    public function submit(InsuranceClaim $claim)
    {
        $claim->update(['claim_status' => 'submitted']);
        return redirect()->route('claims.show', $claim)->with('success', 'Claim submitted for review');
    }

    public function approve(InsuranceClaim $claim, Request $request)
    {
        $validated = $request->validate([
            'approved_amount' => 'required|numeric|min:0',
        ]);

        $claim->update([
            'claim_status' => 'approved',
            'approved_amount' => $validated['approved_amount'],
            'reviewed_by' => auth()->user()->full_name,
        ]);

        return redirect()->route('claims.show', $claim)->with('success', 'Claim approved successfully');
    }

    public function reject(InsuranceClaim $claim, Request $request)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $claim->update([
            'claim_status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'reviewed_by' => auth()->user()->full_name,
        ]);

        return redirect()->route('claims.show', $claim)->with('success', 'Claim rejected');
    }
}
