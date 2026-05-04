<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalFaculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index()
    {
        $faculties = DigitalFaculty::orderBy('order')->get();
        return view('admin.faculties.index', compact('faculties'));
    }

    public function create()
    {
        return view('admin.faculties.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'icon'      => 'nullable|string|max:255',
            'order'     => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        DigitalFaculty::create($data);
        return redirect()->route('admin.faculties.index')->with('success', 'Faculty created.');
    }

    public function edit(DigitalFaculty $faculty)
    {
        return view('admin.faculties.edit', compact('faculty'));
    }

    public function update(Request $request, DigitalFaculty $faculty)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'icon'      => 'nullable|string|max:255',
            'order'     => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $faculty->update($data);
        return redirect()->route('admin.faculties.index')->with('success', 'Faculty updated.');
    }

    public function destroy(DigitalFaculty $faculty)
    {
        $faculty->delete();
        return back()->with('success', 'Faculty deleted.');
    }
}