<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\DigitalFaculty;
use App\Models\DigitalTrack;
use App\Models\DigitalEnrollment;
use App\Models\DigitalLecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DigitalUniversityController extends Controller
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
        $faculties = DigitalFaculty::orderBy('order')->get();
        return view('affiliate.digital_university', compact('faculties'));
    }

    public function facultyTracks($facultyId)
    {
        $faculty = DigitalFaculty::findOrFail($facultyId);
        $tracks = $faculty->tracks()->orderBy('title')->get();

        return response()->json([
            'faculty' => $faculty->name,
            'tracks'  => $tracks->map(function ($track) {
                return [
                    'id'    => $track->id,
                    'title' => $track->title,
                    'slug'  => $track->slug,
                ];
            }),
        ]);
    }

    public function trackDetails($slug)
    {
        $track = DigitalTrack::with('faculty')
            ->where('slug', $slug)
            ->firstOrFail();

        $user = Auth::user();
        $userCurrency = $user->currency;

        $alreadyEnrolled = DigitalEnrollment::where('user_id', $user->id)
            ->where('track_id', $track->id)
            ->where('status', 'active')
            ->exists();

        $plans = $this->getPlans($track, $userCurrency);

        return response()->json([
            'track' => [
                'id'           => $track->id,
                'title'        => $track->title,
                'description'  => $track->description,
                'instructors'  => $track->instructors,
                'rating'       => $track->rating,
                'reviews_count'=> $track->reviews_count,
                'duration'     => $track->duration_months . ' months',
                'is_diploma'   => $track->duration_months >= 12,
                'faculty'      => $track->faculty->name,
                'image'        => $track->image ? asset('storage/'.$track->image) : null,
                'features'     => [
                    'Citations',
                    'Convocations',
                    'Certifications',
                    'Community for portfolio building',
                    'Job recommendations'
                ],
            ],
            'already_enrolled'  => $alreadyEnrolled,
            'plans'             => $plans,
            'currency_symbol'   => $this->symbols[$userCurrency] ?? $userCurrency,
        ]);
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'track_id' => 'required|exists:digital_tracks,id',
            'plan'     => 'required|in:monthly,quarterly,one_time',
        ]);

        $track = DigitalTrack::findOrFail($request->track_id);
        $user = Auth::user();

        $existing = DigitalEnrollment::where('user_id', $user->id)
            ->where('track_id', $track->id)
            ->where('status', 'active')
            ->first();
        if ($existing) {
            return redirect()->route('affiliate.digital_university')
                ->with('error', 'You are already enrolled in this track.');
        }

        $planPrices = $this->getPlans($track, $track->currency);
        $priceInBase = $planPrices[$request->plan]['price'];
        $currency = $track->currency;
        $priceInNGN = $priceInBase * $this->toNGN[$currency];

        if ($user->wallet_balance < $priceInNGN) {
            return redirect()->route('affiliate.digital_university')
                ->with('error', 'Insufficient wallet balance. Please top up.');
        }

        DB::beginTransaction();
        try {
            $user->wallet_balance -= $priceInNGN;
            $user->save();

            DigitalEnrollment::create([
                'user_id'    => $user->id,
                'track_id'   => $track->id,
                'plan'       => $request->plan,
                'amount_paid'=> $priceInBase,
                'currency'   => $currency,
                'status'     => 'active',
                'start_date' => now(),
                'end_date'   => now()->addMonths($track->duration_months),
            ]);

            DB::commit();
            return redirect()->route('affiliate.digital.my.learning')
                ->with('success', 'Enrollment successful! Welcome to the Digital University.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('affiliate.digital_university')
                ->with('error', 'Enrollment failed: ' . $e->getMessage());
        }
    }

    public function myLearning()
    {
        $enrollments = DigitalEnrollment::with('track.faculty')
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->get();

        return view('affiliate.digital_university_my_learning', compact('enrollments'));
    }

    public function learningTrack($enrollmentId)
    {
        $enrollment = DigitalEnrollment::with('track.faculty', 'track.lectures')
            ->where('user_id', Auth::id())
            ->findOrFail($enrollmentId);
        $track = $enrollment->track;

        return view('affiliate.digital_university_learning', compact('track', 'enrollment'));
    }

    /**
     * Show individual lecture player.
     */
    public function showLecture($enrollmentId, $lectureId)
    {
        $enrollment = DigitalEnrollment::with('track')
            ->where('user_id', Auth::id())
            ->findOrFail($enrollmentId);

        $lecture = DigitalLecture::where('track_id', $enrollment->track_id)
            ->findOrFail($lectureId);

        $track = $enrollment->track;
        $lectures = $track->lectures()->orderBy('order')->get();

        return view('affiliate.digital_university_lecture', compact(
            'enrollment', 'track', 'lecture', 'lectures'
        ));
    }

    private function getPlans($track, $targetCurrency = null)
    {
        $baseCurrency = $track->currency;
        $duration = $track->duration_months;

        $monthlyPrice = $track->monthly_price ?? $track->price;
        $quarterlyPrice = $track->quarterly_price ?? round($monthlyPrice * 3 * 0.9, 2);
        $oneTimePrice = $track->one_time_price ?? round($monthlyPrice * $duration * 0.8, 2);

        $plans = [
            'monthly'   => ['label' => 'Pay Monthly', 'price' => $monthlyPrice],
            'quarterly' => ['label' => 'Pay Quarterly', 'price' => $quarterlyPrice],
            'one_time'  => ['label' => 'Pay One-Time', 'price' => $oneTimePrice],
        ];

        if ($targetCurrency && $targetCurrency !== $baseCurrency) {
            $rate = $this->toNGN[$baseCurrency] / $this->toNGN[$targetCurrency];
            foreach ($plans as $key => &$plan) {
                $plan['price'] = round($plan['price'] * $rate, 2);
            }
        }

        return $plans;
    }
}