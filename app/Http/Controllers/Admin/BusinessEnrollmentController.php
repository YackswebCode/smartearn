<?php
// app/Http/Controllers/Admin/BusinessEnrollmentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessEnrollment;
use Illuminate\Http\Request;

class BusinessEnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = BusinessEnrollment::with('user', 'course');

        if ($request->has('status') && in_array($request->status, ['active', 'completed', 'cancelled'])) {
            $query->where('status', $request->status);
        }

        $enrollments = $query->latest()->get();

        return view('admin.business-university.enrollments.index', compact('enrollments'));
    }
}