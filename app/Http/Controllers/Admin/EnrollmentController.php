<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalEnrollment;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = DigitalEnrollment::with('user', 'track.faculty')
            ->latest()
            ->paginate(20);

        return view('admin.enrollments.index', compact('enrollments'));
    }
}