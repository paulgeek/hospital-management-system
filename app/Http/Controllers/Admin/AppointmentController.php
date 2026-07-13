<?php

namespace App\Http\Controllers\Admin;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Models\HealthcareFacility;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AppointmentController
{
    public function index()
    {
        $appointments = Appointment::with(['patient', 'provider', 'facility'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(15);
        return view('admin.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::where('status', 'active')->get();
        $providers = User::role('Doctor')->where('status', 'active')->get();
        $facilities = HealthcareFacility::where('status', 'active')->get();
        return view('admin.appointments.create', compact('patients', 'providers', 'facilities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'provider_id' => 'required|exists:users,id',
            'facility_id' => 'required|exists:healthcare_facilities,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required|date_format:H:i',
            'department' => 'required|string',
            'reason' => 'required|string',
        ]);

        $validated['appointment_id'] = 'APT-' . Str::upper(Str::random(8));
        $validated['status'] = 'scheduled';

        Appointment::create($validated);

        return redirect()->route('appointments.index')->with('success', 'Appointment created successfully');
    }

    public function show(Appointment $appointment)
    {
        return view('admin.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::where('status', 'active')->get();
        $providers = User::role('Doctor')->where('status', 'active')->get();
        $facilities = HealthcareFacility::where('status', 'active')->get();
        return view('admin.appointments.edit', compact('appointment', 'patients', 'providers', 'facilities'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'department' => 'required|string',
            'reason' => 'required|string',
            'status' => 'required|in:scheduled,completed,cancelled,no-show,rescheduled',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.show', $appointment)->with('success', 'Appointment updated successfully');
    }

    public function cancel(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelled']);
        return redirect()->route('appointments.index')->with('success', 'Appointment cancelled');
    }
}
