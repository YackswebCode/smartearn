<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyLearningController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $enrollments = Enrollment::with('track.faculty')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->get();

        return view('affiliate.my_learning', compact('enrollments'));
    }

    public function show($id)
    {
        $enrollment = Enrollment::with('track.faculty')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $track = $enrollment->track;

        return view('affiliate.learning_track', compact('track', 'enrollment'));
    }
}