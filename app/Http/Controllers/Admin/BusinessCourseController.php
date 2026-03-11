<?php
// app/Http/Controllers/Admin/BusinessCourseController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessCourse;
use App\Models\BusinessFaculty;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BusinessCourseController extends Controller
{
    public function index()
    {
        $courses = BusinessCourse::with('faculty')->orderBy('order')->get();
        return view('admin.business-university.courses.index', compact('courses'));
    }

    public function create()
    {
        $faculties = BusinessFaculty::orderBy('name')->get();
        return view('admin.business-university.courses.form', [
            'course' => new BusinessCourse(),
            'faculties' => $faculties,
            'formAction' => route('admin.business-courses.store'),
            'formMethod' => 'POST',
            'buttonText' => 'Create Course'
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'faculty_id' => 'required|exists:business_faculties,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'detailed_explanation' => 'nullable|string',
            'instructors' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|in:NGN,USD,GHS,XAF,KES',
            'image' => 'nullable|image|max:2048',
            'is_diploma' => 'boolean',
            'duration_months' => 'nullable|integer',
            'order' => 'nullable|integer',
        ]);

        // Generate slug
        $data['slug'] = Str::slug($data['title']) . '-' . uniqid();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('business-courses', 'public');
        }

        BusinessCourse::create($data);

        return redirect()->route('admin.business-courses.index')
            ->with('success', 'Course created.');
    }

    public function edit(BusinessCourse $businessCourse)
    {
        $faculties = BusinessFaculty::orderBy('name')->get();
        return view('admin.business-university.courses.form', [
            'course' => $businessCourse,
            'faculties' => $faculties,
            'formAction' => route('admin.business-courses.update', $businessCourse),
            'formMethod' => 'POST',
            'buttonText' => 'Update Course'
        ]);
    }

    public function update(Request $request, BusinessCourse $businessCourse)
    {
        $data = $request->validate([
            'faculty_id' => 'required|exists:business_faculties,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'detailed_explanation' => 'nullable|string',
            'instructors' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|in:NGN,USD,GHS,XAF,KES',
            'image' => 'nullable|image|max:2048',
            'is_diploma' => 'boolean',
            'duration_months' => 'nullable|integer',
            'order' => 'nullable|integer',
        ]);

        if ($businessCourse->title !== $data['title']) {
            $data['slug'] = Str::slug($data['title']) . '-' . uniqid();
        }

        if ($request->hasFile('image')) {
            if ($businessCourse->image) {
                Storage::disk('public')->delete($businessCourse->image);
            }
            $data['image'] = $request->file('image')->store('business-courses', 'public');
        }

        $businessCourse->update($data);

        return redirect()->route('admin.business-courses.index')
            ->with('success', 'Course updated.');
    }

    public function destroy(BusinessCourse $businessCourse)
    {
        if ($businessCourse->lectures()->exists() || $businessCourse->enrollments()->exists()) {
            return back()->withErrors(['error' => 'Cannot delete course with existing lectures or enrollments.']);
        }
        if ($businessCourse->image) {
            Storage::disk('public')->delete($businessCourse->image);
        }
        $businessCourse->delete();
        return redirect()->route('admin.business-courses.index')
            ->with('success', 'Course deleted.');
    }
}