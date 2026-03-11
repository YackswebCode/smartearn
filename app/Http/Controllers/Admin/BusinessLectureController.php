<?php
// app/Http/Controllers/Admin/BusinessLectureController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessLecture;
use App\Models\BusinessCourse;
use Illuminate\Http\Request;

class BusinessLectureController extends Controller
{
    public function index()
    {
        $lectures = BusinessLecture::with('course')->orderBy('order')->get();
        return view('admin.business-university.lectures.index', compact('lectures'));
    }

    public function create()
    {
        $courses = BusinessCourse::orderBy('title')->get();
        return view('admin.business-university.lectures.form', [
            'lecture' => new BusinessLecture(),
            'courses' => $courses,
            'formAction' => route('admin.business-lectures.store'),
            'formMethod' => 'POST',
            'buttonText' => 'Create Lecture'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => 'required|exists:business_courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|url',
            'order' => 'nullable|integer',
            'is_preview' => 'boolean',
        ]);

        BusinessLecture::create($data);

        return redirect()->route('admin.business-lectures.index')
            ->with('success', 'Lecture created.');
    }

    public function edit(BusinessLecture $businessLecture)
    {
        $courses = BusinessCourse::orderBy('title')->get();
        return view('admin.business-university.lectures.form', [
            'lecture' => $businessLecture,
            'courses' => $courses,
            'formAction' => route('admin.business-lectures.update', $businessLecture),
            'formMethod' => 'POST',
            'buttonText' => 'Update Lecture'
        ]);
    }

    public function update(Request $request, BusinessLecture $businessLecture)
    {
        $data = $request->validate([
            'course_id' => 'required|exists:business_courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|url',
            'order' => 'nullable|integer',
            'is_preview' => 'boolean',
        ]);

        $businessLecture->update($data);

        return redirect()->route('admin.business-lectures.index')
            ->with('success', 'Lecture updated.');
    }

    public function destroy(BusinessLecture $businessLecture)
    {
        $businessLecture->delete();
        return redirect()->route('admin.business-lectures.index')
            ->with('success', 'Lecture deleted.');
    }
}