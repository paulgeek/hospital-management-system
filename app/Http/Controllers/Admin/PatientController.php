<?php

namespace App\Http\Controllers\Admin;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PatientController
{
    public function index()
    {
        $patients = Patient::with(['facility', 'insurance'])->paginate(15);
        return view('admin.patients.index', compact('patients'));
    }

    public function create()
    {
        $facilities = \App\Models\HealthcareFacility::where('status', 'active')->get();
        return view('admin.patients.create', compact('facilities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'national_id' => 'nullable|unique:patients',
            'address' => 'nullable|string',
            'region' => 'nullable|string',
            'district' => 'nullable|string',
            'town' => 'nullable|string',
            'facility_id' => 'required|exists:healthcare_facilities,id',
            'blood_type' => 'nullable|string',
        ]);

        $validated['patient_id'] = 'PAT-' . Str::upper(Str::random(8));

        Patient::create($validated);

        return redirect()->route('patients.index')->with('success', 'Patient registered successfully');
    }

    public function show(Patient $patient)
    {
        return view('admin.patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        $facilities = \App\Models\HealthcareFacility::where('status', 'active')->get();
        return view('admin.patients.edit', compact('patient', 'facilities'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'region' => 'nullable|string',
            'district' => 'nullable|string',
            'town' => 'nullable|string',
            'blood_type' => 'nullable|string',
            'allergy_information' => 'nullable|string',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.show', $patient)->with('success', 'Patient updated successfully');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully');
    }
}
