<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\BusinessFaculty;
use App\Models\BusinessCourse;
use App\Models\BusinessEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BusinessUniversityController extends Controller
{
    protected $toNGN = [
        'NGN' => 1,
        'USD' => 1363.33,
        'GHS' => 127.81,
        'XAF' => 2.45,
        'KES' => 10.56,
    ];

    protected $symbols = [
        'NGN' => '₦',
        'USD' => '$',
        'GHS' => 'GH¢',
        'XAF' => 'FCFA',
        'KES' => 'KES',
    ];

    public function index()
    {
        $faculties = BusinessFaculty::orderBy('order')->get();
        $courses = BusinessCourse::with('faculty')->orderBy('order')->paginate(9);
        return view('affiliate.business_university', compact('faculties', 'courses'));
    }

    public function showCourse($slug)
    {
        $course = BusinessCourse::with('faculty', 'lectures')->where('slug', $slug)->firstOrFail();
        $user = Auth::user();
        $userCurrency = $user->currency;
        $toNGN = $this->toNGN;
        $symbols = $this->symbols;

        $enrollment = BusinessEnrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'active')
            ->first();

        return view('affiliate.business_course_detail', compact('course', 'userCurrency', 'toNGN', 'symbols', 'enrollment'));
    }

    public function enroll(Request $request, $id)
    {
        $course = BusinessCourse::findOrFail($id);
        $user = Auth::user();

        // Check if already enrolled
        $existing = BusinessEnrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'active')
            ->first();
        if ($existing) {
            return redirect()->route('affiliate.business.course', $course->slug)
                ->with('error', 'You are already enrolled in this course.');
        }

        // Price in NGN
        $priceInCourseCurrency = $course->price;
        $priceInNGN = $priceInCourseCurrency * $this->toNGN[$course->currency];

        if ($user->wallet_balance < $priceInNGN) {
            return back()->with('error', 'Insufficient wallet balance.');
        }

        DB::beginTransaction();
        try {
            // Deduct from wallet
            $user->wallet_balance -= $priceInNGN;
            $user->save();

            // Create enrollment (no plan for simplicity, but you can add later)
            $enrollment = BusinessEnrollment::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'plan' => null,
                'amount_paid' => $priceInCourseCurrency,
                'currency' => $course->currency,
                'status' => 'active',
                'start_date' => now(),
                'end_date' => now()->addMonths($course->duration_months ?? 12),
            ]);

            DB::commit();

            return redirect()->route('affiliate.business.course', $course->slug)
                ->with('success', 'Enrollment successful! You can now access the course.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Enrollment failed: ' . $e->getMessage());
        }
    }

    public function myLearning()
    {
        $user = Auth::user();
        $enrollments = BusinessEnrollment::with('course.faculty')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->get();

        return view('affiliate.business_my_learning', compact('enrollments'));
    }

    public function learningCourse($id)
    {
        $enrollment = BusinessEnrollment::with('course.faculty', 'course.lectures')
            ->where('user_id', Auth::id())
            ->findOrFail($id);
        $course = $enrollment->course;

        return view('affiliate.business_learning_course', compact('course', 'enrollment'));
    }
}