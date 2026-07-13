<?php

namespace App\Http\Controllers\Admin;

use App\Models\NHISMembership;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NHISController
{
    public function index()
    {
        $memberships = NHISMembership::with('patient')->paginate(15);
        return view('admin.nhis.index', compact('memberships'));
    }

    public function create()
    {
        $patients = Patient::whereDoesntHave('insurance')->where('status', 'active')->get();
        return view('admin.nhis.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id|unique:nhis_memberships',
            'member_category' => 'required|in:Vulnerable,Indigent,SSNIT,Private,Informal',
            'registration_date' => 'required|date',
            'expiry_date' => 'required|date|after:registration_date',
            'subscription_status' => 'required|in:active,inactive,suspended,expired',
            'premium_paid' => 'required|numeric|min:0',
            'payment_method' => 'nullable|in:Cash,Check,Bank Transfer,Mobile Money,Insurance',
        ]);

        $validated['nhis_number'] = 'NHIS-' . Str::upper(Str::random(10));

        NHISMembership::create($validated);

        return redirect()->route('nhis.index')->with('success', 'NHIS membership created successfully');
    }

    public function show(NHISMembership $membership)
    {
        return view('admin.nhis.show', compact('membership'));
    }

    public function edit(NHISMembership $membership)
    {
        return view('admin.nhis.edit', compact('membership'));
    }

    public function update(Request $request, NHISMembership $membership)
    {
        $validated = $request->validate([
            'member_category' => 'required|in:Vulnerable,Indigent,SSNIT,Private,Informal',
            'expiry_date' => 'required|date',
            'subscription_status' => 'required|in:active,inactive,suspended,expired',
            'premium_paid' => 'required|numeric|min:0',
            'payment_method' => 'nullable|in:Cash,Check,Bank Transfer,Mobile Money,Insurance',
            'exemption_status' => 'boolean',
            'exemption_reason' => 'nullable|string',
        ]);

        $membership->update($validated);

        return redirect()->route('nhis.show', $membership)->with('success', 'NHIS membership updated successfully');
    }

    public function renew(NHISMembership $membership, Request $request)
    {
        $validated = $request->validate([
            'renewal_date' => 'required|date|after:today',
            'new_expiry_date' => 'required|date|after:renewal_date',
            'premium_paid' => 'required|numeric|min:0',
        ]);

        $membership->update([
            'renewal_date' => $validated['renewal_date'],
            'expiry_date' => $validated['new_expiry_date'],
            'premium_paid' => $validated['premium_paid'],
            'subscription_status' => 'active',
        ]);

        return redirect()->route('nhis.show', $membership)->with('success', 'NHIS membership renewed successfully');
    }
}
