<?php
// app/Http/Controllers/Admin/FacultyController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index()
    {
        $faculties = Faculty::orderBy('order')->get();
        return view('admin.skill-garage.faculties.index', compact('faculties'));
    }

    public function create()
    {
        return view('admin.skill-garage.faculties.form', [
            'faculty' => new Faculty(),
            'formAction' => route('admin.faculties.store'),
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
            'order' => 'integer'
        ]);
        Faculty::create($data);
        return redirect()->route('admin.faculties.index')->with('success', 'Faculty created.');
    }

    public function edit(Faculty $faculty)
    {
        return view('admin.skill-garage.faculties.form', [
            'faculty' => $faculty,
            'formAction' => route('admin.faculties.update', $faculty),
            'formMethod' => 'POST',
            'buttonText' => 'Update Faculty'
        ]);
    }

    public function update(Request $request, Faculty $faculty)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'order' => 'integer'
        ]);
        $faculty->update($data);
        return redirect()->route('admin.faculties.index')->with('success', 'Faculty updated.');
    }

    public function destroy(Faculty $faculty)
    {
        // Check if any tracks belong to this faculty
        if ($faculty->tracks()->count() > 0) {
            return back()->withErrors(['Cannot delete faculty with existing tracks.']);
        }
        $faculty->delete();
        return redirect()->route('admin.faculties.index')->with('success', 'Faculty deleted.');
    }
}