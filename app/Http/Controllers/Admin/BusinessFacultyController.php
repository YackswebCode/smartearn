<?php
// app/Http/Controllers/Admin/BusinessFacultyController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessFaculty;
use Illuminate\Http\Request;

class BusinessFacultyController extends Controller
{
    public function index()
    {
        $faculties = BusinessFaculty::orderBy('order')->get();
        return view('admin.business-university.faculties.index', compact('faculties'));
    }

    public function create()
    {
        return view('admin.business-university.faculties.form', [
            'faculty' => new BusinessFaculty(),
            'formAction' => route('admin.business-faculties.store'),
            'formMethod' => 'POST',
            'buttonText' => 'Create Faculty'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer'
        ]);
        BusinessFaculty::create($data);
        return redirect()->route('admin.business-faculties.index')
            ->with('success', 'Faculty created successfully.');
    }

    public function edit(BusinessFaculty $businessFaculty)
    {
        return view('admin.business-university.faculties.form', [
            'faculty' => $businessFaculty,
            'formAction' => route('admin.business-faculties.update', $businessFaculty),
            'formMethod' => 'POST',
            'buttonText' => 'Update Faculty'
        ]);
    }

    public function update(Request $request, BusinessFaculty $businessFaculty)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer'
        ]);
        $businessFaculty->update($data);
        return redirect()->route('admin.business-faculties.index')
            ->with('success', 'Faculty updated successfully.');
    }

    public function destroy(BusinessFaculty $businessFaculty)
    {
        // Check if any courses exist
        if ($businessFaculty->courses()->exists()) {
            return back()->withErrors(['error' => 'Cannot delete faculty with existing courses.']);
        }
        $businessFaculty->delete();
        return redirect()->route('admin.business-faculties.index')
            ->with('success', 'Faculty deleted.');
    }
}