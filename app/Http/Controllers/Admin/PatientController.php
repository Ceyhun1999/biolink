<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\PatientSource;
use Illuminate\Http\Request;

class PatientController extends Controller
{

    public function index(Request $request)
    {
        $sortBy = $request->get('sort', 'id');
        $sortDirection = $request->get('direction', 'asc');

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'asc';
        }

        $allowedSortFields = [
            'id',
            'firstName',
            'lastName',
            'fatherName',
            'gender',
            'birthday',
            'diagnose',
            'phone',
            'created_at',
            'source'
        ];

        if (!in_array($sortBy, $allowedSortFields)) {
            $sortBy = 'id';
        }


        if ($sortBy === 'source') {
            $patients = Patient::with(['patientSource'])
                ->join('patient_sources', 'patients.patient_source_id', '=', 'patient_sources.id')
                ->orderBy('patient_sources.name', $sortDirection)
                ->select('patients.*')
                ->get();
        } else {
            $patients = Patient::with(['patientSource'])
                ->orderBy($sortBy, $sortDirection)
                ->get();
        }

        return view('admin.patient.index', [
            'patients' => $patients,
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection,
        ]);
    }


    public function create()
    {
        $sources = PatientSource::orderBy('name')->get();
        return view('admin.patient.create', [
            'sources' => $sources
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstName'  => 'required|string|max:255',
            'lastName'   => 'required|string|max:255',
            'fatherName' => 'nullable|string|max:255',
            'birthday'   => 'nullable|date|before_or_equal:today|after_or_equal:1900-01-01',
            'phone'      => 'nullable|string|max:50',
            'phone2'     => 'nullable|string|max:50',
            'gender'     => 'nullable|in:Kişi,Qadın',
            'patient_source_id' => 'nullable|exists:patient_sources,id',
            'diagnose'   => 'nullable|string|max:255',
        ]);

        Patient::create($validated);

        return redirect()->route('admin.patients.index')->with('success', 'Xəstə uğurla qeydiyyata alındı!');
    }

    public function edit($id)
    {
        $sources = PatientSource::orderBy('name')->get();

        $patient = Patient::with(['examinations.files' => function ($query) {
            $query->latest();
        }])->findOrFail($id);

        return view('admin.patient.edit', [
            'patient' => $patient,
            'sources' => $sources
        ]);
    }

    public function update(Patient $patient, Request $request)
    {
        $validated = $request->validate([
            'firstName'  => 'required|string|max:255',
            'lastName'   => 'required|string|max:255',
            'fatherName' => 'nullable|string|max:255',
            'birthday'   => 'nullable|date|before_or_equal:today|after_or_equal:1900-01-01',
            'phone'      => 'nullable|string|max:50',
            'phone2'     => 'nullable|string|max:50',
            'gender'     => 'nullable|in:Kişi,Qadın',
            'patient_source_id' => 'nullable|exists:patient_sources,id',
            'diagnose'   => 'nullable|string|max:255',
        ]);

        $patient->update($validated);

        return redirect()->route('admin.patients.index')->with('success', 'Xəstə məlumatları uğurla yeniləndi');
    }
}
