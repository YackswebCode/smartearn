<?php
// app/Http/Controllers/Admin/EnrollmentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Enrollment::with(['user', 'track']);
        if ($request->has('status') && in_array($request->status, ['active','completed','cancelled'])) {
            $query->where('status', $request->status);
        }
        $enrollments = $query->latest()->get();
        return view('admin.skill-garage.enrollments.index', compact('enrollments'));
    }
}